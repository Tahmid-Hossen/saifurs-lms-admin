<?php

namespace App\Notifications\Backend\CourseManage\Enrollment;

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
use App\Models\Backend\Enrollment\Enrollment;

/**
 * @class CourseEnrolledNotification
 * @package App\Notifications\Backend\CourseManage\Enrollment
 *
 */

class CourseEnrolledNotification extends Notification
{
    use Queueable;

     /**
     * @var Enrollment
     */
    private $enrollment;

    public function __construct(Enrollment $enrollment)
    {
        $this->enrollment = $enrollment;
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
            'title' => "Enrollment",
            'body' => "A new enrollment has been completed successfully.",
            'image' => asset('/assets/svg/bell.svg'),
            'type' => "general",
            'id' => $this->enrollment->id ?? 0,
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
                ->title("Enrollment")
                ->line("A new enrollment has been completed successfully.")
                ->image("/assets/svg/bell.svg")
                ->type("Notification")
                ->modelId($this->enrollment->id)
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

    public function toArray($notifiableUser) 
    {
        return [
            'title' => "Enrollment",
            'body' => "A new enrollment has been completed successfully.",
            'image' => asset('/assets/svg/bell.svg'),
            'type' => "general",
            'id' => $this->enrollment->id ?? 0,
            'time' => date("Y-m-d H:i:s"),
            'extra' => []
        ];
    }
}
