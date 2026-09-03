<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $targetEmail = config('portal.admin.email', env('ADMIN_EMAIL', 'rzcompanyidn@gmail.com'));
        $targetName = config('portal.admin.name', env('ADMIN_NAME', 'Owner RZ Digital'));
        $targetPassword = config('portal.admin.password', env('ADMIN_PASSWORD', '12345678'));

        // 1. Migrasikan akun admin lama jika ada (rztechdevidn@gmail.com)
        $oldAdmin = User::where('email', 'rztechdevidn@gmail.com')->first();
        if ($oldAdmin && $oldAdmin->email !== $targetEmail) {
            $oldAdmin->update([
                'name' => $targetName,
                'email' => $targetEmail,
                'password' => Hash::make($targetPassword),
            ]);
            $admin = $oldAdmin;
        } else {
            $admin = User::updateOrCreate(
                ['email' => $targetEmail],
                [
                    'name' => $targetName,
                    'password' => Hash::make($targetPassword),
                    'email_verified_at' => now(),
                ]
            );
        }

        // 2. Pastikan role admin tersedia dan terhubung ke user admin
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        if (!$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No-op
    }
};
