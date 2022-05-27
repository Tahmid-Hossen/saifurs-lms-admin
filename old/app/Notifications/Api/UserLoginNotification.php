<?php

namespace App\Notifications\Api;

use App\Notifications\Channels\PushChannel;
use App\Notifications\Messages\PushMessage;
use App\Notifications\Messages\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Notification;


/**
 * @class UserLoginNotification
 * @package App\Notifications\Api
 *
 */
class UserLoginNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param $notifiableUser
     * @return array
     */
    public function via($notifiableUser): array
    {
        return [/*DatabaseChannel::class, */PushChannel::class, /*SmsChannel::class*/];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param $notifiableUser
     * @return array
     */
    public function toDatabase($notifiableUser): array
    {
        return [
            'title' => "Login",
            'body' => "Login Successful",
            'image' => asset('/assets/svg/bell.svg'),
            'type' => "general",
            'id' => 0,
            'time' => date("Y-m-d H:i:s"),
            'extra' => []
        ];
    }

    /**
     * Get the push representation of the notification.
     *
     * @param $notifiableUser
     * @return PushMessage
     */
    public function toPush($notifiableUser): PushMessage
    {
        \Log::error("push notification trigger");
        $FCMToken = $notifiableUser->fcm_token ?? null;

        $pushMessage = new PushMessage;
        if (!empty($FCMToken)) :
            $pushMessage->to($FCMToken)
                ->to($FCMToken)
                ->title("Login")
                ->line("Login Successfully")
                ->image(asset('/assets/svg/bell.svg'))
                ->type("general")
                ->modelId("0")
                ->extra([])
                ->time(date("Y-m-d H:i:s"));
        endif;

        return $pushMessage;
    }


    /**
     * Get the sms representation of the notification.
     *
     * @param $notifiableUser
     * @return SmsMessage
     */
    public function toSms($notifiableUser): SmsMessage
    {
        $smsMessage = new SmsMessage;

        if ($notifiableUser->mobile_number) :
            $smsMessage->to($notifiableUser->mobile_number)
                ->line("some test sms");
        endif;

        return $smsMessage;
    }
}
