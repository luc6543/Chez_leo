<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $adminRole = Role::findOrCreate('admin');
        $role = Role::findOrCreate('medewerker');
        $defaultRole = Role::findOrCreate('klant');
        $adminPermissions = [];

        $exhibitorAdminPermissions = [];

        $defaultPermissions = [];

        foreach ($adminPermissions as $permission) {
            $permission = Permission::findOrCreate($permission);
            $adminRole->givePermissionTo($permission);
        }

        foreach($exhibitorAdminPermissions as $permission) {
            $permission = Permission::findOrCreate($permission);
            $role->givePermissionTo($permission);
        }

        foreach($defaultPermissions as $permission) {
            $permission = Permission::findOrCreate($permission);
            $defaultRole->givePermissionTo($permission);
        }
    }
}
