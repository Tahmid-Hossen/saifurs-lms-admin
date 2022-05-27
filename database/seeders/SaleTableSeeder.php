<?php

namespace Database\Seeders;

use App\Models\Backend\Sale\Item;
use App\Models\Backend\Sale\Sale;
use Illuminate\Database\Seeder;

class SaleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //using factory
        Sale::factory()->count(20)->has(Item::factory()->count(mt_rand(1, 10)))->create();
    }
}
