<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $ceoRole = Role::firstOrCreate(['name' => 'ceo']);
        $technicianRole = Role::firstOrCreate(['name' => 'technician']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@rzdigitalcreative.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('12345678'),
            ]
        );
        $admin->assignRole($adminRole);

        // Create CEO User (read-only executive dashboard)
        $ceo = User::firstOrCreate(
            ['email' => 'ceo@rzdigitalcreative.com'],
            [
                'name' => 'CEO User',
                'password' => Hash::make('12345678'),
            ]
        );
        $ceo->assignRole($ceoRole);

        // Create Technician User
        $tech = User::firstOrCreate(
            ['email' => 'tech@rzdigitalcreative.com'],
            [
                'name' => 'Technician User',
                'password' => Hash::make('12345678'),
            ]
        );
        $tech->assignRole($technicianRole);

        // Create Client User
        $client = User::firstOrCreate(
            ['email' => 'client@rzdigitalcreative.com'],
            [
                'name' => 'Client User',
                'password' => Hash::make('12345678'),
            ]
        );
        $client->assignRole($clientRole);
    }
}
