<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\Configs\Constants;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(array(
            'username' => 'administrator',
            'name' => 'Administrator',
            'email' => 'admin@aleshatech-lms.com',
            'mobile_number' => '01614000000',
            'status' => Constants::$user_active_status,
            'password' => bcrypt(123456),

        ));
        User::create([
            'username' => 'content-uploader',
            'name' => 'Content Uploader',
            'email' => 'content-uploader@aleshatech-lms.com',
            'mobile_number' => '01714000000',
            'password' => bcrypt('123456'),
            'status' => Constants::$user_active_status,
        ]);
        User::create([
            'username' => 'udvash',
            'name' => 'Udvash Admin',
            'email' => 'info@udvash.com',
            'mobile_number' => '01614000008',
            'password' => bcrypt('123456'),
            'status' => Constants::$user_active_status,
        ]);
        User::create([
            'username' => 'retinabd',
            'name' => 'Retina BD Admin',
            'email' => 'info@retinabd.com',
            'mobile_number' => '01614000006',
            'password' => bcrypt('123456'),
            'status' => Constants::$user_active_status,
        ]);
        User::create([
            'username' => 'saifursgroup',
            'name' => 'Saifurs Group Admin',
            'email' => 'info@saifursgroup.com',
            'mobile_number' => '01614000004',
            'password' => bcrypt('123456'),
            'status' => Constants::$user_active_status,
        ]);
    }
}
