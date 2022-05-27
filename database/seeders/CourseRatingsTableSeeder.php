<?php

namespace Database\Seeders;

use App\Models\Backend\Course\CourseRating;
use Illuminate\Database\Seeder;

class CourseRatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseRating::factory(10)->create();
    }
}
