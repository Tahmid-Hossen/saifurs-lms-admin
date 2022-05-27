<?php

namespace Database\Factories\Backend\Common;

use App\Models\Backend\Common\Keyword;
use Illuminate\Database\Eloquent\Factories\Factory;

class KeywordFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Keyword::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'keyword_name' => $this->faker->words(1, true),
            'keyword_status' => 'ACTIVE'
        ];
    }
}
