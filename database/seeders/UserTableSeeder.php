<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Enable Mass Assignment
        Model::unguard();

        //Disable Observer
        //$dispatcher = UserTableSeeder::getEventDispatcher()
        //UserTableSeeder::unsetEventDispatcher();

        // do stuff here

        // Re-add Dispatcher
        //UserTableSeeder::setEventDispatcher($dispatcher);

        //Disable Mass Assignment
        Model::reguard();

    }
}
