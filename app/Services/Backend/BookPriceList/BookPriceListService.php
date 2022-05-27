<?php

namespace App\Services\Backend\BookPriceList;

use App\Repositories\Backend\BookPriceList\BookPriceListRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Utility;

/**
 * Class BookPriceListService
 * @package App\Services\Backend\BookPriceList
 */
class BookPriceListService
{
    /**
     * @var BookPriceListRepository
     */
    private $bookPriceListRepository;

    /**
     * BookPriceListService constructor.
     * @param BookPriceListRepository $bookPriceListRepository
     */
    public function __construct(BookPriceListRepository $bookPriceListRepository)
    {
        $this->bookPriceListRepository = $bookPriceListRepository;
    }

    /**
     * Get all BookPriceLists
     *
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */

    public function getAllBookPriceList(array $filters): LengthAwarePaginator
    {
        $with = ['category', 'keywords'];

        return $this->bookPriceListRepository
            ->getBookPriceListWith($with, $filters)
            ->paginate(\Utility::$displayRecordPerPage);
    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function storeBookPriceList(array $input)
    {
        try {
            return $this->bookPriceListRepository->create($input);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateBookPriceList($input, $id)
    {
        try {
            $bookPriceList = $this->bookPriceListRepository->find($id);
            $this->bookPriceListRepository->update($input, $id);
            return $bookPriceList;
        } catch (ModelNotFoundException $e) {
            Log::error('BookPriceList not found');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showBookPriceListByID($id)
    {
        return $this->bookPriceListRepository->find($id);
    }

    /**
     * @param $input
     * @return mixed
     */
  /*public function ShowAllBookPriceList($input)
    {
        return $this->bookPriceListRepository->bookPriceListFilterData($input);
    }*/
    public function ShowAllBookPriceList()
    {
        return $this->bookPriceListRepository->allBookPriceList();
    }

    public function ShowAllBookPriceListFrontend($input)
    {
        return $this->bookPriceListRepository->allBookPriceListFrontendList($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function bookPriceListCustomInsert($input)
    {
        $output['book_name'] = $input['book_name'];
        if(isset($input['cover_price'])){
            $output['cover_price'] = $input['cover_price'];
        }
        if(isset($input['retail_price'])){
            $output['retail_price'] = $input['retail_price'];
        }
        if(isset($input['wholesale'])){
            $output['wholesale'] = $input['wholesale'];
        }
        $output['status'] = $input['status'];
        $output['created_by'] = Auth::id();
        $output['created_at'] = Carbon::now();
        return $this->storeBookPriceList($output);
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function bookPriceListCustomUpdate($input, $id)
    {
        $output['book_name'] = $input['book_name'];
        $output['cover_price'] = $input['cover_price'];
        $output['retail_price'] = $input['retail_price'];
        $output['wholesale'] = $input['wholesale'];
        $output['status'] = $input['status'];
        $output['updated_by'] = Auth::id();
        $output['updated_at'] = Carbon::now();
        return $this->updateBookPriceList($output, $id);
    }
    public function deleteBookPriceList($id)
    {
        return $this->bookPriceListRepository->delete($id);
    }
}
