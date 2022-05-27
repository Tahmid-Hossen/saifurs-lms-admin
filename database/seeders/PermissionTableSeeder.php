<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return string
     */
    public function run()
    {
        $routes = Route::getRoutes();

        $user = User::where('email','admin@aleshatech-lms.com')->first();
        $adminRole = Role::whereName('Super Admin')->first();

        foreach($routes as $route)
        {
            if($route->getName()!=''){
                $getName = explode('.',$route->getName());

                if(count($getName)>1 && count($getName)<3){
                    if(
                        array_search(
                            $getName[1],
                            array(
                                '--',
                                'index', 'create', 'store', 'edit', 'update', 'show', 'destroy',
                                'defuse', 'user-nearest',
                                'roles', 'groups', 'permissions', 'signin',
                                'services',
                                'bulk-data-upload-form',
                                'approve',
                                'own',
                                'assign-point-store','user-point-assign','user-profile-active',
                                'custom-destroy', 'currency-rate-custom-display',
                                'change-pin', 'send-push-notification',
                                'reject', 'accept', 'cancel', 'successful', 'processes', 'release',
                                'yearly','monthly','daily',
                                'find-user-name',
                                'assignment-review',
                                'download',
                                'dashboard',
                                'success', 'failure', 'cancel', 'ipn','query',
                                'archive'
                            )
                        )
                    ){
                        $record = Permission::where('name','=',$route->getName()?$route->getName():'n/a')->first();
                        if (is_null($record)) {
                            Permission::create([
                                'name' => $route->getName()?$route->getName():'n/a',
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
                            $adminPermission = Permission::whereName($route->getName()?$route->getName():'n/a')->first();
                            $user->givePermissionTo($adminPermission);
                            $adminRole->givePermissionTo($adminPermission);
                        }
                    }elseif($getName[0] == 'reports'){
                        $record = Permission::where('name','=',$route->getName()?$route->getName():'n/a')->first();
                        if (is_null($record)) {
                            Permission::create([
                                'name' => $route->getName()?$route->getName():'n/a',
                                'created_at' => date('Y-m-d H:i:s')
                            ]);
                            $adminPermission = Permission::whereName($route->getName()?$route->getName():'n/a')->first();
                            $user->givePermissionTo($adminPermission);
                            $adminRole->givePermissionTo($adminPermission);
                        }
                    }
                }
            }
        }
        return 'insert successfully.';
    }
}
