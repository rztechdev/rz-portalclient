<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Services\WhatsApp\FlustraWhatsAppService;
use App\Services\WhatsApp\PortalWhatsAppTemplates;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class InternalSyncController extends Controller
{
    protected FlustraWhatsAppService $waService;

    public function __construct(FlustraWhatsAppService $waService)
    {
        $this->waService = $waService;
    }

    /**
     * Endpoint to receive synchronized client & project from RZ CRM.
     * Protected by X-Internal-Secret header.
     */
    public function syncClientProject(Request $request): JsonResponse
    {
        $configuredSecret = config('flustra.internal_api_secret', env('INTERNAL_API_SECRET', 'rz_portal_sync_secret_key_2026'));
        $providedSecret = $request->header('X-Internal-Secret') 
            ?? $request->bearerToken() 
            ?? $request->input('secret');

        if (empty($configuredSecret) || !hash_equals((string) $configuredSecret, (string) $providedSecret)) {
            Log::warning('Internal Sync Portal: Unauthorized access attempt', [
                'ip' => $request->ip(),
                'headers' => $request->headers->all(),
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Akses ditolak. Token rahasia internal tidak valid.',
            ], 401);
        }

        // 2. Validate Request
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'nullable|string|max:30',
            'project_name' => 'required|string|max:255',
            'project_description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'send_wa_invite' => 'nullable|boolean',
        ]);

        $normalizedPhone = !empty($validated['client_phone']) 
            ? $this->waService->normalizePhoneNumber($validated['client_phone']) 
            : null;

        // 3. Find or Create Client User
        $user = User::where('email', $validated['client_email'])->first();
        $isNewUser = false;
        $rawPassword = null;

        if ($user) {
            // Existing user: update phone if missing
            if (empty($user->phone) && $normalizedPhone) {
                $user->update(['phone' => $normalizedPhone]);
            }
            if (!$user->hasRole('client')) {
                $user->assignRole('client');
            }
        } else {
            // New user: generate friendly password
            $isNewUser = true;
            $rawPassword = 'RZ' . rand(100000, 999999);

            $user = User::create([
                'name' => $validated['client_name'],
                'email' => $validated['client_email'],
                'phone' => $normalizedPhone,
                'password' => Hash::make($rawPassword),
                'email_verified_at' => now(),
            ]);

            $user->assignRole('client');
        }

        // 4. Find or Create Project
        $crmStatus = $request->input('project_status');
        $portalStatus = match($crmStatus) {
            'selesai' => 'completed',
            'dibatalkan' => 'archived',
            'draft' => 'pending',
            default => 'active', // dp_diterima, dikerjakan, review are active
        };

        $project = Project::where('client_id', $user->id)
            ->where('name', $validated['project_name'])
            ->first();

        $linkWebsite = $request->input('link_website');

        if (!$project) {
            $project = Project::create([
                'name' => $validated['project_name'],
                'description' => $validated['project_description'] ?? 'Proyek disinkronkan dari RZ CRM',
                'link_website' => $linkWebsite,
                'status' => $portalStatus,
                'start_date' => $validated['start_date'] ?? now()->toDateString(),
                'end_date' => $validated['end_date'] ?? null,
                'client_id' => $user->id,
            ]);
        } else {
            $projectUpdates = [
                'status' => $portalStatus,
                'description' => $validated['project_description'] ?? $project->description,
                'end_date' => $validated['end_date'] ?? $project->end_date,
            ];
            if ($linkWebsite) {
                $projectUpdates['link_website'] = $linkWebsite;
            }
            $project->update($projectUpdates);
        }

        // 4a. Synchronize Subscription Data from CRM
        if ($request->has('subscription') && is_array($request->input('subscription'))) {
            $sub = $request->input('subscription');
            $project->update([
                'subscription_type'    => $sub['tipe'] ?? null,
                'subscription_price'   => (int) ($sub['harga'] ?? 0),
                'subscription_start'   => $sub['tanggal_mulai'] ?? null,
                'subscription_expired' => $sub['tanggal_expired'] ?? null,
                'subscription_status'  => $sub['status'] ?? 'aktif',
                'auto_renew'           => (bool) ($sub['auto_renew'] ?? false),
            ]);
        }

        // 4b. Synchronize Kanban Task Column (dikerjakan -> in_progress, review -> review, selesai -> done, draft/dp -> todo)
        $kanbanTaskStatus = match($crmStatus) {
            'dikerjakan'  => 'in_progress',
            'review'      => 'review',
            'selesai'     => 'done',
            'draft'       => 'todo',
            'dp_diterima' => 'todo',
            default       => null,
        };

        $existingTasks = Task::where('project_id', $project->id)->get();
        if ($existingTasks->isEmpty()) {
            Task::create([
                'project_id'  => $project->id,
                'name'        => 'Pengerjaan ' . $project->name,
                'description' => 'Tugas utama pengerjaan website dari CRM.',
                'status'      => $kanbanTaskStatus ?: 'todo',
                'priority'    => 'medium',
                'assignee_id' => $project->manager_id ?? $user->id,
            ]);
        } elseif ($kanbanTaskStatus) {
            foreach ($existingTasks as $t) {
                $t->update(['status' => $kanbanTaskStatus]);
            }
        }

        // 4c. Create or Update Invoice for this Project
        $invoiceNumber = $request->input('invoice_number') 
            ?? ('INV/' . now()->format('Ym') . '/' . str_pad($project->id, 4, '0', STR_PAD_LEFT));
        $amount = (float) $request->input('amount', 0);
        $incomingPaidAmount = (float) $request->input('paid_amount', 0);
        $incomingBalanceDue = $request->input('balance_due');

        $existingInvoice = Invoice::where('project_id', $project->id)
            ->where('invoice_number', $invoiceNumber)
            ->first();

        // If existing invoice on portal already recorded a higher payment (e.g. DP verified on portal), preserve it!
        if ($existingInvoice && (float)$existingInvoice->paid_amount > $incomingPaidAmount) {
            $paidAmount = (float) $existingInvoice->paid_amount;
            $balanceDue = max(0, $amount - $paidAmount);
            $invoiceStatus = $existingInvoice->status;
        } else {
            $paidAmount = $incomingPaidAmount;
            $balanceDue = ($incomingBalanceDue !== null && $incomingBalanceDue !== '') 
                ? (float) $incomingBalanceDue 
                : max(0, $amount - $paidAmount);

            $paymentStatus = $request->input('payment_status');
            if ($paymentStatus === 'lunas' || ($paidAmount >= $amount && $amount > 0)) {
                $invoiceStatus = 'paid';
            } elseif ($paymentStatus === 'dp_diterima' || $paidAmount > 0) {
                $invoiceStatus = 'partially_paid';
            } else {
                $invoiceStatus = 'unpaid';
            }
        }

        $adminUser = User::role('admin')->first();

        $invoiceData = [
            'client_id' => $user->id,
            'title' => "Invoice Pengerjaan " . $project->name,
            'amount' => $amount,
            'paid_amount' => $paidAmount,
            'balance_due' => $balanceDue,
            'status' => $invoiceStatus,
            'due_date' => now()->addDays(7)->toDateString(),
        ];

        if ($paidAmount > 0 && empty($existingInvoice?->verified_by)) {
            $invoiceData['verified_by'] = $adminUser?->id;
            $invoiceData['verified_at'] = now();
        }

        $invoice = Invoice::updateOrCreate(
            [
                'project_id' => $project->id,
                'invoice_number' => $invoiceNumber,
            ],
            $invoiceData
        );

        // 4.5. Synchronize Company Settings if supplied by CRM
        if ($request->has('company_settings') && is_array($request->input('company_settings'))) {
            try {
                $settingRecord = \App\Models\CompanySetting::get();
                $settingRecord->update(array_filter($request->input('company_settings')));
            } catch (\Throwable $e) {
                Log::warning('Internal Sync: Gagal update company_settings di Portal: ' . $e->getMessage());
            }
        }

        // 5. Send WhatsApp notification / credentials to Client
        $waSent = false;
        $sendWa = $request->boolean('send_wa_invite', true);

        if ($sendWa && !empty($user->phone)) {
            $portalUrl = config('app.url', 'https://portalclient.rzdigitalcreative.my.id');

            if ($isNewUser && $rawPassword) {
                $message = PortalWhatsAppTemplates::welcomeClientAccount(
                    name: $user->name,
                    projectName: $project->name,
                    email: $user->email,
                    rawPassword: $rawPassword,
                    portalUrl: $portalUrl
                );
            } else {
                $message = PortalWhatsAppTemplates::existingClientNewProject(
                    name: $user->name,
                    projectName: $project->name,
                    portalUrl: $portalUrl
                );
            }

            $waRes = $this->waService->sendWhatsApp($user->phone, $message);
            $waSent = $waRes['success'] ?? false;
        }

        Log::info("Internal Sync Portal: Sukses sinkronisasi klien {$user->name} & proyek {$project->name}", [
            'user_id' => $user->id,
            'is_new_user' => $isNewUser,
            'project_id' => $project->id,
            'invoice_id' => $invoice->id,
            'wa_sent' => $waSent,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Akun klien, proyek, dan tagihan berhasil disinkronkan ke Portal.',
            'data' => [
                'user_id' => $user->id,
                'client_name' => $user->name,
                'client_email' => $user->email,
                'client_phone' => $user->phone,
                'is_new_user' => $isNewUser,
                'default_password' => $rawPassword,
                'project_id' => $project->id,
                'project_name' => $project->name,
                'invoice_id' => $invoice->id,
                'invoice_number' => $invoice->invoice_number,
                'amount' => $invoice->amount,
                'paid_amount' => $invoice->paid_amount,
                'balance_due' => $invoice->balance_due,
                'invoice_status' => $invoice->status,
                'wa_sent' => $waSent,
                'subscription' => $project->subscription_type ? [
                    'type'    => $project->subscription_type,
                    'status'  => $project->subscription_status,
                    'expired' => $project->subscription_expired?->toDateString(),
                ] : null,
            ],
        ]);
    }

    /**
     * Endpoint for CRM to fetch subscription status of a project.
     * GET /api/internal/v1/subscription-status/{project}
     */
    public function subscriptionStatus(Request $request, Project $project): JsonResponse
    {
        $configuredSecret = config('flustra.internal_api_secret', env('INTERNAL_API_SECRET', 'rz_portal_sync_secret_key_2026'));
        $providedSecret = $request->header('X-Internal-Secret')
            ?? $request->bearerToken()
            ?? $request->input('secret');

        if (empty($configuredSecret) || !hash_equals((string) $configuredSecret, (string) $providedSecret)) {
            return response()->json([
                'success' => false,
                'error' => 'Akses ditolak. Token rahasia internal tidak valid.',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'project_id'          => $project->id,
                'project_name'        => $project->name,
                'subscription_type'   => $project->subscription_type,
                'subscription_price'  => $project->subscription_price,
                'subscription_start'  => $project->subscription_start?->toDateString(),
                'subscription_expired' => $project->subscription_expired?->toDateString(),
                'subscription_status' => $project->subscription_status,
                'subscription_status_label' => $project->subscription_status_label,
                'sisa_hari'           => $project->subscription_sisa_hari,
                'auto_renew'          => $project->auto_renew,
            ],
        ]);
    }
}
