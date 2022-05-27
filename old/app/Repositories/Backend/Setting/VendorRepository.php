<?php


namespace App\Repositories\Backend\Setting;


use App\Models\Backend\Setting\Vendor;
use App\Repositories\Repository;
use DB;

class VendorRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Vendor::class;
    }

    /**
     * @param $filter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function vendorFilterData($filter): \Illuminate\Database\Eloquent\Builder
    {
        $query = $this->model->sortable()->newQuery();
        if (isset($filter['search_text']) && $filter['search_text']) {
            $query->where('vendors.vendor_name', 'like', "%{$filter['search_text']}%");
            $query->orWhere('vendors.vendor_status', 'like', "%{$filter['search_text']}%");
        }

        if (isset($filter['id']) && $filter['id']) {
            $query->where('vendors.id', '=', $filter['id']);
        }

        if (isset($filter['vendor_id']) && $filter['vendor_id']) {
            $query->where('vendors.id', '=', $filter['vendor_id']);
        }

        if (isset($filter['vendor_name']) && $filter['vendor_name']) {
            $query->where(DB::raw('LOWER(vendors.vendor_name)'), '=', strtolower($filter['vendor_name']));
        }

        if (isset($filter['vendor_status']) && $filter['vendor_status']) {
            $query->where('vendors.vendor_status', '=', $filter['vendor_status']);
        }

        $query->select(
            [
                'vendors.*', \DB::raw('CONCAT("'.url('/').'",vendors.vendor_logo) AS vendor_logo')
            ]
        );
        return $query;
    }
}
