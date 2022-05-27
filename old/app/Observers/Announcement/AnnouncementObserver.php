<?php

namespace App\Observers\Announcement;

use App\Models\Backend\Announcement\Announcement;
use App\Models\User;
use App\Notifications\Backend\Announcement\AssignmentAnnouncementCreatedNotification;
use App\Notifications\Backend\Announcement\GeneralAnnouncementCreatedNotification;
use App\Services\Backend\User\UserService;

class AnnouncementObserver
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
     * Handle the Announcement "created" event.
     *
     * @param Announcement $announcement
     * @return void
     */
    public function created(Announcement $announcement)
    {
        $company_id = $announcement->company_id;
        $notifiableUsers = $this->userService->allUsers(['company_id' => $company_id])->get();

        foreach ($notifiableUsers as $notifiableUser) :

            if ($announcement->announcement_type == 'assignment')
                $this->sendCourseAssignmentAnnouncement($notifiableUser, $announcement);

            else
                $this->sendCourseGeneralAnnouncement($notifiableUser, $announcement);
        endforeach;
    }

    /**
     * Handle the Announcement "updated" event.
     *
     * @param Announcement $announcement
     * @return void
     */
    public function updated(Announcement $announcement)
    {

    }


    private function sendCourseGeneralAnnouncement(User $recipientUser, Announcement $announcement)
    {
        $recipientUser->notify(new GeneralAnnouncementCreatedNotification($announcement));
    }

    private function sendCourseAssignmentAnnouncement(User $recipientUser, Announcement $announcement)
    {
        $recipientUser->notify(new AssignmentAnnouncementCreatedNotification($announcement));
    }


}
