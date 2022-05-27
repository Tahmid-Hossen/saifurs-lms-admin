<?php

namespace Database\Seeders;

use App\Models\Backend\Common\Keyword;
use Illuminate\Database\Seeder;

class KeywordTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //using factory
        Keyword::factory()->count(20)->create();
    }
}
