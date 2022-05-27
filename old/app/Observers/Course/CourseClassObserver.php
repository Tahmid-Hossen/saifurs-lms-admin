<?php

namespace App\Observers\Course;

use App\Models\Backend\Course\CourseClass;

class CourseClassObserver
{
    /**
     * Handle the CourseClass "created" event.
     *
     * @param CourseClass $courseClass
     * @return void
     */
    public function created(CourseClass $courseClass)
    {
        //
    }

    /**
     * Handle the CourseClass "updated" event.
     *
     * @param CourseClass $courseClass
     * @return void
     */
    public function updated(CourseClass $courseClass)
    {
        //
    }

}
