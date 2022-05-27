<?php

namespace App\Notifications\Api;

use App\Notifications\Channels\SmsChannel;
use App\Notifications\Messages\PushMessage;
use App\Notifications\Messages\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


/**
 * @class UserSignUpOtpNotification
 * @package App\Notifications\Api
 *
 */
class UserSignUpOtpNotification extends Notification
{
    use Queueable;

    /**
     * @var array
     */
    protected $sms;

    /**
     * Create a new notification UserSignUpOtpNotification constructor.
     *
     */
    public function __construct(array $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param $notifiableUser
     * @return array
     */
    public function via($notifiableUser)
    {
        return [SmsChannel::class, /*MailChannel::class*/];
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
        \Log::error("Push Notification Called");
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
        \Log::info("SMS Notification Triggered");
        $smsMessage = new SmsMessage;

        if ($this->sms['mobile_number']) :
            $smsMessage->to($this->sms['mobile_number'])
                ->line($this->sms['line']);
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
        \Log::error("Mail Notification Called");
        return (new MailMessage)
            ->subject('test title')
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }
}
