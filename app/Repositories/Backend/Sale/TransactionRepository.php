<?php

namespace App\Repositories\Backend\Sale;

use App\Models\Backend\Sale\Transaction;
use App\Repositories\Repository;

/**
 * Class TransactionRepository
 * @package App\Repositories\Backend\Sale
 */
class TransactionRepository extends Repository
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return Transaction::class;
    }

}

