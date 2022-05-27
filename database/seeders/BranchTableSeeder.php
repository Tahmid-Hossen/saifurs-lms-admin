<?php

namespace Database\Seeders;

use App\Models\Backend\User\Branch;
use App\Models\Backend\User\Company;
use App\Support\Configs\Constants;
use Illuminate\Database\Seeder;

class BranchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = date('Y-m-d H:i:s');
        $status = Constants::$user_active_status;

        $aleshaCompany = Company::where('company_email', '=', 'info@aleshatech.com')->first();
        $udvashCompany = Company::where('company_email', '=', 'info@udvash.com')->first();
        $saifursGroupCompany = Company::where('company_email', '=', 'info@saifursgroup.com')->first();
        $retinaBDCompany = Company::where('company_email', '=', 'info@retinabd.com')->first();

        $branches = [
            //Alesha
            [
                'company_id' => $aleshaCompany->id,
                'branch_name' => 'Alesha Tech LMS',
                'manager_name' => 'Saifurs',
                'branch_address' => 'PARAASSAD TRADE CENTER<br>3rd Floor, 6 Kemal Ataturk Avenue, Banani C/A',
                'address_bn' => 'PARAASSAD TRADE CENTER<br>3rd Floor, 6 Kemal Ataturk Avenue, Banani C/A',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'branch_zip_code' => '1207',
                'branch_phone' => '01614000002',
                'branch_mobile' => '01614000000',
                'branch_email' => 'test@gmail.com',
                'branch_latitude' => '',
                'branch_longitude' => '',
                'branch_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp,
            ],
            [
                'company_id' => $aleshaCompany->id,
                'branch_name' => 'Alesha HR Building',
                'manager_name' => 'Alesha HR',
                'branch_address' => 'PARAASSAD TRADE CENTER<br>3rd Floor, 6 Kemal Ataturk Avenue, Banani C/A',
                'address_bn' => 'PARAASSAD TRADE CENTER<br>4rd Floor, 6 Kemal Ataturk Avenue, Banani C/A',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'branch_zip_code' => '1207',
                'branch_phone' => '01614000002',
                'branch_mobile' => '01614000000',
                'branch_email' => 'test@gmail.com',
                'branch_latitude' => '',
                'branch_longitude' => '',
                'branch_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp,
            ],
            //Saifur's
            [
                'company_id' => $saifursGroupCompany->id,
                'branch_name' => 'Saifurs Main Branch',
                'manager_name' => 'Saifurs',
                'branch_address' => ' 3/1, Block-A, Sunrise Plaza - 5th Floor, Lamatia, Dhanmondi',
                'address_bn' => ' 3/1, Block-B, Sunrise Plaza - 5th Floor, Lamatia, Dhanmondi',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'branch_zip_code' => '1207',
                'branch_phone' => '01614000003',
                'branch_mobile' => '01614000004',
                'branch_email' => 'test@gmail.com',
                'branch_latitude' => '',
                'branch_longitude' => '',
                'branch_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp,
            ],
            [
                'company_id' => $saifursGroupCompany->id,
                'branch_name' => 'Saifurs Mohammadpur Branch',
                'manager_name' => 'Saifurs Mohammadpur',
                'branch_address' => ' 3/1, Block-A, Sunrise Plaza - 5th Floor, Lamatia, Dhanmondi',
                'address_bn' => ' 3/3, Block-A, Sunrise Plaza - 5th Floor, Lamatia, Dhanmondi',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'branch_zip_code' => '1207',
                'branch_phone' => '01614000003',
                'branch_mobile' => '01614000004',
                'branch_email' => 'test@gmail.com',
                'branch_latitude' => '',
                'branch_longitude' => '',
                'branch_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp,
            ],
            [
                'company_id' => $saifursGroupCompany->id,
                'branch_name' => 'Saifurs Mouchak Branch',
                'manager_name' => 'Saifurs Mouchak Branch',
                'branch_address' => ' 3/1, Block-A, Sunrise Plaza - 5th Floor, Lamatia, Dhanmondi',
                'address_bn' => ' 3/1, Block-c, Sunrise Plaza - 5th Floor, Lamatia, Dhanmondi',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'branch_zip_code' => '1207',
                'branch_phone' => '01614000003',
                'branch_mobile' => '01614000004',
                'branch_email' => 'test@gmail.com',
                'branch_latitude' => '',
                'branch_longitude' => '',
                'branch_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp,
            ],
            //Retina
            [
                'company_id' => $retinaBDCompany->id,
                'branch_name' => 'Retina Main Branch',
                'manager_name' => 'Retina Branch',
                'branch_address' => ' 3/1, Block-A, Sunrise Plaza - 5th Floor, Lamatia, Dhanmondi',
                'address_bn' => ' 3/5, Block-A, Sunrise Plaza - 5th Floor, Lamatia, Dhanmondi',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'branch_zip_code' => '1207',
                'branch_phone' => '01614000005',
                'branch_mobile' => '01614000006',
                'branch_email' => 'test@gmail.com',
                'branch_latitude' => '',
                'branch_longitude' => '',
                'branch_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp,
            ],
            [
                'company_id' => $retinaBDCompany->id,
                'branch_name' => 'Retina Shantinagor Branch',
                'manager_name' => 'Retina Shantinagor',
                'branch_address' => ' 3/1, Block-A, Sunrise Plaza - 5th Floor, Lamatia, Dhanmondi',
                'address_bn' => ' 3/1, Block-f, Sunrise Plaza - 5th Floor, Lamatia, Dhanmondi',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'branch_zip_code' => '1207',
                'branch_phone' => '01614000005',
                'branch_mobile' => '01614000006',
                'branch_email' => 'test@gmail.com',
                'branch_latitude' => '',
                'branch_longitude' => '',
                'branch_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp,
            ],
            [
                'company_id' => $retinaBDCompany->id,
                'branch_name' => 'Retina Uttara Branch',
                'manager_name' => 'Retina Uttara',
                'branch_address' => ' 3/1, Block-A, Sunrise Plaza - 5th Floor, Lamatia, Dhanmondi',
                'address_bn' => ' 3/1, Block-k, Sunrise Plaza - 5th Floor, Lamatia, Dhanmondi',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'branch_zip_code' => '1207',
                'branch_phone' => '01614000005',
                'branch_mobile' => '01614000006',
                'branch_email' => 'test@gmail.com',
                'branch_latitude' => '',
                'branch_longitude' => '',
                'branch_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp,
            ],
            //Udvash
            [
                'company_id' => $udvashCompany->id,
                'branch_name' => 'Udvash Main Branch',
                'manager_name' => 'Udvash Main',
                'branch_address' => ' ৭৮, গ্রীন রোড (৪র্থ তলা), হোটেল গ্রীন প্যালেস এর পাশের বিল্ডিং, ফার্মগেট',
                'address_bn' => ' ৭৮, গ্রীন রোড (৪র্থ তলা), হোটেল গ্রীন প্যালেস এর পাশের বিল্ডিং, ফার্মগেট',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'branch_zip_code' => '1207',
                'branch_phone' => '01614000007',
                'branch_mobile' => '01614000008',
                'branch_email' => 'test@gmail.com',
                'branch_latitude' => '',
                'branch_longitude' => '',
                'branch_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp,
            ],
            [
                'company_id' => $udvashCompany->id,
                'branch_name' => 'Udvash Farmgate Branch',
                'manager_name' => 'Udvash Farmgate',
                'branch_address' => ' ৭৮, গ্রীন রোড (৪র্থ তলা), হোটেল গ্রীন প্যালেস এর পাশের বিল্ডিং, ফার্মগেট',
                'address_bn' => ' ৭৮, গ্রীন রোড (৪র্থ তলা), হোটেল গ্রীন প্যালেস এর পাশের বিল্ডিং, ফার্মগেট',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'branch_zip_code' => '1207',
                'branch_phone' => '01614000007',
                'branch_mobile' => '01614000008',
                'branch_email' => 'test@gmail.com',
                'branch_latitude' => '',
                'branch_longitude' => '',
                'branch_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp,
            ],
            [
                'company_id' => $udvashCompany->id,
                'branch_name' => 'Udvash Sylhet Branch',
                'manager_name' => 'Udvash Sylhet',
                'branch_address' => ' ৭৮, গ্রীন রোড (৪র্থ তলা), হোটেল গ্রীন প্যালেস এর পাশের বিল্ডিং, ফার্মগেট',
                'address_bn' => ' ৭৮, গ্রীন রোড (৪র্থ তলা), হোটেল গ্রীন প্যালেস এর পাশের বিল্ডিং, ফার্মগেট',
                'city_id' => '7291',
                'state_id' => '348',
                'country_id' => '18',
                'branch_zip_code' => '1207',
                'branch_phone' => '01614000007',
                'branch_mobile' => '01614000008',
                'branch_email' => 'test@gmail.com',
                'branch_latitude' => '',
                'branch_longitude' => '',
                'branch_status' => $status, 'created_at' => $timestamp, 'updated_at' => $timestamp,
            ],

        ];
        foreach ($branches as $branch) {
            try {
                Branch::create($branch);
            } catch (\PDOException $exception) {
                throw  new \PDOException($exception->getMessage());
            }
        }
    }
}
