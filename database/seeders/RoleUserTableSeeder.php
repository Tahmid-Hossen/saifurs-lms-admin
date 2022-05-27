<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereEmail('admin@aleshatech-lms.com')->first();
        $user2 = User::whereEmail('content-uploader@aleshatech-lms.com')->first();
        $udvash = User::whereEmail('info@udvash.com')->first();
        $saifursGroup = User::whereEmail('info@saifursgroup.com')->first();
        $retinabd = User::whereEmail('info@retinabd.com')->first();

        $superAdminRole = Role::whereName('Super Admin')->first();
        $adminRole = Role::whereName('Admin')->first();
        $instructorRole = Role::whereName('Instructor')->first();

        $user->assignRole($superAdminRole);
        $user2->assignRole($instructorRole);
        $udvash->assignRole($adminRole);
        $saifursGroup->assignRole($adminRole);
        $retinabd->assignRole($adminRole);
    }
}
