<?php

namespace App\Repositories\Backend\Books;

use App\Models\Backend\Books\Category;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CategoryRepository
 * @package App\Repositories\Backend\Book
 */
class CategoryRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Category::class;
    }

    /**
     *
     * @return mixed
     */
    public function allCategoryForDropdown()
    {
        return $this->model->orderBy('book_category_name')->get(['book_category_name', 'book_category_id']);
    }

    /**
     * Index and user input based list
     *
     * @param array $filters
     * @return Builder
     */
    public function getCategoryWith(array $filters): Builder
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

            //book_category_id
            if (!empty($filters['book_category_id'])) {
                $query->where('book_category_id', '=', $filters['book_category_id']);
            }

            //company_id
            if (!empty($filters['company_id'])) {
                $query->where('company_id', '=', $filters['company_id']);
            }

            //date range
            if (!empty($filters['start_date']) || !empty($filters['end_date'])) {
                $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
            }

            //sorting
            if(isset($filters['sorting_order']) && $filters['sorting_order']) {
                $query->orderBy('book_category_id', "{$filters['sorting_order']}");
            }
        }

        return $query;
    }
}

