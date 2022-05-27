<?php

namespace App\Observers\Quiz;

use App\Models\Backend\Quiz\Quiz;

class QuizObserver
{
    /**
     * Handle the Quiz "created" event.
     *
     * @param Quiz $quiz
     * @return void
     */
    public function created(Quiz $quiz)
    {
        //
    }

    /**
     * Handle the Quiz "updated" event.
     *
     * @param Quiz $quiz
     * @return void
     */
    public function updated(Quiz $quiz)
    {
        //
    }

    /**
     * Handle the Quiz "deleted" event.
     *
     * @param Quiz $quiz
     * @return void
     */
    public function deleted(Quiz $quiz)
    {
        //
    }
}
