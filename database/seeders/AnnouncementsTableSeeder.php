<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\Announcement\Announcement;

class AnnouncementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Announcement::factory(20)->create();
    }
}
