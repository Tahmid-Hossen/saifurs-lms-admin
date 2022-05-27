<?php

namespace App\Repositories\Backend\Books;

use App\Models\Backend\Books\InventoryHistory;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CategoryRepository
 * @package App\Repositories\Backend\Book
 */
class InventoryHistoryRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return InventoryHistory::class;
    }

   
    public function getInventory(array $filters): Builder
    {
        $query = $this->model->sortable()->newQuery();
		$query->join('books', 'books.book_id', '=', 'inventory_histories.book_id');

        /*if (!empty($filters)) {

            //search
            if (!empty($filters['search_text'])) {
                $query->Where(function ($queryString) use ($filters) {
                    $queryString->where('books.book_id', 'like', "%{$filters['search_text']}%");
                    $queryString->orWhere('books.book_name', 'like', "%{$filters['search_text']}%");
                    $queryString->orWhere('books.edition', 'like', "%{$filters['search_text']}%");
                    $queryString->orWhere('books.author', 'like', "%{$filters['search_text']}%");
                    $queryString->orWhere('books.contributor', 'like', "%{$filters['search_text']}%");
                    $queryString->orWhere('books.book_description', 'like', "%{$filters['search_text']}%");
                    $queryString->orWhere('books.language', 'like', "%{$filters['search_text']}%");
                    $queryString->orWhere('books.isbn_number', 'like', "%{$filters['search_text']}%");
                    $queryString->orWhere('books.book_status', 'like', "%{$filters['search_text']}%");
                    $queryString->orWhere('book_categories.book_category_name', 'like', "%{$filters['search_text']}%");
                    //$queryString->orWhere('keywords.keyword_name', 'like', "%{$filters['search_text']}%");

                });
            }
            //date range
            if (!empty($filters['start_date']) || !empty($filters['end_date'])) {
                $query->whereBetween('date', [$filters['start_date'], $filters['end_date']]);
            }

        }*/

        return $query;
    }
}

