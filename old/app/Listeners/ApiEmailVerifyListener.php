<?php

namespace App\Listeners;

use App\Events\ApiEmailVerifyEvent;
use App\Mail\EmailVerifyMail;
use Illuminate\Support\Facades\Mail;

class ApiEmailVerifyListener
{
    /**
     * @var ApiEmailVerifyEvent
     */
    public $event;

    /**
     * Handle the event.
     *
     * @param ApiEmailVerifyEvent $event
     * @return void
     */
    public function handle(ApiEmailVerifyEvent $event)
    {
        try {
            $data = array('name' => $event->user->name, 'otp' => $event->optData);
            Mail::to($event->user->email)->send(new EmailVerifyMail($data));
        } catch (\Exception $exception) {
            \Log::error("Email Verify Error : " . $exception->getMessage());
            \Log::info(json_encode(Mail::failures()));
        }
    }
}
