<?php

namespace App\Observers\Course;

use App\Models\Backend\Course\CourseAssignment;
use App\Notifications\Backend\Books\BookCreatedNotification;
use App\Notifications\Backend\CourseManage\CourseAssignment\AssignmentUpdatedNotification;
use App\Services\Backend\User\UserService;

class CourseAssignmentObserver
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
     * Handle the CourseAssignment "created" event.
     *
     * @param CourseAssignment $courseAssignment
     * @return void
     */
    public function created(CourseAssignment $courseAssignment)
    {
        //
    }

    /**
     * Handle the CourseAssignment "updated" event.
     *
     * @param CourseAssignment $courseAssignment
     * @return void
     */
    public function updated(CourseAssignment $courseAssignment)
    {
        $student_id = $courseAssignment->student_id;

        if ($notifiableUser = $this->userService->showAllUser(['id' => $student_id])->get()->first()) {
               $notifiableUser->notify(new AssignmentUpdatedNotification($courseAssignment));
        }

    }
}
