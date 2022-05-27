<?php

namespace Database\Seeders;

use App\Models\Backend\BookPriceList\BookPriceList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class BookPriceListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BookPriceList::factory()->count(20)->create();
        //Enable Mass Assignment
        Model::unguard();

        //Disable Observer
        //$dispatcher = BookPriceListSeeder::getEventDispatcher()
        //BookPriceListSeeder::unsetEventDispatcher();

        // do stuff here

        // Re-add Dispatcher
        //BookPriceListSeeder::setEventDispatcher($dispatcher);

        //Disable Mass Assignment
        Model::reguard();

    }
}
