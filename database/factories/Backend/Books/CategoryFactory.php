<?php

namespace Database\Factories\Backend\Books;

use App\Models\Backend\Books\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => 1,
            'book_category_name' => ucwords($this->faker->word()),
            'book_category_status' => 'ACTIVE'
        ];
    }
}
