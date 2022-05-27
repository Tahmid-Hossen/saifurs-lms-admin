<?php

namespace Database\Seeders;

use App\Models\Backend\Faq\Faq;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Faq::factory()->count(20)->create();

    }
}
