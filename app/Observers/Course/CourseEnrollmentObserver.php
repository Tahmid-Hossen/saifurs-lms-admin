<?php

namespace App\Observers\Course;

use App\Models\Enrollment;
use App\Notifications\Backend\CourseManage\Course\CourseCreatedNotification;
use App\Services\Backend\User\UserService;
use App\Services\Backend\Enrollment\EnrollmentService;

class CourseEnrollmentObserver
{
    /**
     * @var UserService
     */
    private $userService;

    private $enrollmentService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService, EnrollmentService $enrollmentService)
    {
        $this->userService = $userService;
        $this->enrollmentService = $enrollmentService;
    }

    /**
     * Handle the Enrollment "created" event.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return void
     */
    public function created(Enrollment $enrollment)
    {
        $user = $enrollment->user;
  
        $user->notify(new CourseEnrolledNotification($enrollment));
    }

    /**
     * Handle the Enrollment "updated" event.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return void
     */
    public function updated(Enrollment $enrollment)
    {
        //
    }

    /**
     * Handle the Enrollment "deleted" event.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return void
     */
    public function deleted(Enrollment $enrollment)
    {
        //
    }

    /**
     * Handle the Enrollment "restored" event.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return void
     */
    public function restored(Enrollment $enrollment)
    {
        //
    }

    /**
     * Handle the Enrollment "force deleted" event.
     *
     * @param  \App\Models\Enrollment  $enrollment
     * @return void
     */
    public function forceDeleted(Enrollment $enrollment)
    {
        //
    }
}
