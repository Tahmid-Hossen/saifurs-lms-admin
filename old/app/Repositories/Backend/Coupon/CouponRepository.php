<?php

namespace App\Repositories\Backend\Coupon;

use App\Models\Backend\Coupon\Coupon;
use App\Repositories\Repository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class CouponRepository extends Repository
{

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Coupon::class;
    }

    /**
     * @param $filters
     * @return Builder
     */
    public function filterData($filters): Builder
    {
        $query = $this->model->sortable()->newQuery();

        $query->join('companies', 'coupons.company_id', '=', 'companies.id');

        if (isset($filters)) {

            //search
            if (isset($filters['search_text'])) {
                $query->where('coupons.id', 'like', "%{$filters['search_text']}%");
                $query->orWhere('coupons.coupon_title', 'like', "%{$filters['search_text']}%");
                $query->orWhere('coupons.coupon_code', '=', $filters['search_text']);
            }

            // Coupon Status
            if ((isset($filters['coupon_end']) && $filters['coupon_end'])
                && (isset($filters['coupon_end_verify']) && $filters['coupon_end_verify'])) {
                $query->where('coupons.coupon_end', '>=', Carbon::now());
            }

            // Coupon Code
            if (isset($filters['coupon_code']) && $filters['coupon_code']) {
                $query->where('coupons.coupon_code', '=', $filters['coupon_code']);
            }

            // Coupon Status
            if (isset($filters['coupon_status'])) {
                $query->where('coupons.coupon_status', '=', $filters['coupon_status']);
            }

            // Company ID
            if (isset($filters['company_id'])) {
                $query->where('coupons.company_id', '=', $filters['company_id']);
            }
        }

        $query->select('companies.company_name', 'coupons.*')
            ->orderBy('coupons.id', 'desc');
        return $query;

    }

    /**
     * @param array $couponInfo
     * @return mixed
     */
    public function checkCouponAvailability(array $couponInfo = [])
    {
        try {
            $code = $couponInfo['coupon_code'];

            if ($coupon = $this->model->where('coupon_code', '=', trim($couponInfo['coupon_code']))
                ->where('coupon_end', '>=', Carbon::now())
                ->where('coupon_status', $couponInfo['coupon_status'] ?? 'ACTIVE')
                ->where('company_id', $couponInfo['company_id'])->first()) {

                return $coupon->toArray();
            }
        } catch (\Exception $exception) {
            \Log::error("Coupon Error : " . $exception->getMessage());
            return [];
        }
    }
}
