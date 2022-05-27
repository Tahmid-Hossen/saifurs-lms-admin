<?php

namespace App\Repositories\Backend\BranchLocation;

use App\Models\Backend\BranchLocation\Branch_location;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FaqRepository
 * @package App\Repositories\Backend\Common
 */
class BranchLocationRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Branch_location::class;
    }

    /**
     * Filter data based on user input
     *
     * @param array $filter
     * @param $query
     */
    public function filterData(array $filter, $query)
    {
        // TODO: Implement filterData() method.
    }

    /**
     * @return mixed
     */
    public function allBranchLocation()
    {
        return $this->model->get(['branch_name','manager_name','address_en','address_bn','email','phone','status', 'id', 'created_at']);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->firstOrCreate($data);
    }

    /**
     * @param $filters
     * @return Builder
     */

    public function allBranchLocationList()
    {
        $query = $this->model->sortable()->newQuery();
        $query->whereNull('branch_locations.deleted_at')->select('branch_name','manager_name','address_en','address_bn','email','phone','id','created_at','status')->orderBy('id','DESC');
        return $query;

    }


    public function allBranchLocationFrontendList($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->where('status','ACTIVE')->whereNull('branch_locations.deleted_at')->select('branch_name','manager_name','address_en','address_bn','email','phone','id','created_at','status')->orderBy('id','DESC');
        return $query;

    }
}

