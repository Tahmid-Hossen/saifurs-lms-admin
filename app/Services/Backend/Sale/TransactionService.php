<?php

namespace App\Services\Backend\Sale;

use App\Models\Backend\Books\Book;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Sale\Item;
use App\Models\Backend\Sale\Sale;
use App\Repositories\Backend\CourseManage\CourseBatchRepository;
use App\Repositories\Backend\Enrollment\EnrollmentRepository;
use App\Repositories\Backend\Sale\SaleRepository;
use App\Repositories\Backend\Sale\TransactionRepository;
use App\Services\EmailService;
use App\Services\SSLCommerzService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\DB;

/**
 * Class SalePaymentService
 * @package App\Services\Backend\Sale
 */
class TransactionService
{
    /**
     * @var SaleRepository
     */
    private $saleRepository;
    /**
     * @var TransactionRepository
     */
    private $transactionRepository;
    /**
     * @var EnrollmentRepository
     */
    private $enrollmentRepository;
    /**
     * @var CourseBatchRepository
     */
    private $courseBatchRepository;
    /**
     * @var EmailService
     */
    private $emailService;


    /**
     * TransactionService constructor.
     * @param SaleRepository $saleRepository
     * @param TransactionRepository $transactionRepository
     * @param EnrollmentRepository $enrollmentRepository
     * @param CourseBatchRepository $courseBatchRepository
     * @param EmailService $emailService
     */
    public function __construct(SaleRepository        $saleRepository,
                                TransactionRepository $transactionRepository,
                                EnrollmentRepository  $enrollmentRepository,
                                CourseBatchRepository $courseBatchRepository,
                                EmailService          $emailService
    )
    {
        $this->saleRepository = $saleRepository;
        $this->transactionRepository = $transactionRepository;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->courseBatchRepository = $courseBatchRepository;
        $this->emailService = $emailService;
    }


    /**
     * @param string $trans_id
     * @return mixed
     */
    public function showSaleByTransactionId(string $trans_id)
    {
        return $this->saleRepository->getSaleWith(['transaction_id' => $trans_id])->get()->first();
    }

    /**
     * @param Sale $saleModel
     * @param array $data
     * @return bool
     */
    public function updateSaleModelStatus(Sale $saleModel, array $data): bool
    {
        $saleInfo = [];

        $saleInfo['transaction_response'] = $data['payment_gateway_response'];
        //TODO Partial AMount
        \Log::info("Transaction Data: " . json_encode($data));
        //Currently considering first payment is only payment
        $saleInfo['due_amount'] = abs($saleModel->total_amount - $data['amount']);

        if ($saleInfo['due_amount'] == 0) {
            $saleInfo['sale_status'] = 'completed';
            $saleInfo['payment_status'] = 'paid';
        } else {
            $saleInfo['sale_status'] = 'processing';
            $saleInfo['payment_status'] = 'partial';
        }
        return (bool)$this->saleRepository->update($saleInfo, $saleModel->id);
    }

    /**
     * @param Sale $saleModel
     * @param Item $item
     * @param Course $course
     * @return bool
     */
    public function enrollCourseToUser(Sale $saleModel, Item $item, Course $course): bool
    {
        $confirmation = false;
        try {
            $user = $saleModel->user;
            $item_extra = $item->item_extra_info_array;
            $batch_id = null;
            if (array_key_exists('batch', $item_extra)) {
                $batch_id = $item_extra['batch'];
            }
            //Add User To Enroll List
            $enrollmentData = [
                'company_id' => $user->userDetails->company_id,
                'course_id' => $course->id,
                'user_id' => $user->id,
                'batch_id' => $batch_id ?? null,
                'order_id' => $saleModel->id ?? '',
                'enroll_details' => $saleModel->notes ?? '',
                'enroll_status' => 'ACTIVE'
            ];
            $confirmation = (bool)$this->enrollmentRepository->create($enrollmentData);

            //if course have any batch to available
            //Add User To Batch
            if (!is_null($batch_id)) {
                $courseBatch = $this->courseBatchRepository->find($batch_id);
                $courseBatch->student()->attach($user->id);
                $confirmation = (bool)$courseBatch->save();
            }
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
        }
        return $confirmation;
    }

    /**
     * This is a rule violation
     * But Working
     * @param Sale $saleModel
     * @param Item $item
     * @param Book $book
     * @return bool
     */
    public function assignBookToUser(Sale $saleModel, Item $item, Book $book): bool
    {
        try {
            $book->users()->attach($saleModel->user_id);
            return (bool)$book->save();
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return false;
        }
    }


    /**
     * @param array $inputs
     * @return string[]
     */
    public function storeTransaction(array $inputs): array
    {
        DB::beginTransaction();
        try {
            $response = [];
            //input is a sslcommerz success, fail, cancel request data
            \Log::info(json_encode($inputs));
            if (isset($inputs['tran_id']) && isset($inputs['status'])) :
                if ($saleModel = $this->showSaleByTransactionId($inputs['tran_id'])):

                    \Log::info("Sale Model" . json_encode($saleModel));

                    $transaction = SSLCommerzService::convertSSLResponseToTransaction($inputs);
                    $transaction['sale_id'] = $saleModel->id;

                    \Log::info("Transaction Response" . json_encode($transaction));
                    if ($this->transactionRepository->create($transaction)):

                        if ($this->updateSaleModelStatus($saleModel, $transaction)) :
                            $saleModel->refresh();

                            //Apply All Access to source
                            if ($saleModel->payment_status == 'paid'):
                                if ($this->updateItemRelations($saleModel) === true):
                                    DB::commit();
                                    $response = ['status' => true, 'status-str' => 'ASSIGN-DONE', 'message' => 'All course and book are assigned'];

                                    //Send Payment Confirmation Email
                                    $this->sendPaymentConfirmMail($saleModel->id);

                                else:
                                    $response = ['status' => false, 'status-str' => 'ASSIGN_FAILED', 'message' => 'Payment Status is Not paid'];
                                endif;
                            else:
                                $response = ['status' => false, 'status-str' => 'PAYMENT-FAILED', 'message' => 'Payment Status is Not paid'];
                            endif;
                        else:
                            $response = ['status' => false, 'status-str' => 'SALE-PAY-FAILED', 'message' => 'Sale Model Transaction status update failed'];
                        endif;
                    else:
                        $response = ['status' => false, 'status-str' => 'TRANSACTION-FAILED', 'message' => 'Transaction entry failed'];
                    endif;
                else :
                    $response = ['status' => false, 'status-str' => 'SALE_MISSING', 'message' => 'No sale found using this transaction id'];
                endif;
            else :
                $response = ['status' => false, 'status-str' => 'INVALID', 'message' => 'Request have no transaction information'];
            endif;
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            DB::rollBack();
        }

        \Log::error("Transaction Entry Error: ", $response);
        return $response;
    }

    /**
     * @param Sale $saleModel
     * @return bool
     */
    public function updateItemRelations(Sale $saleModel): bool
    {
        foreach ($saleModel->items as $item) {
            $sourceItem = $item->item_source;
            if ($sourceItem instanceof Book) {
                $con = (bool)$this->assignBookToUser($saleModel, $item, $sourceItem);
                if ($con == false) {
                    return false;
                }
            } else if ($sourceItem instanceof Course) {
                $con = (bool)$this->enrollCourseToUser($saleModel, $item, $sourceItem);
                if ($con == false) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * @param $sale_id
     * @return bool
     */
    public function sendPaymentConfirmMail($sale_id): bool
    {
        return $this->emailService->sendAfterPaymentInvoice($sale_id);
    }

    /**
     * @param array $inputs
     * @return array
     * @throws GuzzleException
     */
    public function checkTransactionStatus(array $inputs): array
    {
        $sslConfig = config('sslcommerz');
        $mode = $sslConfig['mode'];

        if (!empty($sslConfig)) {

            $client = new \GuzzleHttp\Client([
                'base_uri' => $sslConfig[$mode]['api_domain'],
                'timeout' => 60,
                'verify' => !$sslConfig[$mode]['is_localhost']
            ]);

            if (!empty($inputs['tran_id'])) {
                $response = $client->get($sslConfig[$mode]['transaction_status'], [
                    'query' => [
                        'tran_id' => $inputs['tran_id'],
                        'store_id' => $sslConfig[$mode]['store_id'],
                        'store_passwd' => $sslConfig[$mode]['store_password']
                    ]
                ]);

                $output = json_decode($response->getBody()->getContents());

                if ($output->APIConnect == 'INVALID_REQUEST') {
                    $answer = ['status' => false, 'message' => 'Invalid data imputed to call the API', 'output' => $output];
                } else if ($output->APIConnect == 'FAILED') {
                    $answer = ['status' => false, 'message' => 'API Authentication Failed', 'output' => $output];
                } else if ($output->APIConnect == 'INACTIVE') {
                    $answer = ['status' => false, 'message' => 'API User/Store ID is Inactive', 'output' => $output];
                } else if ($output->APIConnect == 'DONE') {
                    $answer = ['status' => true, 'message' => 'Payment Confirmed', 'output' => $output];
                }

                return $answer;
            } else {
                \Log::error("No Transaction id found to check transaction status.");
                return ['status' => false, 'message' => "No Transaction id found to check transaction status."];
            }
        } else {
            \Log::error("SSLCommerz Configuration is Missing.");
            return ['status' => false, 'message' => "SSLCommerz Configuration is Missing."];
        }
    }
}
