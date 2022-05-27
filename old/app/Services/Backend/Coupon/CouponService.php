<?php

namespace App\Services\Backend\Coupon;

use App\Repositories\Backend\Coupon\CouponRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CouponService
{
    /**
     * @var CouponRepository
     */
    private $couponRepository;

    /**
     * CouponService constructor.
     * @param CouponRepository $couponRepository
     */
    public function __construct(CouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createCoupon($input)
    {
        try {
            return $this->couponRepository->create($input);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateCoupon($input, $id)
    {
        try {
            $coupons = $this->couponRepository->find($id);
            $this->couponRepository->update($input, $id);
            return $coupons;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @return Builder
     */
    public function showAllCoupon($input): Builder
    {
        return $this->couponRepository->filterData($input);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showCouponByID($id)
    {
        return $this->couponRepository->find($id);
    }

    /**
     * @param $input
     * @return false|mixed
     * @throws Exception
     */
    public function couponCustomInsert($input)
    {
        $date_range = explode(' - ', $input['coupon_schedule']);
        $coupon_start = $date_range[0] ?? null;
        $coupon_end = $date_range[1] ?? null;

        $output['coupon_start'] = $coupon_start;
        $output['coupon_end'] = $coupon_end;
        $output['coupon_code'] = $input['coupon_code'];
        $output['coupon_title'] = $input['coupon_title'];
        $output['company_id'] = $input['company_id'];
        $output['coupon_status'] = $input['coupon_status'];
        $output['discount_type'] = $input['discount_type'];
        $output['discount_amount'] = $input['discount_amount'];
        $output['effect_on'] = $input['effect_on'] ?? 'sub_total';
        $output['remarks'] = $input['remarks'] ?? null;
        $output['created_by'] = Auth::id();
        $output['created_at'] = Carbon::now();

        return $this->createCoupon($output);
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     * @throws Exception
     */
    public function couponCustomUpdate($input, $id)
    {
        $date_range = explode(' - ', $input['coupon_schedule']);
        $coupon_start = $date_range[0] ?? null;
        $coupon_end = $date_range[1] ?? null;

        $output['coupon_start'] = $coupon_start;
        $output['coupon_end'] = $coupon_end;
        $output['coupon_code'] = $input['coupon_code'];
        $output['coupon_title'] = $input['coupon_title'];
        $output['company_id'] = $input['company_id'];
        $output['coupon_status'] = $input['coupon_status'];
        $output['discount_type'] = $input['discount_type'];
        $output['discount_amount'] = $input['discount_amount'];
        $output['effect_on'] = $input['effect_on'] ?? 'sub_total';
        $output['remarks'] = $input['remarks'] ?? null;
        $output['updated_by'] = Auth::id();
        $output['updated_at'] = Carbon::now();

        return $this->updateCoupon($output, $id);
    }

    /**
     * @param array $inputs
     * @return array|null
     * @throws Exception
     */
    public function validateCoupon(array $inputs): ?array
    {
         return $this->couponRepository->checkCouponAvailability($inputs);
    }

    public function totalPriceCalculation($coupon, float $total_price)
    {
        if ($coupon['discount_type'] == 'percent' && $total_price>0) {
            return $total_price * (1 - $coupon['discount_amount']/100);
        } elseif($coupon['discount_type'] == 'fixed') {
            return $total_price - $coupon['discount_amount'];
        } else{
            return $total_price;
        }
    }
}
