<?php

use App\Models\Backend\Course\CourseChildCategory;
use App\Models\Backend\Course\CourseSubCategory;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', 'HomeController@index');

Route::get('/home', ['as' => 'home', 'uses' => 'HomeController@index']);

Auth::routes();

Route::group(['prefix' => 'backend'], function () {
    Route::get('signin', ['as' => 'backend.signin', 'uses' => 'Auth\LoginController@login']);
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
});

Route::group(['prefix' => 'backend', 'middleware' => ['auth', 'userHasAccess']], function () {

    //AJAX Routes
    Route::group(['prefix' => 'ajax'], function() {

    });

    Route::get('/', ['as' => 'dashboard', 'uses' => 'Backend\DashboardController@index']);
    Route::resource('roles', 'Backend\User\RolesController');
    Route::get('roles/{id}/permissions', ['as' => 'roles.permissions', 'uses' => 'Backend\User\RolesController@permission']);
    Route::post('roles/{id}/permissions', ['as' => 'roles.permissions.store', 'uses' => 'Backend\User\RolesController@storePermission']);
    Route::resource('users', 'Backend\User\UsersController');
    Route::group(['prefix' => 'users'], function () {
        Route::get('{id}/roles', ['as' => 'users.roles', 'uses' => 'Backend\User\UsersController@roles']);
        Route::post('{id}/roles', ['as' => 'users.roles.store', 'uses' => 'Backend\User\UsersController@saveRoles']);

        Route::get('{id}/permissions', ['as' => 'users.permissions', 'uses' => 'Backend\User\UsersController@permissions']);
        Route::post('{id}/permissions', ['as' => 'users.permissions.store', 'uses' => 'Backend\User\UsersController@savePermissions']);
        Route::post(
            'findHaveEmail',
            [
                'as' => 'users.findHaveEmail',
                'uses' => 'Backend\User\UsersController@findHaveEmail',
            ]
        );
        Route::post(
            'findHaveUserName',
            [
                'as' => 'users.find-user-name',
                'uses' => 'Backend\User\UsersController@findHaveUserName',
            ]
        );
        Route::post(
            'find-user-name-have',
            [
                'as' => 'users.find-user-name-have',
                'uses' => 'Backend\User\UsersController@findUserNameHave',
            ]
        );
        Route::post(
            'find-user-have-id',
            [
                'as' => 'users.find-user-have-id',
                'uses' => 'Backend\User\UsersController@findUserHaveId',
            ]
        );
    });

    Route::post(
        'find-user-mobile-number',
        [
            'as' => 'users.find-user-mobile-number',
            'uses' => 'Backend\User\UsersController@findHaveMobile',
        ]
    );

    Route::resource('permissions', 'Backend\User\PermissionsController');

    Route::group(['prefix' => 'user-details'], function () {
        Route::get('pdf', ['as' => 'user-details.pdf', 'uses' => 'Backend\User\UserDetailController@pdf']);
        Route::get('excel', ['as' => 'user-details.excel', 'uses' => 'Backend\User\UserDetailController@excel']);
        Route::post('get-user-detail-list', ['as' => 'user-details.get-user-detail-list', 'uses' => 'Backend\User\UserDetailController@getUserDetailList']);
    });
    Route::resource('user-details', 'Backend\User\UserDetailController');
    Route::group(['prefix' => 'teachers'], function () {
        Route::get('pdf', ['as' => 'teachers.pdf', 'uses' => 'Backend\User\TeacherController@pdf']);
        Route::get('excel', ['as' => 'teachers.excel', 'uses' => 'Backend\User\TeacherController@excel']);
        Route::post('get-teacher-list', ['as' => 'teachers.get-teacher-list', 'uses' => 'Backend\User\TeacherController@getUserDetailList']);
    });
    Route::resource('teachers', 'Backend\User\TeacherController');
    Route::group(['prefix' => 'students'], function () {
        Route::get('pdf', ['as' => 'students.pdf', 'uses' => 'Backend\User\StudentController@pdf']);
        Route::get('excel', ['as' => 'students.excel', 'uses' => 'Backend\User\StudentController@excel']);
        Route::post('get-student-list', ['as' => 'students.get-student-list', 'uses' => 'Backend\User\StudentController@getUserDetailList']);
    });
    Route::resource('students', 'Backend\User\StudentController');
    Route::resource('user-register', 'Backend\User\UserRegisterController');

//Common Operations for all Models
    Route::group(['prefix' => 'common'], function () {
        Route::get('delete', ['as' => 'common-delete.delete', 'uses' => 'Backend\CommonOperationController@delete']);
        Route::get('update', ['as' => 'common-update.update', 'uses' => 'Backend\CommonOperationController@update']);
        Route::resource('keywords', 'Backend\Common\KeywordController');

    });

// Country Routes
    Route::resource('countries', 'Backend\Setting\CountryController');
    Route::resource('states', 'Backend\Setting\StateController');
    Route::group(['prefix' => 'states'], function () {
        Route::post('get-state-list', ['as' => 'states.get-state-list', 'uses' => 'Backend\Setting\StateController@getStateList']);
    });

// City Routes
    Route::resource('cities', 'Backend\Setting\CityController');
    Route::group(['prefix' => 'cities'], function () {
        Route::post('get-city-list', ['as' => 'cities.get-city-list', 'uses' => 'Backend\Setting\CityController@getCityList']);
    });

//Book Manage Routes
    Route::prefix('books')->group(function () {
        Route::get('notification-book/{id}', ['as' => 'books.notification-book', 'uses' => 'Backend\Book\BookController@bookMarkedAsRead']);

        Route::get('export/pdf', ['as' => 'book.pdf', 'uses' => 'Backend\Book\BookController@pdf']);
        Route::get('export/excel', ['as' => 'book.excel', 'uses' => 'Backend\Book\BookController@excel']);
        Route::resource('categories', 'Backend\Book\CategoryController');
    });
	
	
    Route::resource('books', 'Backend\Book\BookController');
	Route::post('book-stock-update', ['as' => 'books.stockupdate', 'uses' => 'Backend\Book\BookController@updateStocks']);
	Route::get('book-stock-history', ['as' => 'books.stockhistory', 'uses' => 'Backend\Book\BookController@stockHistory']);
    // Route::view('notification-book/{id}', 'header', ['name' => 'books.notification-book']);

    Route::prefix('ebooks')->group(function () {
        Route::get('export/pdf', ['as' => 'ebooks.pdf', 'uses' => 'Backend\Book\EBookController@pdf']);
        Route::get('export/excel', ['as' => 'ebooks.excel', 'uses' => 'Backend\Book\EBookController@excel']);
        Route::get('download/{id}/ebook', ['as' => 'ebooks.download', 'uses' => 'Backend\Book\EBookController@download']);
    });
    Route::resource('ebooks', 'Backend\Book\EBookController');
//Sales
    Route::prefix('sales')->group(function () {
        Route::get('notification-marked/{id}', ['as' => 'order.notification-marked', 'uses' => 'Backend\Sale\SaleController@orderMarkedAsRead']);
        Route::get('invoice/{id}', ['as' => 'sales.invoice', 'uses' => 'Backend\Sale\SaleController@invoice']);
        Route::get('invoice-pdf/{id}', ['as' => 'sales.invoicePDF', 'uses' => 'Backend\Sale\SaleController@printInvoicePDF']);
        Route::put('update-field-info/{id}', ['as' => 'sales.update-field', 'uses' => 'Backend\Sale\SaleController@updateFields']);


        Route::get('search-items', ['as' => 'sales.items', 'uses' => 'Backend\Sale\SaleController@itemQuery']);
        Route::put('{id}/status-update', ['as' => 'sales.status.update', 'uses' => 'Backend\Sale\SaleController@statusUpdate']);
        Route::put('{id}/payment-status-update', ['as' => 'payment.status.update', 'uses' => 'Backend\Sale\SaleController@paymentStatusUpdate']);
    });
    Route::resource('sales', 'Backend\Sale\SaleController');

    Route::get('purchase-history', 'Backend\Sale\SaleController@purchases');

    //Transactions
    Route::prefix('transactions')->group(function () {
        Route::get('invoice/{id}', ['as' => 'transactions.invoice', 'uses' => 'Backend\Sale\TransactionController@invoice']);
        Route::get('check-status/{transaction_id}', ['as' => 'transactions.status', 'uses' => 'Backend\Sale\TransactionController@checkStatus']);

    });
    Route::resource('transactions', 'Backend\Sale\TransactionController');


// Event Management Routes
    Route::group(['prefix' => 'events'], function () {
        Route::get('notification-marked/{id}', ['as' => 'events.notification-marked', 'uses' => 'Backend\Event\EventController@eventMarkedAsRead']);
        Route::get('pdf', ['as' => 'events.pdf', 'uses' => 'Backend\Event\EventController@pdf']);
        Route::get('excel', ['as' => 'events.excel', 'uses' => 'Backend\Event\EventController@excel']);
        Route::get('archives', ['as' => 'events.archive', 'uses' => 'Backend\Event\EventController@archive']);

    });
    Route::resource('events', 'Backend\Event\EventController');

    //EventRegistration Manage Route

    Route::group(['prefix' => 'events-registration'], function () {
        Route::get('notification-marked/{id}', ['as' => 'events-registration.notification-marked', 'uses' => 'Backend\Event\EventRegisterController@eventMarkedAsRead']);
        Route::get('pdf', ['as' => 'events-registration.pdf', 'uses' => 'Backend\Event\EventRegisterController@pdf']);
        Route::get('excel', ['as' => 'events-registration.excel', 'uses' => 'Backend\Event\EventRegisterController@excel']);
    });
    Route::resource('events-registration', 'Backend\Event\EventRegisterController');


// Company Routes
    Route::group(['prefix' => 'companies'], function () {
        Route::get('pdf', ['as' => 'companies.pdf', 'uses' => 'Backend\User\CompanyController@pdf']);
        Route::get('excel', ['as' => 'companies.excel', 'uses' => 'Backend\User\CompanyController@excel']);
    });
    Route::resource('companies', 'Backend\User\CompanyController');

// Course Category Manage
    Route::group(['prefix' => 'course-categories'], function () {
        Route::get('pdf', ['as' => 'course-categories.pdf', 'uses' => 'Backend\Course\CourseCategoryController@pdf']);
        Route::get('excel', ['as' => 'course-categories.excel', 'uses' => 'Backend\Course\CourseCategoryController@excel']);
        Route::post('get-course-category-list', ['as' => 'course-categories.get-course-category-list', 'uses' => 'Backend\Course\CourseCategoryController@getCourseCategoryList']);
    });
    Route::resource('course-categories', 'Backend\Course\CourseCategoryController');

    Route::group(['prefix' => 'course-sub-categories'], function () {
        Route::get('pdf', ['as' => 'course-sub-categories.pdf', 'uses' => 'Backend\Course\CourseSubCategoryController@pdf']);
        Route::get('excel', ['as' => 'course-sub-categories.excel', 'uses' => 'Backend\Course\CourseSubCategoryController@excel']);
        Route::post('get-course-sub-category-list', ['as' => 'course-sub-categories.get-course-sub-category-list', 'uses' => 'Backend\Course\CourseSubCategoryController@getCourseSubCategoryList']);
    });
    Route::resource('course-sub-categories', 'Backend\Course\CourseSubCategoryController');
    Route::post('course-sub-category', function (Request $request) {
        $category_id = $request->get('course_category_id');
        return response()->json(['status' => 200, 'data' => CourseSubCategory::where('course_category_id', $category_id)->get()]);
    })->name('course.get-sub-category-list');

    Route::group(['prefix' => 'course-child-categories'], function () {
        Route::get('pdf', ['as' => 'course-child-categories.pdf', 'uses' => 'Backend\Course\CourseChildCategoryController@pdf']);
        Route::get('excel', ['as' => 'course-child-categories.excel', 'uses' => 'Backend\Course\CourseChildCategoryController@excel']);
        Route::post('get-course-child-category-list',
            ['as' => 'course-child-categories.get-course-child-category-list',
                'uses' => 'Backend\Course\CourseChildCategoryController@getCourseChildCategoryList'
            ]);
    });
    Route::resource('course-child-categories', 'Backend\Course\CourseChildCategoryController');
    Route::post('course-child-category', function (Request $request) {
        $sub_category_id = $request->get('course_sub_category_id');
        return response()->json(['status' => 200, 'data' => CourseChildCategory::where('course_sub_category_id', $sub_category_id)->get()]);
    })->name('course.get-child-category-list');

    Route::group(['prefix' => 'branches'], function () {
        Route::get('pdf', ['as' => 'branches.pdf', 'uses' => 'Backend\User\BranchController@pdf']);
        Route::get('excel', ['as' => 'branches.excel', 'uses' => 'Backend\User\BranchController@excel']);
        Route::post('get-branch-list', ['as' => 'branches.get-branch-list', 'uses' => 'Backend\User\BranchController@getBranchList']);
    });
    Route::resource('branches', 'Backend\User\BranchController');

// Quiz Management Routes
    Route::group(['prefix' => 'quizzes'], function () {
        Route::get('pdf', ['as' => 'quizzes.pdf', 'uses' => 'Backend\Quiz\QuizController@pdf']);
        Route::get('excel', ['as' => 'quizzes.excel', 'uses' => 'Backend\Quiz\QuizController@excel']);
        Route::post('get-quiz-list', ['as' => 'quizzes.get-quiz-list', 'uses' => 'Backend\Quiz\QuizController@getQuizList']);
    });
    Route::resource('quizzes', 'Backend\Quiz\QuizController');
    Route::resource('answers', 'Backend\Quiz\AnswerController');
	Route::resource('questions', 'Backend\Quiz\QuestionController');


    Route::get('course-detail-tree/{id}', function ($id) {
        return json_encode(App\Models\Backend\Course\Course::where('id', $id)->get());
    });
    Route::get('driptype/{id}', function ($id) {
        return json_encode(App\Models\Backend\Course\Course::where('id', $id)->get('course_drip_content'));
    });
    Route::get('get/dripped-content-types/{id}', 'Controller@getJSONResponse');
    Route::group(['prefix' => 'course-listview'], function () {
        Route::post('get', ['as' => 'course-listview.get', 'uses' => 'Backend\CourseManage\CourseController@getCourseList']);
    });
// Course Manage
    Route::group(['prefix' => 'course'], function () {
        Route::get('notification-marked/{id}', ['as' => 'course.notification-marked', 'uses' => 'Backend\CourseManage\CourseController@courseMarkedAsRead']);
        Route::get('pdf', ['as' => 'course.pdf', 'uses' => 'Backend\CourseManage\CourseController@pdf']);
        Route::get('excel', ['as' => 'course.excel', 'uses' => 'Backend\CourseManage\CourseController@excel']);
        Route::post('get-course-list', ['as' => 'course.get-course-list', 'uses' => 'Backend\CourseManage\CourseController@getCourseList']);
        Route::get('download-file/{id}', ['as' => 'course.download-file', 'uses' => 'Backend\CourseManage\CourseController@downloadFile']);
    });
    Route::resource('course', 'Backend\CourseManage\CourseController');
    Route::any('coursetest', 'Backend\CourseManage\CourseController@crop')->name('crop');

    Route::group(['prefix' => 'course-chapters'], function () {
        Route::get('pdf', ['as' => 'course-chapters.pdf', 'uses' => 'Backend\CourseManage\CourseChapterController@pdf']);
        Route::get('excel', ['as' => 'course-chapters.excel', 'uses' => 'Backend\CourseManage\CourseChapterController@excel']);
        Route::post('get-course-chapter-list', ['as' => 'course.get-course-chapter-list', 'uses' => 'Backend\CourseManage\CourseChapterController@getCourseChapterList']);
        Route::get('download-file/{id}', ['as' => 'course-chapters.download-file', 'uses' => 'Backend\CourseManage\CourseChapterController@downloadFile']);
    });
    // Route::get('course-chapters/download-file/{id}', ['as' => 'course-chapters.download-file', 'uses' => 'Backend\CourseManage\CourseChapterController@downloadFile'])->route('course-chapters.download');

    Route::resource('course-chapters', 'Backend\CourseManage\CourseChapterController');

    Route::group(['prefix' => 'course-classes'], function () {
        Route::get('pdf', ['as' => 'course-classes.pdf', 'uses' => 'Backend\CourseManage\CourseClassController@pdf']);
        Route::get('excel', ['as' => 'course-classes.excel', 'uses' => 'Backend\CourseManage\CourseClassController@excel']);
        Route::post('get-course-class-list', ['as' => 'course.get-course-class-list', 'uses' => 'Backend\CourseManage\CourseClassController@getCourseClassList']);
        Route::get('download-file/{id}', ['as' => 'course-classes.download-file', 'uses' => 'Backend\CourseManage\CourseClassController@downloadFile']);
    });
    Route::resource('course-classes', 'Backend\CourseManage\CourseClassController');

     Route::group(['prefix' => 'quizzes'], function () {
        Route::get('pdf', ['as' => 'quizzes.pdf', 'uses' => 'Backend\Quiz\QuizController@pdf']);
        Route::get('excel', ['as' => 'quizzes.excel', 'uses' => 'Backend\Quiz\QuizController@excel']);
        Route::post('get-quiz-list', ['as' => 'quizzes.get-quiz-list', 'uses' => 'Backend\Quiz\QuizController@getQuizList']);
    });
	Route::group(['prefix' => 'questions'], function () {
        Route::get('pdf', ['as' => 'questions.pdf', 'uses' => 'Backend\Quiz\QuestionController@pdf']);
        Route::get('excel', ['as' => 'questions.excel', 'uses' => 'Backend\Quiz\QuestionController@excel']);
        Route::post('get-course-question-list', ['as' => 'course.get-course-question-list', 'uses' => 'Backend\Quiz\QuestionController@getCourseQuestionList']);
    });


    Route::group(['prefix' => 'answers'], function () {
        Route::get('pdf', ['as' => 'answers.pdf', 'uses' => 'Backend\Quiz\AnswerController@pdf']);
        Route::get('excel', ['as' => 'answers.excel', 'uses' => 'Backend\Quiz\AnswerController@excel']);
    });


    Route::group(['prefix' => 'course-syllabuses'], function () {
        Route::get('pdf', ['as' => 'course-syllabuses.pdf', 'uses' => 'Backend\CourseManage\CourseSyllabusController@pdf']);
        Route::get('excel', ['as' => 'course-syllabuses.excel', 'uses' => 'Backend\CourseManage\CourseSyllabusController@excel']);
        Route::get('download-file/{id}', ['as' => 'course-syllabuses.download-file', 'uses' => 'Backend\CourseManage\CourseSyllabusController@downloadFile']);
    });
    Route::resource('course-syllabuses', 'Backend\CourseManage\CourseSyllabusController');

    Route::group(['prefix' => 'course-learns'], function () {
        Route::get('pdf', ['as' => 'course-learns.pdf', 'uses' => 'Backend\CourseManage\CourseLearnController@pdf']);
        Route::get('excel', ['as' => 'course-learns.excel', 'uses' => 'Backend\CourseManage\CourseLearnController@excel']);
    });
    Route::resource('course-learns', 'Backend\CourseManage\CourseLearnController');

    Route::resource('vendors', 'Backend\Setting\VendorController');

    Route::group(['prefix' => 'course-assignments'], function () {
        Route::get('notification-marked/{id}', ['as' => 'course-assignments.notification-marked', 'uses' => 'Backend\CourseManage\CourseAssignmentController@assignmentMarkedAsRead']);
        Route::get('assignment-review/{id}', ['as' => 'course-assignments.assignment-review', 'uses' => 'Backend\CourseManage\CourseAssignmentController@assignmentReview']);
        Route::put('assignment-review-update/{id}', ['as' => 'course-assignments.assignment-review-update', 'uses' => 'Backend\CourseManage\CourseAssignmentController@updateReview']);
    });
    Route::resource('course-assignments', 'Backend\CourseManage\CourseAssignmentController');
    Route::group(['prefix' => 'course-batches'], function () {
        Route::get('course-batch-student-list/{id}', ['as' => 'course-batches.course-batch-student-list', 'uses' => 'Backend\CourseManage\CourseBatchController@courseBatchStudentList']);
        Route::post('get-course-batch-list', ['as' => 'course-batches.get-course-batch-list', 'uses' => 'Backend\CourseManage\CourseBatchController@courseBatchList']);
    });
    Route::resource('course-batches', 'Backend\CourseManage\CourseBatchController');
// Course Rating Management Routes
    Route::group(['prefix' => 'course-ratings'], function () {
        Route::get('pdf', ['as' => 'course-ratings.pdf', 'uses' => 'Backend\CourseManage\CourseRatingController@pdf']);
        Route::get('excel', ['as' => 'course-ratings.excel', 'uses' => 'Backend\CourseManage\CourseRatingController@excel']);
    });
    Route::resource('course-ratings', 'Backend\CourseManage\CourseRatingController');
// Announcement Management Routes
    Route::group(['prefix' => 'announcements'], function () {
        Route::get('pdf', ['as' => 'announcements.pdf', 'uses' => 'Backend\Announcement\AnnouncementController@pdf']);
        Route::get('excel', ['as' => 'announcements.excel', 'uses' => 'Backend\Announcement\AnnouncementController@excel']);
        Route::post('get-course-announcement-list', ['as' => 'course-announcements.get-course-announcement-list', 'uses' => 'Backend\Announcement\AnnouncementController@getAnnouncementList']);
    });
    Route::resource('announcements', 'Backend\Announcement\AnnouncementController');
// Banner Management Routes
    Route::group(['prefix' => 'banners'], function () {
        Route::get('pdf', ['as' => 'banners.pdf', 'uses' => 'Backend\Banner\BannerController@pdf']);
        Route::get('excel', ['as' => 'banners.excel', 'uses' => 'Backend\Banner\BannerController@excel']);
    });
    Route::resource('banners', 'Backend\Banner\BannerController');
    Route::group(['prefix' => 'vendor-meetings'], function () {
        Route::get('pdf', ['as' => 'vendor-meetings.pdf', 'uses' => 'Backend\Setting\VendorMeetingController@pdf']);
        Route::get('excel', ['as' => 'vendor-meetings.excel', 'uses' => 'Backend\Setting\VendorMeetingController@excel']);
    });
    Route::resource('vendor-meetings', 'Backend\Setting\VendorMeetingController');

    // Result Manage
    Route::group(['prefix' => 'results'], function () {
        Route::get('pdf', ['as' => 'results.pdf', 'uses' => 'Backend\Result\ResultController@pdf']);
        Route::get('excel', ['as' => 'results.excel', 'uses' => 'Backend\Result\ResultController@excel']);
        Route::get('print/{id}', ['as' => 'results.print', 'uses' => 'Backend\Result\ResultController@print']);
    });
    Route::resource('results', 'Backend\Result\ResultController');

    // Enrollment Manage
    Route::group(['prefix' => 'enrollments'], function () {
        Route::get('pdf', ['as' => 'enrollments.pdf', 'uses' => 'Backend\Enrollment\EnrollmentController@pdf']);
        Route::get('excel', ['as' => 'enrollments.excel', 'uses' => 'Backend\Enrollment\EnrollmentController@excel']);
        Route::get('print/{id}', ['as' => 'enrollments.print', 'uses' => 'Backend\Enrollment\EnrollmentController@print']);
    });
    Route::resource('enrollments', 'Backend\Enrollment\EnrollmentController');

    Route::group(['prefix' => 'book-rating-comments'], function () {
        Route::get('pdf', ['as' => 'book-rating-comments.pdf', 'uses' => 'Backend\Book\BookRatingCommentController@pdf']);
        Route::get('excel', ['as' => 'book-rating-comments.excel', 'uses' => 'Backend\Book\BookRatingCommentController@excel']);
    });
    Route::resource('book-rating-comments', 'Backend\Book\BookRatingCommentController');

    // Coupon Management Routes
    Route::group(['prefix' => 'coupons'], function () {
        Route::get('pdf', ['as' => 'coupons.pdf', 'uses' => 'Backend\Coupon\CouponController@pdf']);
        Route::get('excel', ['as' => 'coupons.excel', 'uses' => 'Backend\Coupon\CouponController@excel']);
        Route::post('check', ['as' => 'coupons.check', 'uses' => 'Backend\Coupon\CouponController@check']);
    });
    Route::resource('coupons', 'Backend\Coupon\CouponController');
    Route::group(['prefix' => 'blogs'], function () {
        Route::post('get-blog-list', ['as' => 'blogs.get-blog-list', 'uses' => 'Backend\Blog\BlogController@blogList']);
    });
    Route::resource('blogs', 'Backend\Blog\BlogController');
    //faq
    Route::resource('faq', 'Backend\Faq\FaqController');

    //Branch Location
    Route::resource('branchlocation', 'Backend\BranchLocation\BranchLocationController');

    //book price list
    Route::resource('bookpricelist', 'Backend\BookPriceList\BookPriceListController');
    
    //google api key
    Route::resource('googleApiKey', 'Backend\GoogleApiKey\GoogleApiKeyController');

    // Order Details Routes
    Route::group(['prefix' => 'orders'], function () {
        Route::get('pdf', ['as' => 'orders.pdf', 'uses' => 'Backend\OrderController@pdf']);
        Route::get('excel', ['as' => 'orders.excel', 'uses' => 'Backend\OrderController@excel']);
    });
    Route::resource('orders', 'Backend\OrderController');

    Route::get('notification-read/{notification}', ['as' => 'notification-read', 'uses' => 'Backend\NotificationController@notificationMarkedAsRead']);
    Route::get('mark-all-notification-as-read', ['as' => 'notification-all-read', 'uses' => 'Backend\NotificationController@notificationMarkAllAsRead']);

    Route::get('system-logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});

Route::get('lang/{lang}', 'LanguageController@switchLang')->name('lang.switch');

Route::group([], function() {
    Route::resource('azures', 'Rnd\AzureController');
});

Route::get('/mailable', function () {
    $invoice = App\Models\Backend\Sale\Sale::find(321);

    return view('invoice-pdf', ['sale' => $invoice]);
});

Route::group(['middleware' => 'auth'], function() {
    Route::get('/changePassword', 'Backend\User\UsersController@showChangePasswordGet')->name('changePasswordGet');
    Route::post('/changePassword', 'Backend\User\UsersController@showChangePasswordPost')->name('changePasswordPost');
});
