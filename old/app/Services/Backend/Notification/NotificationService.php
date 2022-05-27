<?php

namespace App\Services\Backend\Notification;

use App\Models\User;
use App\Services\Backend\User\UserService;

class NotificationService {

    /**
     * @var UserService
     */
    private $userService;
    
    /**
     * NotificationService constructor.
     */
    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function showNotificationById($user_id) {
        $user =  $this->userService->findUser($user_id);
        $data = [];
        foreach ($user->unreadNotifications as $notification) {
            $data[] = [
                'notification_id' =>  $notification->id,
                'notification_type' => $notification->data['type'],
                'not_seen'=>  \Carbon\Carbon::parse($notification->data['time'])->diffForHumans(),
                'notification_data' => $notification->data
            ];
        }
        return $data;
    }

    public function getNotificationType(string $notification) 
    {
        $notificationName = str_replace('App\Notifications\\', '', $notification);
        return \Str::snake($notificationName);
    }

}
