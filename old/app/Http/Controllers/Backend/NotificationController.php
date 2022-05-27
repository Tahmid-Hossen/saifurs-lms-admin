<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Services\UtilityService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * @var UtilityService
     */
    private $utilityService;

    /**
     * @param UtilityService $utilityService
     */
    public function __construct(UtilityService $utilityService)
    {
        $this->utilityService = $utilityService;
    }

    public function notificationMarkedAsRead(string $notification_id, Request $request)
    {
        $user = $request->user();

        if ($notification = $user->notifications()->where('id', $notification_id)->first()) {
            $notification->markAsRead();

            $route = $this->utilityService->notificationRouteByType($notification->data['type'], $notification->data['id']);

            return redirect()->to($route);
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function notificationMarkAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
}
