<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BookCategoryTableSeeder::class);
        $this->call(EBookTypeTableSeeder::class);
    }
}
