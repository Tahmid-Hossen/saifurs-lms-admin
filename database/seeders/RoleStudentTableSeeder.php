<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleStudentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereEmail('student1@student.com')->first();
        $user2 = User::whereEmail('student2@student.com')->first();
        $user3 = User::whereEmail('student3@student.com')->first();
        $user4 = User::whereEmail('student4@student.com')->first();
        $user5 = User::whereEmail('student5@student.com')->first();

        $studentRole = Role::whereName('Student')->first();

        $user->assignRole($studentRole);
        $user2->assignRole($studentRole);
        $user3->assignRole($studentRole);
        $user4->assignRole($studentRole);
        $user5->assignRole($studentRole);
    }
}
