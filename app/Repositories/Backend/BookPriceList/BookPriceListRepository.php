<?php

namespace App\Repositories\Backend\BookPriceList;

use App\Models\Backend\BookPriceList\BookPriceList;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
/**
 * Class BookPriceListRepository
 * @package App\Repositories\Backend\BookPriceList
 */
class BookPriceListRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return BookPriceList::class;
    }
    public function filterData(array $filter, $query)
    {
        // TODO: Implement filterData() method.
    }

    /**
     * @return mixed
     */
    /*public function allBookPriceListForDropdown()
    {
        return $this->model->get(['name', 'id']);
    }*/
  /*  public function allBookPriceList()
    {
        return $this->model->get(['book_name','cover_price','retail_price','wholesale','status', 'id', 'created_at']);
    }*/
    public function create(array $data)
    {
        return $this->model->firstOrCreate($data);
    }
    public function allBookPriceList()
    {
        $query = $this->model->sortable()->newQuery();
        $query->whereNull('book_price_lists.deleted_at')->select('book_name','cover_price','retail_price','wholesale','id','created_at','status')->orderBy('id','DESC');
        return $query;

    }


    public function allBookPriceListFrontendList($filters)
    {
        $query = $this->model->sortable()->newQuery();
        $query->where('status','ACTIVE')->whereNull('book_price_lists.deleted_at')->select('book_name','cover_price','retail_price','wholesale','id','created_at','status')->orderBy('id','DESC');
        return $query;

    }

        /**
         * Index and user input based list
         *
         * @param array $filters
         * @return Builder
         */
        /*public function getBookPriceListWith(array $filters): Builder
        {
            $query = $this->model->sortable()->newQuery();

            if (!empty($filters)) {

                //search
                if (!empty($filters['search_text'])) {
                    $query->where('book_category_name', 'like', "%{$filters['search_text']}%");
                    $query->orWhere('book_category_status', 'like', "%{$filters['search_text']}%");
                    $query->orWhere('book_category_id', 'like', "%{$filters['search_text']}%");
                }

                //name
                if (!empty($filters['name'])) {
                    $query->where('book_category_name', 'like', "%{$filters['name']}%");
                }

                //date range
                if (!empty($filters['start_date']) || !empty($filters['end_date'])) {
                    $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
                }
            }

            return $query;
        }*/
}

