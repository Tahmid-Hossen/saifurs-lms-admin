<?php

namespace App\Repositories\Backend\User;

use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Permission::class;
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
    public function allPermissions()
    {
        return $this->model->get(['name', 'id', 'created_at']);
    }

    /**
     * @param $filter
     * @return Builder
     */
    public function allPermissionsList($filter)
    {
        $query = $this->getQuery();
        if (isset($filter['name']) && $filter['name'] != '') {
            $query->where('name', $filter['name']);
        }
        if (isset($filter['search_text']) && $filter['search_text'] != '') {
            $query->where('name', 'LIKE', "%{$filter['search_text']}%");
        }
        return $query;
    }
}
