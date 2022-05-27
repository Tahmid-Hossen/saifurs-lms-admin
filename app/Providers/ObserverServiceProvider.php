<?php

namespace App\Providers;

use App\Models\Backend\Announcement\Announcement;
use App\Models\Backend\Books\Book;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseAssignment;
use App\Models\Backend\Course\CourseBatch;
use App\Models\Backend\Course\CourseClass;
use App\Models\Backend\Course\CourseQuestion;
use App\Models\Backend\Course\QuestionAnswer;
use App\Models\Backend\Event\Event;
use App\Models\Backend\Quiz\Quiz;
use App\Models\Backend\Sale\Sale;
use App\Models\Backend\Sale\Transaction;
use App\Models\User;
use App\Observers\Announcement\AnnouncementObserver;
use App\Observers\Books\BookObserver;
use App\Observers\Course\CourseAssignmentObserver;
use App\Observers\Course\CourseBatchObserver;
use App\Observers\Course\CourseClassObserver;
use App\Observers\Course\CourseObserver;
use App\Observers\Course\CourseQuestionObserver;
use App\Observers\Course\QuestionAnswerObserver;
use App\Observers\Event\EventObserver;
use App\Observers\Quiz\QuizObserver;
use App\Observers\Sale\SaleObserver;
use App\Observers\Sale\TransactionObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Announcement::observe(AnnouncementObserver::class);
        Book::observe(BookObserver::class);
        Event::observe(EventObserver::class);
        Course::observe(CourseObserver::class);
        CourseAssignment::observe(CourseAssignmentObserver::class);
        CourseBatch::observe(CourseBatchObserver::class);
        CourseClass::observe(CourseClassObserver::class);
        CourseQuestion::observe(CourseQuestionObserver::class);
        QuestionAnswer::observe(QuestionAnswerObserver::class);
        Quiz::observe(QuizObserver::class);
        Sale::observe(SaleObserver::class);
        Transaction::observe(TransactionObserver::class);
    }
}
