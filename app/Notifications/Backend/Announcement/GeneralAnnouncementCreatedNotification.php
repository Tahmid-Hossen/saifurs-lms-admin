<?php

namespace App\Notifications\Backend\Announcement;

use App\Models\Backend\Announcement\Announcement;
use App\Notifications\Channels\PushChannel;
use App\Notifications\Messages\PushMessage;
use App\Notifications\Messages\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


/**
 * @class GeneralAnnouncementCreatedNotification
 * @package App\Notifications\Backend\Announcement
 *
 */
class GeneralAnnouncementCreatedNotification extends Notification
{
    use Queueable;

    /**
     * @var Announcement
     */
    private $announcement;

    /**
     * Create a new notification GeneralAnnouncementCreatedNotification constructor.
     * @param Announcement $announcement
     */
    public function __construct(Announcement $announcement)
    {

        $this->announcement = $announcement;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param $notifiableUser
     * @return array
     */
    public function via($notifiableUser): array
    {
        return [DatabaseChannel::class, PushChannel::class/*, SmsChannel::class*/];
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
            'title' => "Announcement",
            'body' => "There is a new announcement for you.",
            'image' => asset('/assets/svg/announcement.svg'),
            'type' => "general-announcement",
            'id' => $this->announcement->id ?? 0,
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
                ->title("Announcement")
                ->line("There is a new announcement for you.")
                ->image('/assets/svg/announcement.svg')
                ->type("general-announcement")
                ->modelId($this->announcement->id ?? 0)
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
                ->line("There is a new announcement for you.");
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
