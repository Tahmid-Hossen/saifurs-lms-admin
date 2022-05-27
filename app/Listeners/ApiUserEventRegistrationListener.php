<?php

namespace App\Listeners;

use App\Events\ApiUserEventRegistrationEvent;
use App\Notifications\Backend\Event\EventRegisterConfirmedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ApiUserEventRegistrationListener
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
     * @param ApiUserEventRegistrationEvent $apiUserEventRegistrationEvent
     * @return void
     */
    public function handle(ApiUserEventRegistrationEvent $apiUserEventRegistrationEvent)
    {
        $apiUserEventRegistrationEvent->user->notify(new EventRegisterConfirmedNotification($apiUserEventRegistrationEvent->event));
    }
}
