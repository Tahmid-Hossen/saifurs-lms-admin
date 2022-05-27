<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\Configs\Constants;
use Illuminate\Database\Seeder;

class TeacherUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(array(
            'username' => 'teacher1',
            'name' => 'teacher1',
            'email' => 'teacher1@teacher.com',
            'mobile_number' => '8801614000010',
            'status' => Constants::$user_active_status,
            'password' => bcrypt(123456)
        ));
        User::create([
            'username' => 'teacher2r',
            'name' => 'teacher2',
            'email' => 'teacher2@teacher.com',
            'mobile_number' => '8801714000012',
            'password' => bcrypt('123456'),
            'status' => Constants::$user_active_status,
        ]);
        User::create([
            'username' => 'teacher3',
            'name' => 'teacher3',
            'email' => 'teacher3@teacher.com',
            'mobile_number' => '01614000014',
            'password' => bcrypt('123456'),
            'status' => Constants::$user_active_status,
        ]);
        User::create([
            'username' => 'teacher4',
            'name' => 'teacher4',
            'email' => 'teacher4@teacher.com',
            'mobile_number' => '01614000016',
            'password' => bcrypt('123456'),
            'status' => Constants::$user_active_status,
        ]);
        User::create([
            'username' => 'teacher5',
            'name' => 'teacher5',
            'email' => 'teacher5@teacher.com',
            'mobile_number' => '01614000018',
            'password' => bcrypt('123456'),
            'status' => Constants::$user_active_status,
        ]);
    }
}
