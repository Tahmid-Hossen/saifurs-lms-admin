<?php

namespace App\Notifications\Backend\CourseManage\Course;

use App\Models\Backend\Course\Course;
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
 * @class CourseCreatedNotification
 * @package App\Notifications\Backend\CourseManage\Course
 *
 */

class CourseCreatedNotification extends Notification
{
    use Queueable;

    /**
     * @var Course
     */
    private $course;

    /**
     * Create a new notification CourseCreatedNotification constructor.
     *
     */
    public function __construct(Course $course)
    {

        $this->course = $course;
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
            'title' => "Course Created",
            'body' => "A new course has been published",
            'image' => asset('/assets/svg/course.svg'),
            'type' => "course",
            'id' => $this->course->id,
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
                ->title("Course Created")
                ->line("A new course has been published")
                ->image(asset('/assets/svg/course.svg'))
                ->type("general")
                ->modelId($this->course->id)
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
