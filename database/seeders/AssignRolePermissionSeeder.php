<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AssignRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Role::all();
        $allPermissions = Permission::all()->pluck('id');
        $signPermission = Permission::where('name', '=', 'backend.signin')->first();
        $dashboardPermission = Permission::where('name', '=', 'dashboard')->first();

        foreach ($roles as $role) {
            //Super Admin Privileges
            if ($role->name == 'Super Admin') {
                $role->permissions()->syncWithoutDetaching($allPermissions);
            }


            if ($role->name == 'Admin') {
                $role->permissions()->syncWithoutDetaching($signPermission->id);
                $role->permissions()->syncWithoutDetaching($dashboardPermission->id);
            }


            elseif ($role->name == 'Management') {
                $role->permissions()->syncWithoutDetaching($signPermission->id);
                $role->permissions()->syncWithoutDetaching($dashboardPermission->id);
            }


            elseif ($role->name == 'Accountant') {
                $role->permissions()->syncWithoutDetaching($signPermission->id);
                $role->permissions()->syncWithoutDetaching($dashboardPermission->id);
            }

            elseif ($role->name == 'Instructor') {
                $role->permissions()->syncWithoutDetaching($signPermission->id);
                $role->permissions()->syncWithoutDetaching($dashboardPermission->id);
            }

            elseif ($role->name == 'Member') {
                $role->permissions()->syncWithoutDetaching($signPermission->id);
                $role->permissions()->syncWithoutDetaching($dashboardPermission->id);
            }
        }
    }
}
