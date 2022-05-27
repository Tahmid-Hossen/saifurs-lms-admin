<?php

namespace App\Observers\Course;

use App\Models\Backend\Course\CourseBatch;

class CourseBatchObserver
{
    /**
     * Handle the CourseBatch "created" event.
     *
     * @param CourseBatch $courseBatch
     * @return void
     */
    public function created(CourseBatch $courseBatch)
    {
        //
    }

    /**
     * Handle the CourseBatch "updated" event.
     *
     * @param CourseBatch $courseBatch
     * @return void
     */
    public function updated(CourseBatch $courseBatch)
    {
        //
    }
}
