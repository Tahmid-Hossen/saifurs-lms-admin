<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Services\Backend\Sale\TransactionService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionQueryController extends Controller
{
    /**
     * @var TransactionService
     */
    private $transactionService;

    /**
     * @param TransactionService $transactionService
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        try {
            $this->transactionService->checkTransactionStatus($request->all());
        } catch (\ErrorException $e) {
        } catch (GuzzleException $e) {
        }
    }
}
