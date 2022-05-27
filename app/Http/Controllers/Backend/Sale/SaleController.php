<?php

namespace App\Http\Controllers\Backend\Sale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Sale\SaleRequest;
use App\Mail\SaleInvoiceMail;
use App\Services\Backend\Sale\SaleService;
use App\Services\Backend\Sale\TransactionService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use Auth;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

/**
 * Class SaleController
 * @package App\Http\Controllers\Backend\Sale
 */
class SaleController extends Controller
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
     * @var TransactionService
     */
    private $transactionService;

    /**
     * SaleController constructor.
     * @param UserService $userService
     * @param SaleService $saleService
     * @param CompanyService $companyService
     * @param TransactionService $transactionService
     */
    public function __construct(
        UserService        $userService,
        SaleService        $saleService,
        CompanyService     $companyService,
        TransactionService $transactionService
    )
    {
        $this->userService = $userService;
        $this->saleService = $saleService;
        $this->companyService = $companyService;
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $sales = $this->saleService->getAllSale($requestData)->paginate(\Utility::$displayRecordPerPage);
            $companies = $this->companyService->getCompanyDropDown();

            return view('backend.sale.sale.index', compact('companies', 'sales', 'request'));
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            flash('Sale Table Not Found', 'error');
            return redirect()->route('dashboard');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('backend.sale.sale.create', [
            'companies' => $this->companyService->getCompanyDropDown(),
            'users' => $this->userService->getUserDropDown()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SaleRequest $saleRequest
     * @return RedirectResponse
     * @throws Exception|\Throwable
     */
    public function store(Request $saleRequest)
    {
        try {
            $sale = $this->saleService->getRequestDataFormatted($saleRequest->except('_token'));

            if (isset($sale['info']) && (isset($sale['items']) && count($sale['items']) > 0)) {
                $sale['info']['source_type'] = 'office';

                if (!empty($this->saleService->storeSale($sale['info'], $sale['items']))) {
                    flash('Sale created successfully', 'success');
                    return redirect()->route('sales.index');
                } else {
                    flash('Failed to create new Sale!', 'error');
                    return redirect()->route('sales.index');
                }
            } else {
                flash('Missing Items /Client Information', 'warning');
                return redirect()->route('sales.create');
            }

        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
            flash('Failed to create new Sale!', 'error');
            return redirect()->back()->withInput($saleRequest->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function show(int $id)
    {
        try {
            $sale = $this->saleService->showSaleByID($id);

            return view('backend.sale.sale.show', [
                'sale' => $sale
            ]);

        } catch (Exception $exception) {

            Log::error($exception->getMessage());
            flash('Sale Not Found', 'error');
            return redirect()->route('sales.index');
        }
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
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     */
    public function updateFields(Request $request, int $id)
    {
        DB::beginTransaction();
        try {
            $saleModel = $this->saleService->showSaleByID($id);

            if ($this->saleService->updateSaleInfo($request->all(), $id)) {
                if ($this->transactionService->updateItemRelations($saleModel) === true) {
                    DB::commit();
                    flash('Sale Updated successfully', 'success');
                    return redirect()->back();
                }
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            \Log::error($exception->getMessage());
            flash('Failed to update Sale!', 'error');
            return redirect()->back();
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
        $items = $this->saleService->searchItems($request->all());
        return response()->json($items);
    }

    //For API Purpose
    public function purchases(Request $request)
    {

        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            //Set for auth user
            $requestData['user_id'] = $requestData['user_id'] ?? auth()->user()->id;

            $sales = $this->saleService->getAllSale($requestData)->paginate(\Utility::$displayRecordPerPage);
            $companies = $this->companyService->getCompanyDropDown();

            return view('backend.sale.sale.index', compact('companies', 'sales', 'request'));
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            flash('Sale Table Not Found', 'error');
            return redirect()->route('dashboard');
        }

    }

    /**
     * @param $id
     * @throws Exception
     */
    public function printInvoicePDF($id)
    {
        try {
            if ($sale = $this->saleService->showSaleByID($id)) {
                echo $sale->customer_email;
                Mail::to($sale->customer_email)->send(new SaleInvoiceMail($sale, '', ''));
                \Log::error(Mail::failures());
            }

        } catch (Exception $exception) {
            throw new \Exception($exception->getMessage());
            /*            flash('Sale Not Found', 'error');
                        return redirect()->route('sales.index');*/
        }
    }

    public function orderMarkedAsRead($id)
    {
        try {
            $user = Auth::user();
            $notification = $user->notifications->find($id);
            $notification->markAsRead();
            $order_id = $notification->data['id'];
            return redirect(route('sales.show', $order_id));
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            flash('Notification For this Order is Not Found', 'error');
            return redirect(back('sales.index'));
        }

    }

    public function statusUpdate(Request $request, $id)
    {
        $input = [
            'sale_id' => $id,
            'sale_status' => $request->get('sale_status')
        ];
        $result = $this->saleService->updateSingleSale($input, $id);
        if ($result === true) {
            flash('Sale Status Updated', 'success');
        } else {
            flash('Sale Status Can\'t be Updated', 'error');
        }
        return redirect()->back();
    }

    public function paymentStatusUpdate(Request $request, $id)
    {
        $input = [
            'payment_status' => $request->payment_status
        ];

        if ($input['payment_status'] == 'paid') {
            $input['due_amount'] = 0;
            $input['sale_status'] = 'processing';
        }

        $result = $this->saleService->updateSingleSalePayment($input, $id);

        if ($result === true) {
            flash('Sale Payment Status Updated', 'success');
        } else {
            flash('Sale Payment Status Can\'t be Updated', 'error');
        }
        return redirect()->back();
    }

}
