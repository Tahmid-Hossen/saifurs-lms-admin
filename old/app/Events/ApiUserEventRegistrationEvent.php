<?php

namespace App\Events;

use App\Models\Backend\Event\Event;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApiUserEventRegistrationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Event
     */
    public $event;
    /**
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Event $event, User $user)
    {
        //
        $this->event = $event;
        $this->user = $user;
    }
}
