<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = ['superadmin', 'admin', 'tailor', 'customer', 'user', 'staff'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $this->createUsers();
        $this->assignBasicPermissions();
    }

    private function createUsers(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'role' => 'superadmin',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'role' => 'admin',
            ]
        ];

        $branchId = Branch::value('id');

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'branch_id' => $userData['role'] === 'admin' ? $branchId : null,
                ]
            );

            if ($userData['role'] === 'admin' && $branchId) {
                $user->update(['branch_id' => $branchId]);
            }

            $user->assignRole($userData['role']);
            $this->command->info("{$userData['name']} created: {$userData['email']}");
        }
    }

    private function assignBasicPermissions(): void
    {
        $permissions = [
            'view dashboard',
            'manage users',
            'manage roles',
            'manage permissions',
            'create order',
            'view orders',
            'manage products',
            'view reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superadminRole = Role::where('name', 'superadmin')->first();
        if ($superadminRole) {
            $superadminRole->givePermissionTo(Permission::all());
        }

        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminPermissions = ['view dashboard', 'manage users', 'view orders', 'view reports'];
            $adminRole->givePermissionTo($adminPermissions);
        }
    }
}
