<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Goals
            'view goals',
            'create goals',
            'edit goals',
            'delete goals',
            'manage team goals',
            
            // Team Management
            'manage team',
            'view team members',
            'add team members',
            'remove team members',
            
            // Reviews & Feedback
            'give feedback',
            'view feedback',
            'manage reviews',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $roles = [
            'super-admin' => $permissions,
            'team-lead' => [
                'view goals',
                'create goals',
                'edit goals',
                'delete goals',
                'manage team goals',
                'manage team',
                'view team members',
                'add team members',
                'remove team members',
                'give feedback',
                'view feedback',
                'manage reviews',
            ],
            'team-member' => [
                'view goals',
                'create goals',
                'edit goals',
                'give feedback',
                'view feedback',
            ],
        ];

        foreach ($roles as $role => $rolePermissions) {
            $role = Role::create(['name' => $role]);
            $role->givePermissionTo($rolePermissions);
        }
    }
} 