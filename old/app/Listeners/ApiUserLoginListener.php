<?php

namespace App\Listeners;

use App\Events\ApiUserLoginEvent;
use App\Notifications\Api\UserLoginNotification;

class ApiUserLoginListener
{
    /**
     * Handle the event.
     *
     * @param ApiUserLoginEvent $apiUserLoginEvent
     * @return void
     */
    public function handle(ApiUserLoginEvent $apiUserLoginEvent)
    {
        \Log::error("event listener handle");
        $apiUserLoginEvent->user->notify(new UserLoginNotification);
    }
}
