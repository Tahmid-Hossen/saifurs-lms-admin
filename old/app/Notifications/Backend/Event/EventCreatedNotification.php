<?php

namespace App\Notifications\Backend\Event;

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
use App\Models\Backend\Event\Event;

/**
 * @class EventCreatedNotification
 * @package App\Notifications\Backend\Event
 *
 */

class EventCreatedNotification extends Notification
{
    use Queueable;

    /**
     * @var Event
     */
    private $event;

    /**
     * Create a new notification EventCreatedNotification constructor.
     *
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param $notifiableUser
     * @return array
     */
    public function via($notifiableUser)
    {
        return [DatabaseChannel::class, PushChannel::class, /*SmsChannel::class, MailChannel::class*/];
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
            'title' => "Event",
            'body' => "An event has been published",
            'image' => asset('/assets/svg/event.svg'),
            'type' => "general",
            'id' => $this->event->id ?? 0,
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
                ->title("Event")
                ->line("An event has been published")
                ->image("/assets/svg/event.svg")
                ->type("general")
                ->modelId($this->event->id)
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
     * @return MailMessage
     */
    public function toMail($notifiableUser): MailMessage
    {
        return (new MailMessage)
            ->subject('test title')
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }
}
