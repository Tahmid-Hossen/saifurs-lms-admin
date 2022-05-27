<?php

namespace Database\Factories\Backend\Coupon;

use App\Models\Backend\Coupon\Coupon;
use App\Models\Backend\User\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $companyIds = Company::all()->pluck('id')->toArray();
        $companyId = $this->faker->randomElement($companyIds);
        $coupon_start = $this->faker->dateTimeBetween('this week', '+15 days');
        $coupon_end = $this->faker->dateTimeBetween($coupon_start, $coupon_start->format('Y-m-d H:i:s') . ' +4 days');
        $created_at = $this->faker->dateTimeThisYear;
        $updated_at = $this->faker->dateTimeBetween($created_at, $created_at->format('Y-m-d H:i:s') . ' +20 days');
        return [
            'company_id' => $companyId,
            'coupon_title' => $this->faker->catchPhrase,
            'coupon_code' => $this->faker->regexify('[A-Za-z0-9]{10}'),
            'coupon_start' => $coupon_start,
            'coupon_end' => $coupon_end,
            'discount_type' => $this->faker->randomElement(['fixed', 'percent']),
            'discount_amount' => $this->faker->numberBetween(0, 70),
            'effect_on' => 'sub_total',
            'remarks' => $this->faker->paragraph(2),
            'coupon_status' => $this->faker->randomElement(["ACTIVE", "IN-ACTIVE"]),
            'created_by' => $this->faker->numberBetween(1, 10),
            'updated_by' => $this->faker->numberBetween(1, 10),
            'created_at' => $created_at,
            'updated_at' => $updated_at,
        ];
    }
}
