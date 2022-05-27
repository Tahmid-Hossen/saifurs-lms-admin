<?php

namespace App\Http\Controllers\Backend\Sale;

use App\Http\Controllers\Controller;
use App\Services\Backend\Sale\SaleService;
use App\Services\Backend\Sale\TransactionService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
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
    public function __construct(UserService        $userService,
                                SaleService        $saleService,
                                CompanyService     $companyService,
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
     * @return string[]
     */
    public function store(Request $transactionRequest): array
    {
        $inputs = $transactionRequest->except(['_token', 'status']);
        return $this->transactionService->storeTransaction($inputs);
    }


    /**
     * @param string $transaction_id
     * @return Redirector|void
     * @throws GuzzleException
     */
    public function checkStatus(string $transaction_id)
    {
        if ($sale = $this->transactionService->showSaleByTransactionId($transaction_id)) {

            $transactionStatus = $this->transactionService->checkTransactionStatus(['tran_id' => $transaction_id]);

            if ($transactionStatus['status'] == true) {

                return view('backend.sale.transaction.status', [
                    'transaction_response' => $transactionStatus,
                    'transaction_id' => $transaction_id
                ]);

            } else {
                flash($transactionStatus['message'], 'danger');
            }

        } else {
            flash("Invalid Transaction id found to check transaction status.");
        }

        return redirect()->back();
    }
}
