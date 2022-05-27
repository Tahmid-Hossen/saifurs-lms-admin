<?php

namespace App\Notifications\Api;

use App\Notifications\Messages\PushMessage;
use App\Notifications\Messages\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


/**
 * @class UserEmailVerifyNotification
 * @package App\Notifications
 *
 */
class UserEmailVerifyNotification extends Notification
{
/*    use Queueable;*/

    private $otp;

    /**
     * Create a new notification UserEmailVerifyNotification constructor.
     *
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param $notifiableUser
     * @return array
     */
    public function via($notifiableUser): array
    {
        return [MailChannel::class];
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
            'title' => "",
            'body' => "",
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
        if (!empty($FCMToken)) :
            $pushMessage->to($FCMToken)
                ->to($FCMToken)
                ->title("Notification")
                ->line("Notification")
                ->image("Notification")
                ->type("Notification")
                ->modelId("Notification")
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
                ->line("");
        endif;

        return $smsMessage;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param $notifiableUser
     * @return MailMessage
     */
    public function toMail($notifiableUser): MailMessage
    {
        return (new MailMessage)
            ->subject('Email Verification')
            ->from(env('MAIL_FROM_ADDRESS'), env("MAIL_FROM_NAME"))
            ->line('Your Email Verification Code: ' . $this->otp);
    }
}
