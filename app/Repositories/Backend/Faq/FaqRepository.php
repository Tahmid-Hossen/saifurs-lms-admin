<?php

namespace App\Repositories\Backend\Faq;

use App\Models\Backend\Faq\Faq;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class FaqRepository
 * @package App\Repositories\Backend\Common
 */
class FaqRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Faq::class;
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
    public function allFaq()
    {
        return $this->model->get(['question','answer','status', 'id', 'created_at']);
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

    public function allFaqList($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->whereNull('faqs.deleted_at')->select('question','answer','id','created_at','status')->orderBy('id','DESC');
        return $query;

    }


    public function allFaqFrontndList($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->where('status','ACTIVE')->whereNull('faqs.deleted_at')->select('question','answer','id','created_at','status')->orderBy('id','DESC');
        return $query;

    }
}

