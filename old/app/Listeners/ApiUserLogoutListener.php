<?php

namespace App\Listeners;

use App\Events\ApiUserLogoutEvent;
use App\Notifications\Api\UserLogoutNotification;

class ApiUserLogoutListener
{
    /**
     * Handle the event.
     *
     * @param ApiUserLogoutEvent $apiUserLogoutEvent
     * @return void
     */
    public function handle(ApiUserLogoutEvent $apiUserLogoutEvent)
    {
        $apiUserLogoutEvent->user->notify(new UserLogoutNotification);
    }
}
