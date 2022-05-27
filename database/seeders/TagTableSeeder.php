<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\Common\Tag;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tag::factory()->count(20)->create();
    }
}
