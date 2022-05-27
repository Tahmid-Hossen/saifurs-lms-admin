<?php

namespace App\Notifications\Messages;

use App\Services\ShortMessageService;
use Exception;

class SmsMessage
{
    protected $to;
    protected $from;
    protected $lines = [];

    /**
     * @var ShortMessageService
     */
    private $shortMessageService;

    public function __construct()
    {
        $this->shortMessageService = new ShortMessageService;

    }

    public function line($line = ''): self
    {
        $this->lines[] = $line;

        return $this;
    }

    public function to($to): self
    {
        $this->to = $to;

        return $this;
    }

    public function from($from): self
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @throws Exception
     */
    public function send()
    {
        if (!$this->to) {
            \Log::error('SMS Recipient is Missing');
        } else {
            if (!count($this->lines)) {
                \Log::error('SMS Content is Empty');
            } else {
                //Send SMS
                $responseStatus = $this->shortMessageService->sendSms(implode("\n", $this->lines), $this->to);
                if ($responseStatus['status'] == true) {
                    \Log::info('SMS Send');
                } else {
                    \Log::error('SMS Failed');
                }
            }
        }
    }
}
