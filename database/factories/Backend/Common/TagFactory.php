<?php

namespace Database\Factories\Backend\Common;

use App\Models\Backend\Common\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tag_name' => $this->faker->words(1, true),
            'tag_status' => 'ACTIVE'
        ];
    }
}
