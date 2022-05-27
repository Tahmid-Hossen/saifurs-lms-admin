<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Backend\BookPriceList\BookPriceListService;
use App\Services\Backend\User\UserService;
use App\Support\Configs\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookPriceListController extends Controller
{
    /**
     * @var bookPriceListService
     */
    private $bookPriceListService;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(BookPriceListService $bookPriceListService, UserService $userService) {
        $this->bookPriceListService = $bookPriceListService;
        $this->userService = $userService;
    }

    public function getBookPriceList(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            DB::beginTransaction();
            $request['status'] = Constants::$book_price_list_status;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser,$request->all());
            $bookpricelists = $this->bookPriceListService->ShowAllBookPriceListFrontend($requestData)->get();
            if(count($bookpricelists)>0):
                $data['BookPriceLists'] = $bookpricelists;
                $data['status'] = true;
            else:
                $data['status'] = false;
                $data['message'] = 'Data Not Found';
            endif;
            $data['request'] = $request->all();
            DB::commit();
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message'=>'Failed to found Book Price List!'], 200);
        }
        return $jsonReturn;
    }
}
