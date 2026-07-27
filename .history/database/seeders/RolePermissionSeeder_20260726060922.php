<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Modules covered by the permission matrix. Each gets
     * view / create / edit / delete / approve permissions.
     */
    protected array $modules = [
        'dashboard', 'donors', 'beneficiaries', 'sponsorships', 'volunteers',
        'staff', 'projects', 'campaigns', 'donations', 'grants', 'finance',
        'inventory', 'events', 'communication', 'documents', 'reports',
        'settings', 'roles', 'organizations',
    ];

    protected array $actions = ['view', 'create', 'edit', 'delete', 'approve', 'export'];

    public function run(): void
    {
        $permissions = [];
        foreach ($this->modules as $module) {
            foreach ($this->actions as $action) {
                $permissions[] = "{$module}.{$action}";
            }
        }

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        $roles = [
            'Super Administrator' => $permissions, // everything, across all organizations
            'Organization Administrator' => $permissions,
            'Finance Officer' => $this->only(['dashboard', 'finance', 'grants', 'donations', 'reports'], ['view', 'create', 'edit', 'approve', 'export']),
            'Project Manager' => $this->only(['dashboard', 'projects', 'campaigns', 'beneficiaries', 'grants', 'reports'], ['view', 'create', 'edit', 'export']),
            'Case Worker' => $this->only(['dashboard', 'beneficiaries', 'sponsorships'], ['view', 'create', 'edit']),
            'Volunteer Coordinator' => $this->only(['dashboard', 'volunteers', 'events'], ['view', 'create', 'edit', 'approve']),
            'Field Officer' => $this->only(['dashboard', 'beneficiaries', 'donors'], ['view', 'create', 'edit']),
            'Data Entry Officer' => $this->only(['donors', 'donations', 'beneficiaries'], ['view', 'create']),
            'Donor' => $this->only(['campaigns', 'donations'], ['view']),
            'Sponsor' => $this->only(['campaigns', 'sponsorships'], ['view']),
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
            $role->syncPermissions($rolePermissions);
        }
    }

    protected function only(array $modules, array $actions): array
    {
        $result = [];
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $result[] = "{$module}.{$action}";
            }
        }
        return $result;
    }
}
