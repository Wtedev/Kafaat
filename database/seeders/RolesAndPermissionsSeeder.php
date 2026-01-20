<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $guard = 'web';

        $permissions = [
            'users.view', 'users.create', 'users.update', 'users.delete',
            'roles.manage',
            'programs.view', 'programs.create', 'programs.update', 'programs.delete', 'programs.view_registrations',
            'opportunities.view', 'opportunities.create', 'opportunities.update', 'opportunities.delete', 'opportunities.view_registrations',
            'registrations.register', 'registrations.complete', 'registrations.approve_hours',
            'certificates.issue', 'certificates.view_any',
            'emails.send',
            'stats.view_any',
        ];

        // Create permissions explicitly with guard_name
        foreach ($permissions as $name) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => $guard,
            ]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => $guard]);
        $employee = Role::firstOrCreate(['name' => 'employee', 'guard_name' => $guard]);
        $user = Role::firstOrCreate(['name' => 'user', 'guard_name' => $guard]);

        // IMPORTANT: pass Permission models (not strings)
        $allPermModels = Permission::query()
            ->where('guard_name', $guard)
            ->whereIn('name', $permissions)
            ->get();

        $admin->syncPermissions($allPermModels);

        $employeePerms = [
            'programs.view', 'programs.create', 'programs.update', 'programs.delete', 'programs.view_registrations',
            'opportunities.view', 'opportunities.create', 'opportunities.update', 'opportunities.delete', 'opportunities.view_registrations',
            'registrations.complete', 'registrations.approve_hours',
            'certificates.issue',
            'emails.send',
            'stats.view_any',
        ];

        $employee->syncPermissions(
            Permission::query()->where('guard_name', $guard)->whereIn('name', $employeePerms)->get()
        );

        $userPerms = [
            'programs.view',
            'opportunities.view',
            'registrations.register',
        ];

        $user->syncPermissions(
            Permission::query()->where('guard_name', $guard)->whereIn('name', $userPerms)->get()
        );
    }
}
