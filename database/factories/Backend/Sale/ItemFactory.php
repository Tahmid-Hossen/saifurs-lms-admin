<?php

namespace Database\Factories\Backend\Sale;

use App\Models\Backend\Sale\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $total_books = \DB::table('books')->max('book_id');

        $return = [
            'item_id' => mt_rand(1, $total_books),
            'item_path' => 'App\Models\Backend\Books\Book',
            'item_description' => $this->faker->paragraph(3),
            'price_amount' => 100,
            'quantity' => mt_rand(20, 40),
            'discount_amount' => 10,
            ];

        $return['sub_total_amount'] = $return['price_amount'] * $return['quantity'];
        $return['total_amount'] = $return['sub_total_amount'] - $return['discount_amount'];


        return $return;
    }
}
