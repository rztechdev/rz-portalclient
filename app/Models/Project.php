<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'link_website',
        'status',
        'start_date',
        'end_date',
        'client_id',
        'manager_id',
        'ticket_id',
        'subscription_type',
        'subscription_price',
        'subscription_start',
        'subscription_expired',
        'subscription_status',
        'auto_renew',
    ];

    protected function casts(): array
    {
        return [
            'subscription_start' => 'date',
            'subscription_expired' => 'date',
            'subscription_price' => 'integer',
            'auto_renew' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::updated(function (Project $project) {
            if ($project->wasChanged('status')) {
                $previousStatus = $project->ticket?->status;
                $project->syncLinkedTicketStatus();

                if ($project->ticket_id && $project->ticket) {
                    app(\App\Services\TicketWorkflowService::class)
                        ->afterLinkedTicketSynced($project->ticket->fresh(), $previousStatus);
                }
            }

        });
    }

    /**
     * Sinkronkan status tiket terkait berdasarkan status proyek.
     * Status tiket: open, pending, resolved, closed (bukan status proyek).
     */
    public function syncLinkedTicketStatus(): void
    {
        if (!$this->ticket_id) {
            return;
        }

        $ticket = $this->ticket;
        if (!$ticket) {
            return;
        }

        if ($this->status === 'completed') {
            $updates = ['status' => 'resolved'];
            if (!$ticket->resolved_at) {
                $updates['resolved_at'] = now();
            }
            $ticket->update($updates);
            return;
        }

        if ($this->status === 'archived') {
            $ticket->update([
                'status' => 'closed',
                'resolved_at' => $ticket->resolved_at ?? now(),
            ]);
        }
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function latestInvoice()
    {
        return $this->hasOne(Invoice::class)->latestOfMany();
    }

    public function getSubscriptionTypeLabelAttribute(): ?string
    {
        return match ($this->subscription_type) {
            'tahunan' => 'Tahunan',
            'bulanan' => 'Bulanan',
            '6_bulan' => '6 Bulan',
            'custom'  => 'Custom',
            default   => null,
        };
    }

    public function getSubscriptionStatusLabelAttribute(): ?string
    {
        return match ($this->subscription_status) {
            'aktif'        => 'Aktif',
            'akan_expired' => 'Akan Expired',
            'expired'      => 'Expired',
            'diperpanjang' => 'Diperpanjang',
            'nonaktif'     => 'Nonaktif',
            default        => null,
        };
    }

    public function getSubscriptionStatusColorAttribute(): string
    {
        return match ($this->subscription_status) {
            'aktif'        => 'emerald',
            'akan_expired' => 'amber',
            'expired'      => 'red',
            'diperpanjang' => 'sky',
            'nonaktif'     => 'zinc',
            default        => 'zinc',
        };
    }

    public function getSubscriptionSisaHariAttribute(): ?int
    {
        if (! $this->subscription_expired) {
            return null;
        }

        return (int) Carbon::now()->startOfDay()->diffInDays($this->subscription_expired, false);
    }

    public function hasActiveSubscription(): bool
    {
        return $this->subscription_type !== null
            && $this->subscription_status !== null
            && $this->subscription_status !== 'nonaktif';
    }

    /**
     * Hitung persentase progress keseluruhan proyek secara bertahap (weighted lifecycle).
     * - todo: 10% (antrean/inisiasi)
     * - in_progress: 50% (sedang dikerjakan)
     * - review: 85% (tahap peninjauan/review klien)
     * - done: 100% (selesai)
     */
    public function getProgressPercentageAttribute(): int
    {
        if ($this->status === 'completed') {
            return 100;
        }

        $tasks = $this->tasks;
        if ($tasks->isEmpty()) {
            return match($this->status) {
                'completed' => 100,
                'active'    => 50,
                default     => 0,
            };
        }

        $total = $tasks->count();
        $sum = 0;
        foreach ($tasks as $task) {
            $sum += match($task->status) {
                'done'        => 100,
                'review'      => 85,
                'in_progress' => 50,
                'todo'        => 10,
                default       => 0,
            };
        }

        return (int) round($sum / $total);
    }
}
