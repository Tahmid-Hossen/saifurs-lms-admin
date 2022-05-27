<?php

namespace Database\Seeders;

use App\Models\Backend\BranchLocation\Branch_location;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class BranchLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Branch_location::factory()->count(20)->create();
        //Enable Mass Assignment
        Model::unguard();

        //Disable Observer
        //$dispatcher = BranchLocationSeeder::getEventDispatcher()
        //BranchLocationSeeder::unsetEventDispatcher();

        // do stuff here

        // Re-add Dispatcher
        //BranchLocationSeeder::setEventDispatcher($dispatcher);

        //Disable Mass Assignment
        Model::reguard();

    }
}
