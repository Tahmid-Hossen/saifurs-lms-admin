<?php

namespace App\Observers\Course;

use App\Models\Backend\Course\QuestionAnswer;

class QuestionAnswerObserver
{
    /**
     * Handle the QuestionAnswer "created" event.
     *
     * @param QuestionAnswer $questionAnswer
     * @return void
     */
    public function created(QuestionAnswer $questionAnswer)
    {
        //
    }

    /**
     * Handle the QuestionAnswer "updated" event.
     *
     * @param QuestionAnswer $questionAnswer
     * @return void
     */
    public function updated(QuestionAnswer $questionAnswer)
    {
        //
    }
}
