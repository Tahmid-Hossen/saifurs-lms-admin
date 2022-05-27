<?php

namespace App\Notifications\Backend\Sale;

use App\Mail\SaleInvoiceMail;
use App\Models\Backend\Sale\Sale;
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
 * @class SaleCreatedNotification
 * @package App\Notifications\Backend\Sale
 *
 */

class SaleCreatedNotification extends Notification
{
    use Queueable;

    /**
     * @var Sale
     */
    private $sale;

    /**
     * Create a new notification SaleCreatedNotification constructor.
     *
     */
    public function __construct(Sale $sale)
    {

        $this->sale = $sale;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param $notifiableUser
     * @return array
     */
    public function via($notifiableUser): array
    {
        return [DatabaseChannel::class, PushChannel::class, SmsChannel::class, MailChannel::class];
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
            'title' => "Order Confirmed",
            'body' => "An order has been confirmed.",
            'image' => asset('/assets/svg/order.svg'),
            'type' => "sale",
            'id' => $this->sale->id,
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
                ->title("Order Confirmed")
                ->line("An order has been confirmed.")
                ->image(asset('/assets/svg/order.svg'))
                ->type("order")
                ->modelId($this->sale->id)
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
                ->line("Your order has been placed.")
                ->line("Order ID:" . $this->sale->transaction_id)
                ->line("Order Amount: ". number_format($this->sale->total_amount, 2, '.', ','));

        endif;

        return $smsMessage;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param $notifiableUser
     * @return SaleInvoiceMail
     */
    public function toMail($notifiableUser): SaleInvoiceMail
    {
        return (new SaleInvoiceMail($this->sale, 'invoice'))
            ->to($notifiableUser->email);
    }
}
