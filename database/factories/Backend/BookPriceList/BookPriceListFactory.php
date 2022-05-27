<?php

namespace Database\Factories\Backend\BookPriceList;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Backend\BookPriceList\BookPriceList;

class BookPriceListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BookPriceList::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'book_name' => $this->faker->name(),
            'cover_price' => mt_rand(100, 1000),
            'retail_price' => mt_rand(100, 1000),
            'wholesale' => mt_rand(100, 1000),
            'status' => 'ACTIVE'
        ];
    }
}
