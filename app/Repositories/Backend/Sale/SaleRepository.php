<?php

namespace App\Repositories\Backend\Sale;

use App\Models\Backend\Sale\Sale;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class SaleRepository
 * @package App\Repositories\Backend\Sale
 */
class SaleRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Sale::class;
    }

    /**
     * Index and user input based list
     *
     * @param array $filters
     * @return Builder
     */
    public function getSaleWith(array $filters): Builder
    {
        $query = $this->model->sortable()->newQuery();

        if (!empty($filters)) {

            //search
            if (!empty($filters['search_text'])) {
                $query->where('transaction_id', '=', $filters['search_text']);
                $query->orWhere('customer_name', 'like', "%{$filters['search_text']}%");
                $query->orWhere('customer_email', 'like', "%{$filters['search_text']}%");
                $query->orWhere('customer_phone', 'like', "%{$filters['search_text']}%");
                $query->orWhere('sale_status', '=', $filters['search_text']);
                $query->orWhere('payment_status', '=', $filters['search_text']);
                $query->orWhere('source_type', '=', $filters['search_text']);
                $query->orWhere('reference_number', 'like', "%{$filters['search_text']}%");
            }

            //company
            if (!empty($filters['company_id'])) {
                $query->where('company_id', '=', $filters['company_id']);
            }

            //branch id
            if (!empty($filters['branch_id'])) {
                $query->where('branch_id', '=', $filters['branch_id']);
            }

            //TransactionID
            if (!empty($filters['transaction_id'])) {
                $query->where('transaction_id', '=', $filters['transaction_id']);
            }


            //Payment Status
            if (!empty($filters['payment_status'])) {
                $query->where('payment_status', '=', $filters['payment_status']);
            }

            //Payment Status
            if (!empty($filters['user_id'])) {
                $query->where('user_id', '=', $filters['user_id']);
            }

            //Sale Status
            if (!empty($filters['sale_status'])) {
                $query->where('sale_status', '=', $filters['sale_status']);
            }

            if ( !empty( $filters['sale_sort_by_id'] ) ) {
                $query->orderBy( 'sales.id', $filters['sale_sort_by_id']);
            }

            if ( !empty( $filters['sale_sort_by_sale_status'] ) ) {
                $query->orderBy( 'sales.sale_status', $filters['sale_sort_by_sale_status']);
            }

            if ( !empty( $filters['sale_sort_by_payment_status'] ) ) {
                $query->orderBy( 'sales.payment_status', $filters['sale_sort_by_payment_status']);
            }

        }

        return $query;
    }

    /**
     * @param array $items
     * @param $id
     * @return bool
     */
    public function updateSaleItems(array $items, $id): bool
    {
        $confirm = false;
        try {
            $saleModel = $this->find($id);
            //remove all old children
            $saleModel->items()->delete();
            //insert latest children
            $confirm = (bool)$saleModel->items()->createMany($items);
        } catch (ModelNotFoundException $e) {
            \Log::error('Sale not found');
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
        } finally {
            return $confirm;
        }
    }
}

