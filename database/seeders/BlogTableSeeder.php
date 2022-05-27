<?php

namespace Database\Seeders;

use App\Models\Backend\Blog\Blog;
use Illuminate\Database\Seeder;

class BlogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Blog::factory(20)->create();
    }
}
