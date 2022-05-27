<?php

namespace App\Repositories\Backend\Books;

use App\Models\Backend\Books\Book;
use App\Models\Backend\Books\Inventory;
use App\Models\Backend\Books\InventoryHistory;
use App\Models\Backend\Books\EBookType;
use App\Repositories\Repository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

/**
 * Class BookRepository
 * @package App\Repositories\Backend\Book
 */
class BookRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Book::class;
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
	 
	public function bookInventory($book)
    {
		$array = array(
			'book_id'=>$book->book_id,
			'initial_qty'=>$book->quantity,
			'increment_qty'=>0,
			'decrement_qty'=>0,
			'current_qty'=>$book->quantity,
			'initial_price'=>$book->book_price,
			'purchase_price'=>$book->book_price,
			'sell_price'=>$book->book_price
		);
        Inventory::insert($array);
    }
	
	public function bookInventoryHistory($data)
    {
		//dd($data['bookid']);
		$inventoryhistory['book_id'] = $data['bookid'];
		$inventoryhistory['qty'] = $data['quantity'];
		$inventoryhistory['stock_action'] = $data['stockaction'];
		$inventoryhistory['vendor_name'] = $data['vendor_name'];
		$inventoryhistory['vendor_contact'] = $data['vendor_contact'];
		$inventoryhistory['vendor_address'] = $data['vendor_address'];
		$inventoryhistory['remark'] = $data['remark'];
		$inventoryhistory['date'] = date('Y-m-d',strtotime($data['inoutdate']));
		$inventoryhistory['created_at'] = date('Y-m-d H:i:s');
		$inventoryhistory['updated_at'] = date('Y-m-d H:i:s');
		
		//dd($inventoryhistory);
		InventoryHistory::insert($inventoryhistory);

		$currentInventory = Inventory::where('book_id',$data['bookid'])->first();
		if($currentInventory!=""){
			if($data['stockaction']=='in'){
				$changeInvnetory = $currentInventory->current_qty + $data['quantity'];
				$inventory['increment_qty'] = $currentInventory->increment_qty + $data['quantity'];
			}
			elseif($data['stockaction']=='out'){
				$changeInvnetory = $currentInventory->current_qty - $data['quantity'];
				$inventory['decrement_qty'] = $currentInventory->decrement_qty + $data['quantity'];
			}
	
			$inventory['book_id'] = $data['bookid'];		
			$inventory['current_qty'] = $changeInvnetory;
			$inventory['created_at'] = date('Y-m-d H:i:s');
			$inventory['updated_at'] = date('Y-m-d H:i:s');
			Inventory::where('book_id', $data['bookid'])->update($inventory);
		}
		else{
			if($data['stockaction']=='in'){
				$inventory['increment_qty'] = $data['quantity'];
			}
			elseif($data['stockaction']=='out'){
				$inventory['decrement_qty'] = $data['quantity'];
			}
	
			$inventory['book_id'] = $data['bookid'];		
			$inventory['current_qty'] = $data['quantity'];
			$inventory['created_at'] = date('Y-m-d H:i:s');
			$inventory['updated_at'] = date('Y-m-d H:i:s');
			Inventory::insert($inventory);
		}
    }
	
	
    public function getBookWith(array $filters): Builder
    {
        $query = $this->model->sortable()->newQuery();

        $query->join('companies', 'books.company_id', '=', 'companies.id');
        $query->join('book_categories', 'books.book_category_id', '=', 'book_categories.book_category_id');
        $query->leftJoin('ebook_types', 'books.ebook_type_id', '=', 'ebook_types.ebook_type_id');

        if (!empty($filters)) {
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

            //name
            if (!empty($filters['name'])) {
                $query->where('books.book_name', 'like', "%{$filters['name']}%");
            }
            //name
            if (!empty($filters['book_name'])) {
                $query->where('books.book_name', 'like', "%{$filters['book_name']}%");
            }
            //author
            if (!empty($filters['author'])) {
                $query->Where(function ($queryString) use ($filters) {
                    $queryString->where('books.author', 'like', "%{$filters['author']}%");
                    $queryString->orWhere('books.contributor', 'like', "%{$filters['author']}%");
                });
            }
            //category
            if (!empty($filters['category'])) {
                $query->where('book_categories.book_category_id', '=', $filters['category']);
            }
            //book_category_id
            if (!empty($filters['book_category_id'])) {
                $query->where('books.book_category_id', '=', $filters['book_category_id']);
            }

            //book_category_name
            if (!empty($filters['book_category_name'])) {
                $query->where('book_categories.book_category_name', 'like',"%{$filters['book_category_name']}%");
            }


            //is_sellable
            if (!empty($filters['is_sellable'])) {
                $query->where('books.is_sellable', '=', $filters['is_sellable']);
            }
            //keyword_name
            if (!empty($filters['keyword_name'])) {
                $query->join('keyword_book', 'books.book_id', '=', 'keyword_book.book_id');

                $query->join('keywords', 'keyword_book.keyword_id', '=', 'keywords.keyword_id');
                $query->where('keywords.keyword_name', 'like', "%{$filters['keyword_name']}%");
            }

            //isbn_number
            if (isset($filters['isbn_number']) && $filters['isbn_number']) {
                $query->where('books.isbn_number', '=', "{$filters['isbn_number']}");
            }

            //company
            if (isset($filters['company']) && $filters['company']) {
                $query->where('books.company_id', '=', "{$filters['company']}");
            }

            if (isset($filters['company_id']) && $filters['company_id']) {
                $query->where('books.company_id', '=', "{$filters['company_id']}");
            }

            //status
            if (isset($filters['status']) && $filters['status']) {
                $query->where('books.book_status', '=', "{$filters['status']}");
            }

            if (isset($filters['book_status']) && $filters['book_status']) {
                $query->where('books.book_status', '=', "{$filters['book_status']}");
            }

            //ebook
            if (isset($filters['is_ebook']) && $filters['is_ebook']) {
                $query->where('books.is_ebook', '=', "{$filters['is_ebook']}");
            }
            //date range
            if (!empty($filters['start_date']) || !empty($filters['end_date'])) {
                $query->whereBetween('books.created_at', [$filters['start_date'], $filters['end_date']]);
            }

            //sorting
            if (isset($filters['sorting_order']) && $filters['sorting_order']) {
                $query->orderBy('books.book_id', "{$filters['sorting_order']}");
            }

            if (isset($filters['book_a_to_z_sorting_order']) && $filters['book_a_to_z_sorting_order']) {
                $query->orderBy('books.book_name', "{$filters['book_a_to_z_sorting_order']}");
            }

            if (isset($filters['book_price_sorting_order']) && $filters['book_price_sorting_order']) {
                $query->orderBy('books.book_price', "{$filters['book_price_sorting_order']}");
            }

            if ((isset($filters['user_id']) && $filters['user_id'])
                && (isset($filters['purchased_book_only']) && $filters['purchased_book_only'])) {
                $query->join('book_user', 'books.book_id', '=', 'book_user.book_id');
                $query->join('users', 'book_user.user_id', '=', 'users.id');
                $query->where('book_user.user_id', "=", $filters['user_id']);
            }

        }

        $query->whereNull('companies.deleted_at');
        $query->whereNull('book_categories.deleted_at');
        return $query;

    }

    public function manageKeywords(Book $book, array $pivot): Book
    {
        try {
            $book->keywords()->sync($pivot);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return $book;
    }

    public function getAllEbookTypes()
    {
        return EBookType::all();
    }

}

