<?php

namespace App\Notifications\Backend\CourseManage\CourseAssignment;

use App\Models\Backend\Course\CourseAssignment;
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
 * @class AssignmentUpdatedNotification
 * @package App\Notifications\Backend\CourseManage\CourseAssignment
 *
 */

class AssignmentUpdatedNotification extends Notification
{
    use Queueable;

    /**
     * @var CourseAssignment
     */
    private $courseAssignment;

    /**
     * Create a new notification AssignmentUpdatedNotification constructor.
     * @param CourseAssignment $courseAssignment
     */
    public function __construct(CourseAssignment $courseAssignment)
    {
        $this->courseAssignment = $courseAssignment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param $notifiableUser
     * @return array
     */
    public function via($notifiableUser)
    {
        return [DatabaseChannel::class, PushChannel::class/*, SmsChannel::class, MailChannel::class*/];
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
            'title' => "Assignment Review",
            'body' => "Your assignment submission has been reviewed.",
            'image' => asset('/assets/svg/assignment.svg'),
            'type' => "assignment",
            'id' => $this->courseAssignment->id ?? 0,
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
                ->title("Assignment Review")
                ->line("Your assignment submission has been reviewed.")
                ->image(asset('/assets/svg/assignment.svg'))
                ->type("assignment")
                ->modelId($this->courseAssignment->id ?? 0)
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
