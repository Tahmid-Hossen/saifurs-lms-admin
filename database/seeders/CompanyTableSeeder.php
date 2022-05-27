<?php

namespace Database\Seeders;

use App\Models\Backend\User\Company;
use App\Support\Configs\Constants;
use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = [
            [
                'company_name' => 'Alesha Tech LMS',
                'company_email' => 'info@aleshatech.com',
                'company_address' => 'PARAASSAD TRADE CENTER<br>3rd Floor, 6 Kemal Ataturk Avenue, Banani C/A',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'company_zip_code' => '1207',
                'company_phone' => '01614000002',
                'company_mobile' => '01614000000',
                'company_logo' => '/upload/images/company_logo/company_logo_1.png',
                'company_status' => Constants::$user_active_status
            ], [
                'company_name' => 'Saifurs',
                'company_email' => 'info@saifursgroup.com',
                'company_address' => ' 3/1, Block-A, Sunrise Plaza - 5th Floor, Lamatia, Dhanmondi',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'company_zip_code' => '1207',
                'company_phone' => '01614000003',
                'company_mobile' => '01614000004',
                'company_logo' => '/upload/images/company_logo/company_logo_2.png',
                'company_status' => Constants::$user_active_status
            ], [
                'company_name' => 'Retina Medical & Dental Admission Coaching',
                'company_email' => 'info@retinabd.com',
                'company_address' => ' 3/1, Block-A, Sunrise Plaza - 5th Floor, Lamatia, Dhanmondi',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'company_zip_code' => '1207',
                'company_phone' => '01614000005',
                'company_mobile' => '01614000006',
                'company_logo' => '/upload/images/company_logo/company_logo_3.png',
                'company_status' => Constants::$user_active_status
            ], [
                'company_name' => 'Udvash',
                'company_email' => 'info@udvash.com',
                'company_address' => ' ৭৮, গ্রীন রোড (৪র্থ তলা), হোটেল গ্রীন প্যালেস এর পাশের বিল্ডিং, ফার্মগেট',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'company_zip_code' => '1207',
                'company_phone' => '01614000007',
                'company_mobile' => '01614000008',
                'company_logo' => '/upload/images/company_logo/company_logo_4.png',
                'company_status' => Constants::$user_active_status
            ]
        ];

        foreach($companies as $company) {
            Company::create($company);
        }
    }
}
