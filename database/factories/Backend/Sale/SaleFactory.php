<?php

namespace Database\Factories\Backend\Sale;

use App\Models\Backend\Sale\Sale;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $return = [
            'user_id' => mt_rand(1, 5),
            'company_id' => mt_rand(1, 4),
            'branch_id' => NULL,
            'reference_number' => "000" . mt_rand(10000, 900000),
            'coupon_id' => null,
            'entry_date' => date('Y-m-d H:i:s'),
            'customer_name' => $this->faker->name(),
            'customer_email' => $this->faker->safeEmail(),
            'customer_phone' => $this->faker->phoneNumber(),
            'ship_address' => $this->faker->address(),
            'notes' => $this->faker->paragraph(),
            'transaction_id' => "INV-000" . mt_rand(10000, 900000),
            'transaction_response' => NULL,
            'currency' => 'BDT',
            'sub_total_amount' => mt_rand(100000, 999999),
            'discount_type' => 'percent',
            'discount_amount' => '10',
            'shipping_cost' => '500',
            'total_amount' => mt_rand(100000, 999999),
            'due_amount' => '0',
            'due_date' => date('Y-m-d H:i:s'),
            'payment_status' => 'paid',
            'sale_status' => 'processing',
            'source_type' => 'web', //[web, app, office]
        ];

        return $return;
    }
}
