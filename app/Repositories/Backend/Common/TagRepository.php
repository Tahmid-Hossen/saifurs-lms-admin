<?php

namespace App\Repositories\Backend\Common;

use App\Models\Backend\Common\Tag;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TagRepository
 * @package App\Repositories\Backend\Common
 */
class TagRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Tag::class;
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
    public function allTag()
    {
        return $this->model->get(['tag_name', 'id', 'created_at']);
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
     * @param $filter
     * @return Builder
     */
    public function allTagList($filter)
    {
        $query =  $this->model->sortable()->newQuery();
        if (isset($filter['name']) && $filter['name'] != '') {
            $query->where('name', $filter['name']);
        }
        if (isset($filter['search_text']) && $filter['search_text'] != '') {
            $query->where('name', 'LIKE', "%{$filter['search_text']}%");
        }
        return $query;
    }
}

