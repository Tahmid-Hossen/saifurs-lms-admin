<?php

namespace App\Notifications\Backend\Books;

use App\Notifications\Channels\PushChannel;
use App\Notifications\Channels\SmsChannel;
use App\Models\Backend\Books\Book;
use App\Notifications\Messages\PushMessage;
use App\Notifications\Messages\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


/**
 * @class BookCreatedNotification
 * @package App\Notifications\Backend\Books
 *
 */

class BookCreatedNotification extends Notification
{
    use Queueable;

    /**
     * @var Book
     */
    private $book;

    /**
     * Create a new notification BookCreatedNotification constructor.
     * @param Book $book
     */
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param $notifiableUser
     * @return array
     */
    public function via($notifiableUser): array
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
        \Log::info("Book DB Notification");
        return [
            'title' => "Book Published",
            'body' => "There is a new book published",
            'image' => asset('/assets/svg/book.svg'),
            'type' => "book",
            'id' => $this->book->book_id,
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
        \Log::info("Book Push Notification");
        $FCMToken = $notifiableUser->fcm_token ?? null;

        $pushMessage = new PushMessage;
        if(!empty($FCMToken)) :
        $pushMessage->to($FCMToken)
                ->to($FCMToken)
                ->title("Book Published")
                ->line("There is a new book published")
                ->image(asset('/assets/svg/book.svg'))
                ->type("book")
                ->modelId($this->book->book_id)
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
