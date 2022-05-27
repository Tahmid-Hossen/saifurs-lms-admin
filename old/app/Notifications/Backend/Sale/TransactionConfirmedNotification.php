<?php

namespace App\Notifications\Backend\Sale;

use App\Mail\SaleInvoiceMail;
use App\Models\Backend\Sale\Transaction;
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
 * @class TransactionConfirmedNotification
 * @package App\Notifications\Backend\Sale
 *
 */

class TransactionConfirmedNotification extends Notification
{
    use Queueable;

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * Create a new notification TransactionConfirmedNotification constructor.
     *
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
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
            'title' => "Transaction Confirmed",
            'body' => "Your transaction has been completed!",
            'image' => asset('/assets/svg/order.svg'),
            'type' => "transaction",
            'id' => $this->transaction->sale_id ?? 0,
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
                ->title("Transaction Confirmed")
                ->line("Your transaction has been completed!")
                ->image(asset('/assets/svg/order.svg'))
                ->type("transaction")
                ->modelId($this->transaction->sale_id)
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
     * @return SaleInvoiceMail
     */
    public function toMail($notifiableUser): SaleInvoiceMail
    {
        return (new SaleInvoiceMail($this->transaction->sale, ''))
            ->subject($this->subjectTitle ?? 'Invoice ' . ($this->sale->transaction_id ?? null))
            ->view('invoice.mail')
            ->to($notifiableUser->email);
    }
}
