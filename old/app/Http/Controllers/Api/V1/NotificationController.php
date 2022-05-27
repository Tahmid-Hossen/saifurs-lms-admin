<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\Backend\Notification\NotificationService;
use App\Services\Backend\User\UserService;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController
{
    /**
     * @var NotificationService
     */
    private $notificationService;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(
        NotificationService $notificationService,
        UserService $userService
    )
    {
        $this->notificationService = $notificationService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $data['status'] = true;
            $user_id = Auth::id();
            //  testing purpose
            $data['user_id'] = $user_id;
            $data['data'] = $this->notificationService->showNotificationById($user_id);
            if (count($data['data']) == 0) {
                $data['status'] = false;
                $data['message'] = 'No Unread Notification Found!';
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['status'] = false;
            $data['message'] = 'No Unread Notification Found!';
        }
        $data['request'] = $request->all();
        return response()->json($data, 200);
    }

    public function markedAsRead($id): JsonResponse
    {
        try {
            // Status
            $data['status'] = true;

            // User info
            $user = Auth::user();
            $user_id = Auth::id();
            $notification = $user->notifications->find($id);
            $notification->markAsRead();

            // Get Notification Data
            $information = $notification->data;
            $type = $notification->type;
            $notification_type = $this->notificationService->getNotificationType($type);
            if ($notification_type == 'events_notification') {
                $data['event'] = $information;
                $data['message'] = 'Notification For this Event read successfully';
            }
            if ($notification_type == 'course_notification') {
                $data['course'] = $information;
                $data['message'] = 'Notification For this Course read successfully';
            }
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            $data['status'] = false;
            $data['message'] = 'Use Proper Notification ID as Parameter that is not yet read!!';
        }
        return response()->json($data, 200);
    }

    public function markAllAsRead(): JsonResponse
    {
        $responseJson = ['status' => false, 'message' => 'Notification removal failed'];

        if (\Auth::user()->unreadNotifications->markAsRead()) {
            $responseJson = ['status' => true, 'message' => 'All Notifications are Marked as Read.'];
        } else {
            $responseJson = ['status' => false, 'message' => 'Notification removal failed'];
        }

        return \response()->json($responseJson);
    }
}
