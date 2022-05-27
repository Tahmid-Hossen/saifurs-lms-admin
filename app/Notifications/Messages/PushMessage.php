<?php

namespace App\Notifications\Messages;

use App\Services\PushNotificationService;
use Exception;

class PushMessage
{
    protected $to;
    protected $payload = [
        'title' => 'Notification',
        'body' => [],
        'type' => 'general',
        'image' => '/assets/svg/announcement.svg',
        'extra' => [],
        'id' => 0,
        'time' => ''
    ];
    protected $from;

    /**
     * @var pushNotificationService
     */
    private $pushNotificationService;

    public function __construct()
    {
        $this->pushNotificationService = new PushNotificationService;

    }

    public function line($line = ''): self
    {
        $this->payload['body'][] = $line;

        return $this;
    }

    public function cleanLine(): self

    {
        $this->payload['body'] = [];

        return $this;
    }

    public function extra($extra): self
    {
        $this->payload['extra'] = $extra;

        return $this;
    }

    public function to($to): self
    {
        $this->to = $to;

        return $this;
    }

    public function title($title): self
    {
        $this->payload['title'] = $title;

        return $this;
    }

    public function type($type): self
    {
        $this->payload['type'] = $type;

        return $this;
    }

    public function from($from): self
    {
        $this->from = $from;

        return $this;
    }

    public function image(string $imagePath): self
    {
        $this->payload['image'] = $imagePath;

        return $this;
    }

    public function modelId($id): self
    {
        $this->payload['id'] = $id;

        return $this;
    }

    public function time($id): self
    {
        $this->payload['time'] = $id;

        return $this;
    }


    /**
     * @throws Exception
     */
    public function send()
    {
        if (!$this->to) {
            \Log::error('Push Recipient is Missing');
        } else {
            if (!count($this->payload)) {
                \Log::error('Push Content is Empty');
            } else {
                //Send Push Content
                $this->payload['body'] = implode("\n", $this->payload['body']);

                $responseStatus = $this->pushNotificationService->sendAutoNotification($this->to, $this->payload);

                if ($responseStatus == true) {
                    \Log::info('Push Send');
                } else {
                    \Log::error('Push Failed');
                }
            }
        }
    }
}
