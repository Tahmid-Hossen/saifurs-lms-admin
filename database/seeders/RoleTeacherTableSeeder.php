<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTeacherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::whereEmail('teacher1@teacher.com')->first();
        $user2 = User::whereEmail('teacher2@teacher.com')->first();
        $user3 = User::whereEmail('teacher3@teacher.com')->first();
        $user4 = User::whereEmail('teacher4@teacher.com')->first();
        $user5 = User::whereEmail('teacher5@teacher.com')->first();

        $instructorRole = Role::whereName('Instructor')->first();

        $user->assignRole($instructorRole);
        $user2->assignRole($instructorRole);
        $user3->assignRole($instructorRole);
        $user4->assignRole($instructorRole);
        $user5->assignRole($instructorRole);
    }
}
