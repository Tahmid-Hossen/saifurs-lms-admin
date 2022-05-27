<?php

namespace App\Listeners;

use App\Events\ApiUserRegistrationEvent;
use App\Notifications\Api\UserWelcomeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ApiUserRegistrationEventListener
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
     * @param ApiUserRegistrationEvent $event
     * @return void
     */
    public function handle(ApiUserRegistrationEvent $event)
    {
        $user = $event->user;
        $user->notify(new UserWelcomeNotification);
    }
}
