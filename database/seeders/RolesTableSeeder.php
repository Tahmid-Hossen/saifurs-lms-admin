<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::create([
            'name' => 'Super Admin',
            'access_permissions' => 'all'
        ]);

        Role::create([
            'name' => 'Admin',
            'access_permissions' => 'all'
        ]);

        Role::create([
            'name' => 'Management',
            'access_permissions' => 'all'
        ]);

        Role::create([
            'name' => 'Accountant'
        ]);

        Role::create([
            'name' => 'Student',
            'access_permissions' => 'myAccount,myQuiz,attemptQuiz,myResult,resultView'
        ]);

        Role::create([
            'name' => 'Instructor',
            'access_permissions' => 'all'
        ]);

        Role::create([
            'name' => 'Member',
            'access_permissions' => 'myAccount,myQuiz,attemptQuiz,myResult,resultView'
        ]);

        Role::create([
            'name' => 'Guest Instructor',
            'access_permissions' => 'all'
        ]);

    }
}
