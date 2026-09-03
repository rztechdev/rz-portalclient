<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Katalog izin (permission) sistem.
     *
     * Dikelompokkan agar mudah ditampilkan di Panel Admin > Role.
     * Menambah fitur baru? Cukup tambahkan izinnya di sini lalu jalankan
     * `php artisan db:seed --class=RoleAndPermissionSeeder`.
     *
     * @var array<string, array<string, string>>
     */
    public const PERMISSIONS = [
        'Dashboard' => [
            'dashboard.view' => 'Melihat dashboard',
        ],
        'Tiket' => [
            'tickets.create' => 'Membuat tiket (klien)',
            'tickets.view' => 'Melihat tiket',
            'tickets.handle' => 'Menangani tiket (teknisi)',
            'tickets.manage' => 'Kelola & tugaskan tiket (admin)',
        ],
        'Proyek' => [
            'projects.view' => 'Melihat proyek',
            'projects.manage' => 'Kelola proyek (buat/ubah/hapus)',
        ],
        'Tugas' => [
            'tasks.view' => 'Melihat tugas',
            'tasks.manage' => 'Kelola tugas (buat/ubah/hapus)',
            'tasks.update_progress' => 'Perbarui progres tugas (teknisi)',
        ],
        'Dokumen' => [
            'documents.manage' => 'Unggah & hapus dokumen',
        ],
        'Administrasi' => [
            'users.manage' => 'Kelola pengguna',
            'roles.manage' => 'Kelola role & hak akses',
        ],
    ];

    /**
     * Preset role bawaan beserta izinnya.
     * Admin mendapatkan seluruh izin secara otomatis (lihat di bawah).
     *
     * @var array<string, array<int, string>>
     */
    public const ROLE_PRESETS = [
        'ceo' => [
            'dashboard.view', 'tickets.view', 'projects.view', 'tasks.view',
        ],
        'technician' => [
            'dashboard.view', 'tickets.view', 'tickets.handle',
            'projects.view', 'tasks.view', 'tasks.update_progress', 'documents.manage',
        ],
        'client' => [
            'dashboard.view', 'tickets.create', 'tickets.view',
            'projects.view', 'tasks.view',
        ],
    ];

    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat/sinkronkan seluruh izin dari katalog.
        $allPermissions = [];
        foreach (self::PERMISSIONS as $group) {
            foreach ($group as $name => $label) {
                Permission::firstOrCreate(['name' => $name]);
                $allPermissions[] = $name;
            }
        }

        // 2. Role admin: selalu memegang SEMUA izin (super admin).
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($allPermissions);

        // 3. Preset role lain sebagai titik awal (bisa diubah admin lewat UI).
        foreach (self::ROLE_PRESETS as $roleName => $permissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);

            // Hanya isi izin default saat role pertama kali dibuat, agar
            // perubahan yang dilakukan admin lewat UI tidak tertimpa ulang.
            if ($role->wasRecentlyCreated) {
                $role->syncPermissions($permissions);
            }
        }

        // 4. Seed HANYA satu akun admin, kredensialnya diselaraskan dari .env / CRM
        $targetEmail = config('portal.admin.email', env('ADMIN_EMAIL', 'rzcompanyidn@gmail.com'));
        $targetName = config('portal.admin.name', env('ADMIN_NAME', 'Owner RZ Digital'));
        $targetPassword = config('portal.admin.password', env('ADMIN_PASSWORD', '12345678'));

        // Jika ada akun admin lama (misal rztechdevidn@gmail.com), migrasikan ke email admin resmi
        $oldAdmin = User::where('email', 'rztechdevidn@gmail.com')->first();
        if ($oldAdmin && $oldAdmin->email !== $targetEmail) {
            $oldAdmin->update([
                'email' => $targetEmail,
                'name' => $targetName,
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

        if (! $admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }
    }
}
