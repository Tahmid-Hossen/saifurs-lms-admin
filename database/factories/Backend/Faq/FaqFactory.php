<?php

namespace Database\Factories\Backend\Faq;

use App\Models\Backend\Faq\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;


class FaqFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Faq::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question' => $this->faker->sentence(),
            'answer' => ucwords($this->faker->sentence()),
            'status' => 'ACTIVE'
        ];
    }
}
