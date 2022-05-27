<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\Quiz\Quiz;

class QuizzesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Quiz::factory(10)->create();
    }
}
