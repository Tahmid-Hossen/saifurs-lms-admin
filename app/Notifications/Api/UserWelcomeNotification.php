<?php

namespace App\Notifications\Api;

use App\Mail\WelcomeMail;
use App\Notifications\Channels\PushChannel;
use App\Notifications\Channels\SmsChannel;
use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Channels\MailChannel;


use App\Notifications\Messages\PushMessage;
use App\Notifications\Messages\SmsMessage;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

/**
 * @class UserWelcomeNotification
 * @package App\Notifications\Api
 *
 */

class UserWelcomeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification UserWelcomeNotification constructor.
     *
     */
    public function __construct()
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param $notifiableUser
     * @return array
     */
    public function via($notifiableUser)
    {
        return [DatabaseChannel::class, PushChannel::class, MailChannel::class];
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
            'title' => "Registration Confirmation",
            'body' => "Thank you for registering with s@ifur's.",
            'image' => asset('/assets/svg/bell.svg'),
            'type' => "general",
            'id' => '',
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
        if(!empty($FCMToken)) :
        $pushMessage->to($FCMToken)
                ->to($FCMToken)
                ->title("Registration Confirmation")
                ->line("Thank you for registering with s@ifur's.")
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

        if($notifiableUser->mobile_number) :
                $smsMessage->to($notifiableUser->mobile_number)
                ->line("");
        endif;

        return $smsMessage;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param $notifiableUser
     * @return WelcomeMail
     */
    public function toMail($notifiableUser): WelcomeMail
    {
        return (new WelcomeMail($notifiableUser));
    }
}
