<?php

namespace App\Observers\Sale;

use App\Models\Backend\Sale\Sale;
use App\Notifications\Backend\Sale\SaleCreatedNotification;

class SaleObserver
{
    /**
     * Handle the Sale "created" event.
     *
     * @param Sale $sale
     * @return void
     */
    public function created(Sale $sale)
    {
/*        $user = $sale->user;

        $user->notify(new SaleCreatedNotification($sale));*/
    }

    /**
     * Handle the Sale "updated" event.
     *
     * @param Sale $sale
     * @return void
     */
    public function updated(Sale $sale)
    {
        //
    }

    /**
     * Handle the Sale "deleted" event.
     *
     * @param Sale $sale
     * @return void
     */
    public function deleted(Sale $sale)
    {
        //
    }

    /**
     * Handle the Sale "restored" event.
     *
     * @param Sale $sale
     * @return void
     */
    public function restored(Sale $sale)
    {
        //
    }

    /**
     * Handle the Sale "force deleted" event.
     *
     * @param Sale $sale
     * @return void
     */
    public function forceDeleted(Sale $sale)
    {
        //
    }
}
