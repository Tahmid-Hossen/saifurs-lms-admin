<?php

namespace App\Listeners;

use App\Events\OrderConfirmEvent;
use App\Notifications\Backend\Sale\SaleCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class OrderConfirmListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param OrderConfirmEvent $orderConfirmEvent
     * @return void
     */
    public function handle(OrderConfirmEvent  $orderConfirmEvent)
    {
        $user = $orderConfirmEvent->sale->user;

        $user->notify(new SaleCreatedNotification($orderConfirmEvent->sale));
    }
}
