<?php

namespace Database\Seeders;

use App\Models\Backend\User\Company;
use App\Models\Backend\User\UserDetail;
use App\Models\User;
use App\Support\Configs\Constants;
use Illuminate\Database\Seeder;

class UserDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::whereEmail('admin@aleshatech-lms.com')->first();
        $user2 = User::whereEmail('content-uploader@aleshatech-lms.com')->first();
        $udvash = User::whereEmail('info@udvash.com')->first();
        $udvashCompany = Company::where('company_email', '=', 'info@udvash.com')->first();
        $saifursGroup = User::whereEmail('info@saifursgroup.com')->first();
        $saifursGroupCompany= Company::where('company_email', '=', 'info@saifursgroup.com')->first();
        $retinabd = User::whereEmail('info@retinabd.com')->first();
        $retinaBDCompany = Company::where('company_email', '=', 'info@retinabd.com')->first();

        UserDetail::create(
            [
                'user_id' => $user1->id,
                'first_name' => 'Admin',
                'last_name' => 'Alesha',
                //'sponsor_id' => 1,
                'company_id' => 1,
                'branch_id' => 1,
                'national_id' => '1950000000',
                'date_of_birth' => '1985-02-19',
                'date_of_enrollment' =>  date('Y-m-d', strtotime("-10 days")),
                'gender' => 'male',
                'married_status' => 'single',
                'mailing_address' => 'PARAASSAD TRADE CENTER<br>3rd Floor, 6 Kemal Ataturk Avenue, Banani C/A',
                'post_code' => '1213',
                'police_station' => 'Banani',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'mobile_phone' => '+8801614000000',
                'home_phone' => '+880258812634',
                'identity_card' => '1950000000',
                'user_detail_photo' => '/upload/images/profile_image/user_detail_photo_1.png',
                'user_details_verified' => Constants::$user_active_status,
                'user_details_status' => Constants::$user_active_status
            ]
        );

        UserDetail::create(
            [
                'user_id' => $user2->id,
                'first_name' => 'Content',
                'last_name' => 'Alesha',
                //'sponsor_id' => 1,
                'company_id' => 1,
                'branch_id' => 1,
                'national_id' => '1950000001',
                'date_of_birth' => '1980-03-27',
                'date_of_enrollment' =>  date('Y-m-d', strtotime("-10 days")),
                'gender' => 'male',
                'married_status' => 'single',
                'mailing_address' => 'PARAASSAD TRADE CENTER<br>3rd Floor, 6 Kemal Ataturk Avenue, Banani C/A',
                'post_code' => '1213',
                'police_station' => 'Banani',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'mobile_phone' => '+8801714000000',
                'home_phone' => '+880258812634',
                'identity_card' => '1950000000',
                'user_detail_photo' => '/upload/images/profile_image/user_detail_photo_1.png',
                'user_details_verified' => Constants::$user_active_status,
                'user_details_status' => Constants::$user_active_status
            ]
        );

        UserDetail::create(
            [
                'user_id' => $udvash->id,
                'first_name' => 'Udvash',
                'last_name' => 'Admin',
                //'sponsor_id' => 1,
                'company_id' => $udvashCompany->id,
                'branch_id' => 4,
                'national_id' => '1950000001',
                'date_of_birth' => '1980-03-27',
                'date_of_enrollment' =>  date('Y-m-d', strtotime("-10 days")),
                'gender' => 'male',
                'married_status' => 'single',
                'mailing_address' => $udvashCompany->company_address,
                'post_code' => $udvashCompany->company_zip_code,
                'police_station' => 'Banani',
                'city_id' => $udvashCompany->city_id,
                'state_id' => $udvashCompany->state_id,
                'country_id' => $udvashCompany->country_id,
                'mobile_phone' => $udvashCompany->company_mobile,
                'home_phone' => $udvashCompany->company_phone,
                'identity_card' => '1950000000',
                'user_detail_photo' => '/upload/images/profile_image/user_detail_photo_2.png',
                'user_details_verified' => Constants::$user_active_status,
                'user_details_status' => Constants::$user_active_status
            ]
        );

        UserDetail::create(
            [
                'user_id' => $saifursGroup->id,
                'first_name' => 'Saifurs',
                'last_name' => 'Admin',
                //'sponsor_id' => 1,
                'company_id' => $saifursGroupCompany->id,
                'branch_id' => 2,
                'national_id' => '1950000001',
                'date_of_birth' => '1980-03-27',
                'date_of_enrollment' =>  date('Y-m-d', strtotime("-10 days")),
                'gender' => 'male',
                'married_status' => 'single',
                'mailing_address' => $saifursGroupCompany->company_address,
                'post_code' => $saifursGroupCompany->company_zip_code,
                'police_station' => 'Banani',
                'city_id' => $saifursGroupCompany->city_id,
                'state_id' => $saifursGroupCompany->state_id,
                'country_id' => $saifursGroupCompany->country_id,
                'mobile_phone' => $saifursGroupCompany->company_mobile,
                'home_phone' => $saifursGroupCompany->company_phone,
                'identity_card' => '1950000000',
                'user_detail_photo' => '/upload/images/profile_image/user_detail_photo_3.png',
                'user_details_verified' => Constants::$user_active_status,
                'user_details_status' => Constants::$user_active_status
            ]
        );

        UserDetail::create(
            [
                'user_id' => $retinabd->id,
                'first_name' => 'retina',
                'last_name' => 'Admin',
                //'sponsor_id' => 1,
                'company_id' => $retinaBDCompany->id,
                'branch_id' => 3,
                'national_id' => '1950000001',
                'date_of_birth' => '1980-03-27',
                'date_of_enrollment' =>  date('Y-m-d', strtotime("-10 days")),
                'gender' => 'male',
                'married_status' => 'single',
                'mailing_address' => $retinaBDCompany->company_address,
                'post_code' => $retinaBDCompany->company_zip_code,
                'police_station' => 'Banani',
                'city_id' => $retinaBDCompany->city_id,
                'state_id' => $retinaBDCompany->state_id,
                'country_id' => $retinaBDCompany->country_id,
                'mobile_phone' => $retinaBDCompany->company_mobile,
                'home_phone' => $retinaBDCompany->company_phone,
                'identity_card' => '1950000000',
                'user_detail_photo' => '/upload/images/profile_image/user_detail_photo_4.png',
                'user_details_verified' => Constants::$user_active_status,
                'user_details_status' => Constants::$user_active_status
            ]
        );

    }
}
