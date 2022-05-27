<?php

namespace App\Observers\Event;

use App\Models\Backend\Event\Event;
use App\Notifications\Backend\Event\EventCreatedNotification;
use App\Services\Backend\User\UserService;

class EventObserver
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Handle the Event "created" event.
     *
     * @param Event $event
     * @return void
     */
    public function created(Event $event)
    {

        $users = $this->userService->allUsers(['status' => 'ACTIVE'])->get();

        foreach ($users as $user) {
            $user->notify(new EventCreatedNotification($event));
        }

    }

    /**
     * Handle the Event "updated" event.
     *
     * @param Event $event
     * @return void
     */
    public function updated(Event $event)
    {
        // $user_id = $event->id;
        // $company_id = $event->company_id;
        // $end_date = $event->event_end;

        // $notifiableUsers = $this->userService->allUsers(['company_id' => $company_id, 'id' => $user_id,]);

    }
}
