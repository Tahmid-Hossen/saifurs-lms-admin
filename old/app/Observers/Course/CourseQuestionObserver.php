<?php

namespace App\Observers\Course;

use App\Models\Backend\Course\CourseQuestion;

class CourseQuestionObserver
{
    /**
     * Handle the CourseQuestion "created" event.
     *
     * @param CourseQuestion $courseQuestion
     * @return void
     */
    public function created(CourseQuestion $courseQuestion)
    {
        //
    }

    /**
     * Handle the CourseQuestion "updated" event.
     *
     * @param CourseQuestion $courseQuestion
     * @return void
     */
    public function updated(CourseQuestion $courseQuestion)
    {
        //
    }
}
