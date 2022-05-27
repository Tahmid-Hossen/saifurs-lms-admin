<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\OrderConfirmEvent;
use App\Http\Requests\Backend\Sale\SaleRequest;
use App\Services\Backend\Coupon\CouponService;
use App\Services\Backend\Sale\SaleService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class SaleController
 * @package App\Http\Controllers\Backend\Sale
 */
class SaleController
{
    /**
     * @var SaleService
     */
    private $saleService;

    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var CouponService
     */
    private $couponService;

    /**
     * SaleController constructor.
     * @param UserService $userService
     * @param SaleService $saleService
     * @param CompanyService $companyService
     * @param CouponService $couponService
     */
    public function __construct(
        UserService    $userService,
        SaleService    $saleService,
        CompanyService $companyService,
        CouponService  $couponService
    )
    {
        $this->userService = $userService;
        $this->saleService = $saleService;
        $this->companyService = $companyService;
        $this->couponService = $couponService;
    }

    //TODO NOT NOW

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Application|Factory|View
     *
     * public function index(Request $request)
     * {
     *
     * $inputs = $request->query();
     * $filters = array_merge($inputs, $this->dateRangePicker($inputs));
     * $sales = $this->saleService->getAllSale($filters);
     * $companies = $this->companyService->getCompanyDropDown();
     *
     * return view('backend.sale.sale.index', [
     * 'companies' => $companies,
     * 'sales' => $sales,
     * 'inputs' => $this->dateRangePicker($inputs),
     * 'filters' => $filters,
     * ]);
     *
     * }
     *
     * /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     *
     * public function create()
     * {
     * return view('backend.sale.sale.create', [
     * 'companies' => $this->companyService->getCompanyDropDown(),
     * 'users' => $this->userService->getUserDropDown()
     * ]);
     * }
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param SaleRequest $saleRequest
     * @return JsonResponse
     * @throws Exception|\Throwable
     */
    public function store(Request $saleRequest): JsonResponse
    {
        \Log::info("Sale Request data: " . json_encode($saleRequest->all()));
		//dd($saleRequest->all());
        $response = [
            'status' => false,
            'message' => '',
            'data' => [],
            'request' => [],
            'payment' => '',
            'online_payable_amount' => 0
        ];

        //try {
            $sale = $this->saleService->getRequestDataFormatted($saleRequest->except('_token'));
			
            \Log::info("Sale Formatted Info", $sale);
			//dd($sale);
            if (isset($sale['info']) && (isset($sale['items']) && count($sale['items']) > 0)) {
                $saleModel = $this->saleService->storeSale($sale['info'], $sale['items']);
                \Log::info("Sale Model OR NULL", ['saleModel' => $saleModel]);
				
				
				
                if (!is_null($saleModel)) {
                    $response['status'] = true;
                    $response['message'] = 'Sale created successfully';
                    $saleModel->refresh();
                    $response['data'] = $saleModel;
                    $response['payment'] = (isset($saleModel->online_total_amount) && $saleModel->online_total_amount > 0) ? 'online' : 'cod';

                    if ($response['payment'] == 'online') {
                        $onlineAmount = $saleModel->online_total_amount;

                        if (!is_null($saleModel->coupon)) {
                            $coupon = $saleModel->coupon->toArray();
                            $onlineAmount = $this->couponService->totalPriceCalculation($coupon, $onlineAmount);
                        }

                        $response['online_payable_amount'] = $onlineAmount;
                    }

                    $response['data']->makeHidden('coupon');
					//dd($response);
                    //OrderConfirmEvent::dispatch($saleModel);

                    return response()->json($response);
                } else {
                    $response['status'] = false;
                    $response['message'] = 'Failed to create new Sale!';
                    $response['data'] = $saleModel;

                    return response()->json($response);
                }
            } else {
                $response['status'] = false;
                $response['message'] = 'Missing Items /Client Information';
                $response['data'] = ['request' => $saleRequest->all(), 'formatted' => $sale];

                return response()->json($response);
            }

        /*} catch (\Exception $exception) {
            \Log::error($exception->getMessage());

            $response['status'] = false;
            $response['message'] = 'Failed To Create Sale Model';
            $response['data'] = ['request' => $saleRequest->all()];
            return response()->json($response);
        }*/
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $saleData = [];
        try {
            $saleObject = $this->saleService->showSaleByID($id);
            $saleData['sales'] = $saleObject;
            $saleData['sales']['user'] = $saleObject->user;
            //$saleData['sales']['user']['user_details'] = $saleObject->user->userDetails;
            $saleObject->user->userDetails;
            $saleObject->coupon;

            foreach ($saleObject->items as $index => $item):
                $saleData['sales']['items'][$index] = $item;
                $saleData['sales']['items'][$index]['original'] = $item->item_source;
                $saleData['sales']['items'][$index]['item_type'] = $item->item_type;
                $saleData['sales']['items'][$index]['item_name'] = $item->item_name;
                $saleData['sales']['items'][$index]['description'] = $item->description;
            endforeach;

            $saleData['status'] = true;
            $saleData['request'] = ['sale_id' => $id, 'param' => request()->all()];
            $jsonReturn = response()->json($saleData, 200);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Sales data not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View|RedirectResponse
     */
    public function edit(int $id)
    {
        try {
            $sale = $this->saleService->showSaleByID($id);

            return view('backend.sale.sale.edit', [
                'sale' => $sale,
                'items' => $sale->items,
                'companies' => $this->companyService->getCompanyDropDown(),
                'users' => $this->userService->getUserDropDown()
            ]);

        } catch (Exception $exception) {

            Log::error($exception->getMessage());
            flash('Sale Not Found', 'error');
            return redirect()->route('sales.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaleRequest $saleRequest
     * @param int $id
     * @return RedirectResponse
     * @throws Exception
     */
    public function update(SaleRequest $saleRequest, int $id): RedirectResponse
    {
        try {
            $sale = $this->saleService->getRequestDataFormatted($saleRequest->except('_token'));

            $this->saleService->updateSale($sale['info'], $sale['items'], $id);
            flash('Sale Updated successfully', 'success');
            return redirect()->route('sales.index');
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            flash('Failed to update Sale!', 'error');
            return redirect()->back()->withInput($saleRequest->all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if (isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id) {
            try {
                $sale = $this->saleService->showSaleByID($id);
                $sale->delete();
                flash('Book Sale deleted successfully', 'success');

            } catch (Exception $exception) {
                Log::error($exception->getMessage());
                flash('Sale not found!')->error();
            }
        } else {
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('sales.index');
    }

    public function invoice(int $id)
    {
        try {
            $sale = $this->saleService->showSaleByID($id);

            return view('backend.sale.sale.invoice', [
                'sale' => $sale
            ]);

        } catch (Exception $exception) {

            Log::error($exception->getMessage());
            flash('Sale Not Found', 'error');
            return redirect()->route('sales.index');
        }
    }

    /**
     * Return All Search Query from book and course
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function itemQuery(Request $request): JsonResponse
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());

            $data['items'] = $this->saleService->searchItems($requestData);
            $data['request'] = $request->all();
            $data['status'] = true;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Sales table not found!'], 200);
        }
        return $jsonReturn;
    }

    public function purchases(Request $request): JsonResponse
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : UtilityService::$displayRecordPerPage;
            $request['sale_sort_by_id'] = $request['sale_sort_by_id'] ?? 'DESC';
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            //Set for auth user
            $requestData['user_id'] = $requestData['user_id'] ?? auth()->user()->id;

            $data['sales'] = $this->saleService->getAllSale($requestData)->paginate($request->display_item_per_page);
            $data['request'] = $request->all();
            $data['status'] = true;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Sales table not found!'], 200);
        }
        return $jsonReturn;
    }
}
