<?php

namespace App\Notifications\Api;

use App\Notifications\Channels\PushChannel;
use App\Notifications\Messages\PushMessage;
use App\Notifications\Messages\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Notification;


/**
 * @class UserLogoutNotification
 * @package App\Notifications\Api
 *
 */
class UserLogoutNotification extends Notification
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
        return [DatabaseChannel::class, PushChannel::class, /*SmsChannel::class*/];
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
            'title' => "Logout",
            'body' => "Logout Successfully",
            'image' => asset('/assets/svg/bell.svg'),
            'type' => "general",
            'id' => '0',
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
        $FCMToken = $notifiableUser->fcm_token ?? null;

        $pushMessage = new PushMessage;
        if (!empty($FCMToken)) :
            $pushMessage->to($FCMToken)
                ->to($FCMToken)
                ->title("Logout")
                ->line("Logout Successfully.")
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
                ->line("testinfg");
        endif;

        return $smsMessage;
    }

}
