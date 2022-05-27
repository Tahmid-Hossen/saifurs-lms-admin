<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApiEmailVerifyEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $optData;
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, $optData)
    {
        $this->optData = $optData;
        $this->user = $user;
    }

}
