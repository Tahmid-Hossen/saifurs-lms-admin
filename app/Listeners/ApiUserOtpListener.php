<?php

namespace App\Listeners;

use App\Events\ApiUserOtpEvent;
use App\Notifications\Api\UserSignUpOtpNotification;
use App\Notifications\Channels\SmsChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Queue\InteractsWithQueue;

class ApiUserOtpListener
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
     * @param ApiUserOtpEvent $apiUserSignUpOtpEvent
     * @return void
     */
    public function handle(ApiUserOtpEvent $apiUserSignUpOtpEvent)
    {
        \Log::info("OTP Listener Triggered");
        Notification::route(SmsChannel::class, $apiUserSignUpOtpEvent->sms['mobile_number'])
                    ->notify(new UserSignUpOtpNotification($apiUserSignUpOtpEvent->sms));
    }
}
