<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\Coupon\Coupon;

class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Coupon::factory(15)->create();
    }
}
