<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Sale\SalePaymentRequest;
use App\Services\Backend\Sale\SaleService;
use App\Services\Backend\Sale\TransactionService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Log;

/**
 * Class SalePaymentController
 * @package App\Http\Controllers\Backend\Sale
 */
class TransactionController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var SaleService
     */
    private $saleService;
    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var TransactionService
     */
    private $transactionService;

    /**
     * SalePaymentController constructor.
     * @param UserService $userService
     * @param SaleService $saleService
     * @param CompanyService $companyService
     * @param TransactionService $transactionService
     */
    public function __construct(UserService $userService,
                                SaleService $saleService,
                                CompanyService $companyService,
                                TransactionService $transactionService)
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
     * @return RedirectResponse|View
     */
    public function index(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $sales = $this->saleService->getAllSale($requestData)->paginate(\Utility::$displayRecordPerPage);
            $companies = $this->companyService->getCompanyDropDown();

            return view('backend.sale.transaction.index', compact('companies', 'sales', 'request'));
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            flash('Transaction Table Not Found', 'error');
            return redirect()->route('dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(Request $request): View
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $sales = $this->saleService->getAllSale($requestData)->get();
            $companies = $this->companyService->getCompanyDropDown();

            return view('backend.sale.transaction.create', compact('companies', 'sales', 'request'));
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            flash('Transaction Table Not Found', 'error');
            return redirect()->route('dashboard');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $transactionRequest
     * @return JsonResponse
     */
    public function store(Request $transactionRequest): JsonResponse
    {
        $inputs = $transactionRequest->all();
        $response = $this->transactionService->storeTransaction($inputs);
        return response()->json($response, 200);

    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @param int $id
     * @param SalePaymentRequest $salePaymentRequest
     * @param int $id
     * @param int $id
     * @param Request $request
     * @param Request $request
     * @return Application|Factory|View
     *
     * public function show($id)
     * {
     * try {
     * $salePayment = $this->salePaymentService->showSalePaymentByID($id);
     *
     * return view('backend.sale.transaction.show', [
     * 'salePayment' => $salePayment
     * ]);
     *
     * } catch (Exception $exception) {
     *
     * Log::error($exception->getMessage());
     * flash('SalePayment Not Found', 'error');
     * return redirect()->route('salePayments.index');
     * }
     * }
     *
     * /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     *
     * public function edit($id)
     * {
     * try {
     * $salePayment = $this->salePaymentService->showSalePaymentByID($id);
     * return view('backend.sale.transaction.edit', [
     * 'salePayment' => $salePayment
     * ]);
     * } catch (Exception $exception) {
     *
     * Log::error($exception->getMessage());
     * flash('SalePayment Not Found', 'error');
     * return redirect()->route('salePayments.index');
     * }
     * }
     *
     * /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     *
     * public function update(SalePaymentRequest $salePaymentRequest, $id)
     * {
     * try {
     * $salePayment = [
     * 'salePayment_status' => \Utility::$statusText[$salePaymentRequest->status],
     * ];
     *
     * $this->salePaymentService->updateSalePayment($salePayment);
     * flash('SalePayment Updated successfully', 'success');
     * return redirect()->route('salePayments.index');
     *
     * } catch (\Exception $exception) {
     * \Log::error($exception->getMessage());
     * flash('Failed to update SalePayment!', 'error');
     * return redirect()->back()->withInput($salePaymentRequest->all());
     * }
     * }
     *
     * /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     *
     * public function destroy(int $id): RedirectResponse
     * {
     * $user_get = $this->userService->whoIS($_REQUEST);
     * if (isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id) {
     * try {
     * $salePayment = $this->salePaymentService->showSalePaymentByID($id);
     * $salePayment->delete();
     * flash('Book SalePayment deleted successfully', 'success');
     *
     * } catch (Exception $exception) {
     * Log::error($exception->getMessage());
     * flash('SalePayment not found!')->error();
     * }
     * } else {
     * flash('You Entered Wrong Password!')->error();
     * }
     * return redirect()->route('salePayments.index');
     * }
     *
     * /**
     * @return Application|Factory|View|RedirectResponse
     * @return Application|Factory|View|RedirectResponse
     *
     * public function excel(Request $request)
     * {
     * try {
     * $inputs = $request->query();
     * $filters = array_merge($inputs, $this->dateRangePicker($inputs));
     *
     * return view('backend.sale.transaction.excel', [
     * 'salePayments' => $this->salePaymentService->getAllSalePayment($filters)->get()
     * ]);
     * } catch (Exception $exception) {
     * Log::error($exception->getMessage());
     * flash('No SalePayments Found For Export');
     * return redirect()->route('books.index');
     * }
     * }
     *
     * public function gatewayResponse(Request $request)
     * {
     * \Log::info("Sale Gateway Feedback" . json_encode($request->all()));
     * $inputs = $request->except('_token');
     * $this->transactionService->updateTransactionStatus($inputs);
     * }
     * *@throws Exception
     *
     * public function pdf(Request $request)
     * {
     * try {
     * $inputs = $request->query();
     * $filters = array_merge($inputs, $this->dateRangePicker($inputs));
     *
     * return view('backend.sale.transaction.pdf', [
     * 'salePayments' => $this->salePaymentService->getAllSalePayment($filters)->get()
     * ]);
     * } catch (Exception $exception) {
     * Log::error($exception->getMessage());
     * flash('No SalePayments Found For Export');
     * return redirect()->route('books.index');
     * }
     * }
     *
     * /**
     */
}
