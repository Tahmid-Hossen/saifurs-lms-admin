<?php

namespace App\Repositories\Backend\Books;

use App\Models\Backend\Books\Book;
use App\Models\Backend\Books\EBook;
use App\Models\Backend\Books\EBookType;
use App\Repositories\Repository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

/**
 * Class BookRepository
 * @package App\Repositories\Backend\Book
 */
class EBookRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return EBook::class;
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
     * @param array $filters
     *
     * @return Builder
     */
    public function getEBookWith(array $filters): Builder
    {
        $query = $this->model->sortable()->newQuery();

        $query->join('book_categories', 'ebooks.book_category_id', '=', 'book_categories.book_category_id');

        if (!empty($filters)) {
            //search
            if (!empty($filters['search_text'])) {
                $query->where('ebooks.ebook_id', 'like', "%{$filters['search_text']}%");
                $query->orWhere('ebook_name', 'like', "%{$filters['search_text']}%");
                $query->orWhere('edition', 'like', "%{$filters['search_text']}%");
                $query->orWhere('author', 'like', "%{$filters['search_text']}%");
                $query->orWhere('contributor', 'like', "%{$filters['search_text']}%");
                $query->orWhere('ebook_description', 'like', "%{$filters['search_text']}%");
                $query->orWhere('language', 'like', "%{$filters['search_text']}%");
                $query->orWhere('isbn_number', 'like', "%{$filters['search_text']}%");
                $query->orWhere('ebook_status', 'like', "%{$filters['search_text']}%");
            }

            //name
            if (!empty($filters['name'])) {
                $query->where('ebook_name', 'like', "%{$filters['name']}%");
            }
            //author
            if (!empty($filters['author'])) {
                $query->where('author', 'like', "%{$filters['author']}%");
                $query->orWhere('contributor', 'like', "%{$filters['author']}%");
            }

            //category
            if (!empty($filters['category'])) {
                $query->where('book_categories.book_category_id', '=', "{$filters['category']}");
            }

            //company
            if (!empty($filters['company'])) {
                $query->where('ebooks.company_id', '=', "{$filters['company']}");
            }


            //date range
            if (!empty($filters['start_date']) || !empty($filters['end_date'])) {
                $query->whereBetween('ebooks.created_at', [$filters['start_date'], $filters['end_date']]);
            }
        }
        $query->whereNull('book_categories.deleted_at');

        return $query->with(['keywords', 'type']);
    }

    public function manageKeywords(EBook $book, array $pivot): EBook
    {
        try {
            $book->keywords()->sync($pivot);
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
        return $book;
    }

}

