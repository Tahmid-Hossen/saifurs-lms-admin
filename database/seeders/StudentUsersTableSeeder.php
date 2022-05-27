<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\Configs\Constants;
use Illuminate\Database\Seeder;

class StudentUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(array(
            'username' => 'student1',
            'name' => 'student1',
            'email' => 'student1@student.com',
            'mobile_number' => '8801614000020',
            'status' => Constants::$user_active_status,
            'password' => bcrypt(123456)
        ));
        User::create([
            'username' => 'student2',
            'name' => 'student2',
            'email' => 'student2@student.com',
            'mobile_number' => '8801714000022',
            'password' => bcrypt('123456'),
            'status' => Constants::$user_active_status,
        ]);
        User::create([
            'username' => 'student3',
            'name' => 'student3',
            'email' => 'student3@student.com',
            'mobile_number' => '01614000024',
            'password' => bcrypt('123456'),
            'status' => Constants::$user_active_status,
        ]);
        User::create([
            'username' => 'student4',
            'name' => 'student4',
            'email' => 'student4@student.com',
            'mobile_number' => '01614000026',
            'password' => bcrypt('123456'),
            'status' => Constants::$user_active_status,
        ]);
        User::create([
            'username' => 'student5',
            'name' => 'student5',
            'email' => 'student5@student.com',
            'mobile_number' => '01614000028',
            'password' => bcrypt('123456'),
            'status' => Constants::$user_active_status,
        ]);
    }
}
