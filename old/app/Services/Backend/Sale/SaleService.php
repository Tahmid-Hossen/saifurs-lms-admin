<?php


namespace App\Services\Backend\Sale;

use App\Repositories\Backend\Books\BookRepository;
use App\Repositories\Backend\CourseManage\CourseRepository;
use App\Repositories\Backend\Sale\SaleRepository;
use App\Services\Backend\Coupon\CouponService;
use App\Services\EmailService;
use App\Services\UtilityService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Class SaleService
 * @package App\Services\Backend\Sale
 */
class SaleService
{
    /**
     * @var SaleRepository
     */
    private $saleRepository;
    /**
     * @var CouponService
     */
    private $couponService;
    /**
     * @var BookRepository
     */
    private $bookRepository;
    /**
     * @var CourseRepository
     */
    private $courseRepository;
    /**
     * @var EmailService
     */
    private $emailService;

    /**
     * SaleService constructor.
     * @param SaleRepository $saleRepository
     * @param CouponService $couponService
     * @param BookRepository $bookRepository
     * @param CourseRepository $courseRepository
     * @param EmailService $emailService
     */
    public function __construct(SaleRepository   $saleRepository,
                                CouponService    $couponService,
                                BookRepository   $bookRepository,
                                CourseRepository $courseRepository,
                                EmailService     $emailService
    )
    {
        $this->saleRepository = $saleRepository;
        $this->couponService = $couponService;
        $this->bookRepository = $bookRepository;
        $this->courseRepository = $courseRepository;
        $this->emailService = $emailService;
    }

    /**
     * Get all Sales
     *
     * @param array $filters
     * @return Builder|null
     */
    public function getAllSale(array $filters): ?Builder
    {
        $sales = null;
        try {
            $sales = $this->saleRepository->getSaleWith($filters);
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
        } finally {
            return $sales;
        }
    }

    /**
     * @param array $input
     * @param array $items
     * @return mixed
     * @throws Exception|Throwable
     */
    public function storeSale(array $input, array $items)
    {
        \DB::beginTransaction();
        \Log::info('Sale Info', $input);

        if ($input['cod_total_amount'] == 0) {
            $input['total_amount'] -= $input['shipping_cost'];
            $input['shipping_cost'] = 0;
        }

        try {
            $saleModel = $this->saleRepository->create($input);
            \Log::info('Sale Insert Confirmed');
            try {
                $saleModel->items()->createMany($items);
                \Log::info('Items Info', $items);
                $saleModel->refresh();
                $transaction_id = $this->generateTransactionId($saleModel->id);
                $saleModel->transaction_id = $transaction_id;
                $saleModel->save();
                $saleModel->refresh();
                \DB::commit();
                return $saleModel;

            } catch (\Exception $exception) {
                throw new \Exception($exception->getMessage());
                \Log::error("Item Insert Error: " . $exception->getMessage());
                \DB::rollback();
                return null;
            }
        } catch (\Exception $exception) {
            \Log::error("Sale Model Error: " . $exception->getMessage());
            \DB::rollback();
            return null;
        }
    }

    /**
     * @param $input
     * @param array $items
     * @param int $id
     * @param bool $onlySale
     * @return bool
     */
    public function updateSale($input, array $items, int $id, bool $onlySale = false): bool
    {
        $confirm = false;
        try {
            if ($saleModel = $this->saleRepository->find($id)) {
                //update sale model
                $confirm = (bool)$this->saleRepository->update($input, $id);
                if ($confirm == true && $onlySale === false) {
                    //update child item info
                    $confirm = $this->saleRepository->updateSaleItems($items, $id);
                }

                return $confirm;
            }
        } catch (ModelNotFoundException $e) {
            \Log::error('Sale not found');
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
        return $confirm;
    }


    /**
     * @param $id
     *
     * @return mixed
     */
    public function showSaleByID($id)
    {
        return $this->saleRepository->find($id);
    }

    /**
     * @param array $input
     * @return array
     * @throws Exception
     */
    public function getRequestDataFormatted(array $input): array
    {
        $sale = [];
        try {
            $order = $this->formatSaleItemsInformation($input);
            $saleDetails = $this->formatSaleDetailInformation($input);
            $couponFeedback = $this->getCouponInfos([
                'coupon_code' => ($input['coupon_code'] ?? ''),
                'company_id' => auth()->user()->userDetails->company_id,
                'coupon_status' => 'ACTIVE', 'coupon_end_verify' => true],
                $order['subTotal'], ($input['shipping_cost'] ?? 0), $order);

            $sale['info'] = array_merge($saleDetails, $couponFeedback);
            $sale['items'] = $order['items'];
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        } finally {
            return $sale;
        }
    }

    /**
     * @param $coupon_info
     * @param $subTotal
     * @param $shipCost
     * @param array $others
     * @return array
     * @throws Exception
     */
    public function getCouponInfos($coupon_info, $subTotal, $shipCost, array $others = []): array
    {
        $discount = $coupon = [];
        $coupon = $this->couponService->validateCoupon($coupon_info);
        $discount = \Utility::calculateDiscountAmount(($coupon['discount_amount'] ?? 0), $subTotal, $coupon['discount_type'] ?? 'fixed');

        $payment = [
            'online_total_amount' => $others['onlineTotalAmount'] ?? 0,
            'cod_total_amount' => $others['codTotalAmount'] ?? 0,
            'sub_total_amount' => $subTotal,
            'coupon_id' => $coupon['id'] ?? null,
            'discount_type' => $coupon['discount_type'] ?? 'fixed',
            'discount_amount' => $discount ?? 0,
        ];

        $payment['total_amount'] = ($subTotal - $payment['discount_amount']) + $shipCost;

        $payment['due_amount'] = $payment['total_amount'];

        return $payment;
    }

    /**
     * @param array $input
     * @return array
     */
    public function formatSaleDetailInformation(array $input): array
    {
        \Log::info("Format Sale Order Info" . json_encode($input ?? []));

        //Android Int to null Exception
        $input['branch'] = (isset($input['branch']) && $input['branch'] == -1) ? null : $input['branch'];

        return [
            'user_id' => ($input['user'] == 0) ? null : $input['user'],
            'company_id' => $input['company'],
            'branch_id' => $input['branch'] ?? null,
            'reference_number' => $input['reference_number'] ?? null,
            'entry_date' => $input['entry_date'] ?? Carbon::now(),
            'customer_name' => $input['name'] ?? null,
            'customer_email' => $input['email'] ?? null,
            'customer_phone' => $input['phone'] ?? null,
            'ship_address' => $input['ship_address'] ?? null,
            'notes' => $input['notes'] ?? null,
            'transaction_id' => $input['transaction_id'] ?? null,
            'transaction_response' => json_encode($input['transaction_response'] ?? '') ?? null,
            'currency' => $input['currency'] ?? 'BDT',
            'payment_status' => $input['payment_status'] ?? 'unpaid',
            'sale_status' => $input['sale_status'] ?? 'pending',
            'source_type' => $input['source_type'] ?? 'office',
            'shipping_cost' => $input['shipping_cost'] ?? 0
        ];

    }

    /**
     * @param array $input
     * @return array
     */
    public function formatSaleItemsInformation(array $input): array
    {
        Log::info("Format Sale Invoice" . json_encode($input ?? []));
        $invoice = [
            'subTotal' => 0,
            'items' => [],
            'codTotalAmount' => 0,
            'onlineTotalAmount' => 0
        ];

        try {
            foreach ($input['invoice'] as $index => $item) {

                $itemInfo = $this->getItemInfo($item['item']);

                //TODO per item discount for future
                $invoice['items'][$index] = [
                    'item_id' => $itemInfo[1],
                    'item_path' => $itemInfo[0],
                    'item_description' => null,
                    'item_extra' => json_encode(UtilityService::subArray($item, ['item', 'price', 'quantity', 'total', 'discount_amount', 'pay_method'])),
                    'price_amount' => $item['price'],
                    'quantity' => $item['quantity'],
                    'sub_total_amount' => ($item['price'] * $item['quantity']),
                    'discount_amount' => $item['discount_amount'] ?? 0,
                    'total_amount' => $item['total'] ?? 0,
                    'delivery_type' => $item['pay_method'] ?? 'online'
                ];

                if (isset($item['item_id']))
                    $invoice['items'][$index]['item_id'] = $item['item_id'];

                if (isset($item['item_path']))
                    $invoice['items'][$index]['item_path'] = $item['item_path'];

                if (isset($item['pay_method']) && $item['pay_method'] == 'cod')
                    $invoice['codTotalAmount'] += $item['total'];

                if (isset($item['pay_method']) && $item['pay_method'] == 'online')
                    $invoice['onlineTotalAmount'] += $item['total'];

                $invoice['subTotal'] += $item['total'];

            }
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
        } finally {
            return $invoice;
        }
    }

    /**
     * @param $saleId
     * @return string|null
     * @throws Exception
     */
    public function generateTransactionId($saleId): ?string
    {
        try {
            //Company_id-Branch_id-Sale_primary_key
            //Let aleshatech LMS
            //C001-B001-I0000000001

            $company_id = auth()->user()->userDetails->company_id;
            $branch_id = auth()->user()->userDetails->branch_id ?? 0;
            $sale_id = $saleId;


            $transaction_id = 'C' . str_pad($company_id, 3, '0', STR_PAD_LEFT);
            $transaction_id .= 'B' . str_pad($branch_id, 3, '0', STR_PAD_LEFT);
            $transaction_id .= 'I' . str_pad($sale_id, 9, '0', STR_PAD_LEFT);

            return $transaction_id;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
            return null;
        }
    }


    /**
     * @param array $filters
     * @return array
     */
    public function searchItems(array $filters): array
    {
        //Run Book Search
        $book_params = array_merge($filters, ['book_status' => 'ACTIVE']);
        $books = $this->bookRepository->getBookWith($book_params)->get();

        $course_params = array_merge($filters, ['course_status' => 'ACTIVE']);
        $courses = $this->courseRepository->course($course_params)->get();

        $bookItems = $this->convertBookToItem($books);
        $courseItems = $this->convertCourseToItem($courses);

        return array_merge($bookItems, $courseItems);
    }

    /**
     * @param $collection
     * @return array
     */
    private function convertBookToItem($collection): array
    {
        $items = [];

        if (!empty($collection)) {
            foreach ($collection as $item) {
                $items[] = [
                    'id' => 'book_' . $item->book_id,
                    'title' => $item->book_name . (isset($item->edition) ? (' - ' . $item->edition) : ''),
                    'image' => $item->getPhotoFullPathAttribute(),
                    'type' => ($item->is_ebook == 'YES') ? 'EBook' : 'Book',
                    'provider' => ($item->author ?? 'Not Available'),
                    'description' => $item->book_description ?? '',
                    'price' => (!empty($item->book_price) ? \CHTML::customNumberFormat(($item->book_price ?? 0), 2) : 'FREE')
                ];
            }
        }

        return $items;
    }

    /**
     * @param $collection
     * @return array
     */
    private function convertCourseToItem($collection): array
    {
        $items = [];

        if (!empty($collection)) {
            foreach ($collection as $item) {
                $items[] = [
                    'id' => 'course_' . $item->id,
                    'title' => $item->course_title,
                    'image' => $item->getCourseImageFullPathAttribute(),
                    'type' => 'Course',
                    'provider' => ($item->company->company_name ?? 'Not Available'),
                    'desc' => $item->course_short_description ?? '',
                    'price' => $item->course_reqular_price ?? 'FREE'
                ];
            }
        }

        return $items;
    }

    /**
     * @param string $inputItem
     * @return array
     * @throws Exception
     */
    public function getItemInfo(string $inputItem): array
    {
        $items = [
            'course' => '\App\Models\Backend\Course\Course',
            'book' => '\App\Models\Backend\Books\Book',
        ];


        $itemInfo = [];

        $strArray = explode('_', $inputItem);
        try {
            $itemInfo[0] = $items[$strArray[0]];
            $itemInfo[1] = $strArray[1];
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        } finally {
            return $itemInfo;
        }
    }

    public function sendOrderConfirmMail($sale_id): bool
    {
        return $this->emailService->sendBeforePaymentInvoice($sale_id);
    }

    /**
     * @param array $input
     * @param $id
     * @return bool|void
     */
    public function updateSaleInfo(array $input, $id)
    {
        $confirm = false;
        try {
            if ($saleModel = $this->saleRepository->find($id)) {

                return (bool)$this->saleRepository->update($input, $id);
            }
        } catch (Exception $e) {
            \Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * @param $input
     * @param $id
     * @return mixed
     */
    public function updateSingleSale($input, $id)
    {
        return $this->saleRepository->update($input, $id);
    }

    /**
     * @param $input
     * @param $id
     * @return mixed
     */
    public function updateSingleSalePayment($input, $id)
    {
        return $this->saleRepository->update($input, $id);
    }
}
