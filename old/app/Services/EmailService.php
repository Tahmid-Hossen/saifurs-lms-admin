<?php

namespace App\Services;

use App\Mail\SaleInvoiceMail;
use App\Repositories\Backend\Sale\SaleRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;

class EmailService
{
    /**
     * @var SaleRepository
     */
    private $saleRepository;

    /**
     * @param SaleRepository $saleRepository
     */
    public function __construct(SaleRepository $saleRepository)
    {
        $this->saleRepository = $saleRepository;
    }

    /**
     * @param $sale_Id
     * @param array $options
     * @return bool
     */
    public function sendAfterPaymentInvoice($sale_Id, array $options = []): bool
    {
        try {
            $sale = $this->saleRepository->find($sale_Id);
            $subject = "Order#" . ($sale->transaction_id ?? '' ) ." Payment Confirmation Mail";
            Mail::to($sale->customer_email)->send(new SaleInvoiceMail($sale, $subject, 'receipt'));

            if (empty(Mail::failures())) {
                return true;
            } else {
                \Log::error("Email Send Failure.", Mail::failures());
                return false;
            }
        } catch (ModelNotFoundException $modelNotFoundException) {
            \Log::error($modelNotFoundException->getMessage());
            return false;
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            return false;
        }
    }

    /**
     * @param $sale_Id
     * @param array $options
     * @return bool
     */
    public function sendBeforePaymentInvoice($sale_Id, array $options = []): bool
    {
        try {
            $sale = $this->saleRepository->find($sale_Id);
            $subject = "Order#" . ($sale->transaction_id ?? '' ) ." Details Confirmation Mail";
            Mail::to($sale->customer_email)->send(new SaleInvoiceMail($sale, $subject, 'invoice'));

            if (empty(Mail::failures())) {
                return true;
            } else {
                \Log::error("Email Send Failure.", Mail::failures());
                return false;
            }
        } catch (ModelNotFoundException $modelNotFoundException) {
            \Log::error($modelNotFoundException->getMessage());
            return false;
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            return false;
        }
    }



}
