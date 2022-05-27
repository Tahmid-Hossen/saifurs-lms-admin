<?php

namespace App\Observers\Course;

use App\Models\Backend\Course\Course;
use App\Notifications\Backend\CourseManage\Course\CourseCreatedNotification;
use App\Services\Backend\User\UserService;

class CourseObserver
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * CourseObserver constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {

        $this->userService = $userService;
    }
    /**
     * Handle the Course "created" event.
     *
     * @param Course $course
     * @return void
     */
    public function created(Course $course)
    {
        $users = $this->userService->allUsers(['status' => 'ACTIVE'])->get();

        foreach ($users as $user) {
            $user->notify(new CourseCreatedNotification($course));
        }
    }

    /**
     * Handle the Course "updated" event.
     *
     * @param Course $course
     * @return void
     */
    public function updated(Course $course)
    {
        //
    }
}
