<?php

namespace Database\Seeders;

use App\Models\Backend\Setting\Vendor;
use App\Support\Configs\Constants;
use Illuminate\Database\Seeder;

class VendorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vendor::create(
            array(
                'vendor_name' => 'Google Meet',
                'vendor_logo' => '/upload/images/vendor_logo/vendor_logo_1.svg',
                'vendor_status' => Constants::$user_active_status
            ));

        Vendor::create(array(
            'vendor_name' => 'Zoom Meeting',
            'vendor_logo' => '/upload/images/vendor_logo/vendor_logo_2.svg',
            'vendor_status' => Constants::$user_active_status
        ));
    }
}
