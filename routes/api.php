<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::any('login', ['as' => 'v1.login', 'uses' => 'Api\V1\LoginController@login']);
    Route::get('api-logout', ['as' => 'v1.api-logout', 'uses' => 'Api\V1\LoginController@logout']);
    Route::get('user-otp', 'Api\V1\UserDetailController@oneTimePassword');
    Route::get('user-otp-registration', 'Api\V1\UserDetailController@oneTimePasswordForRegistration');
    Route::get('user-otp-verify', 'Api\V1\UserDetailController@oneTimePasswordVerify');
    Route::get('reset-password-pin/{id}', 'Auth\UpdatePasswordController@resetPasswordPin');
    Route::post('reset-password', 'Api\V1\UserDetailController@resetPasswordPinByPost');
    Route::get('home', ['as' => 'v1.home', 'uses' => 'Api\V1\AppHomeController@home']);

    Route::post('student-registration-store', 'Api\V1\UserDetailController@storeStudent');

    Route::get('status-list', ['as' => 'v1.status-list', 'uses' => 'Api\V1\UtilityController@statusText']);
    Route::get('married-status-list', ['as' => 'v1.married-status-list', 'uses' => 'Api\V1\UtilityController@marriedStatus']);
    Route::get('get-branch-list', ['as' => 'v1.get-branch-list', 'uses' => 'Api\V1\BranchController@getBranchList']);
    Route::get('get-frontend-branch-list', ['as' => 'v1.get-frontend-branch-list', 'uses' => 'Api\V1\BranchController@getFrontendBranchList']);
    Route::get('get-state-list', ['as' => 'v1.get-state-list', 'uses' => 'Backend\Setting\StateController@getStateList']);
    Route::get('get-city-list', ['as' => 'v1.get-city-list', 'uses' => 'Backend\Setting\CityController@getCityList']);
    Route::get('find-user-have-email', ['as' => 'v1.find-user-have-email', 'uses' => 'Api\V1\UserDetailController@findHaveEmail']);
    Route::get('find-user-name', ['as' => 'v1.find-user-name', 'uses' => 'Api\V1\UserDetailController@findHaveUserName']);
    Route::get('find-user-mobile-number', ['as' => 'v1.find-user-mobile-number', 'uses' => 'Api\V1\UserDetailController@findHaveMobile']);
    Route::get('get-course-category-list', ['as' => 'v1.get-course-category-list', 'uses' => 'Api\V1\CourseCategoryController@courseCategoryList']);
    Route::get('get-course-list', ['as' => 'v1.get-course-list', 'uses' => 'Api\V1\CourseController@getCourseList']);
    Route::get('get-course-list-pagination', ['as' => 'v1.get-course-list-pagination', 'uses' => 'Api\V1\CourseController@getCourseListWithPagination']);
    Route::get('get-course-detail/{id}', ['as' => 'v1.get-course-detail', 'uses' => 'Api\V1\CourseController@show']);
    Route::get('get-course-rating-comments', ['as' => 'v1.get-course-rating-comments', 'uses' => 'Api\V1\CourseRatingController@index']);
    Route::get('get-book-list', ['as' => 'v1.get-book-list', 'uses' => 'Api\V1\BookController@bookList']);
    Route::get('get-book-list-pagination', ['as' => 'v1.get-book-list', 'uses' => 'Api\V1\BookController@index']);
    Route::get('get-book-detail/{id}', ['as' => 'v1.get-book-list', 'uses' => 'Api\V1\BookController@show']);
    Route::get('get-book-rating-comments', ['as' => 'v1.get-book-rating-comments', 'uses' => 'Api\V1\BookRatingCommentController@index']);
    Route::get('get-e-book-list', ['as' => 'v1.get-book-list', 'uses' => 'Api\V1\BookController@ebookListWithOutPagination']);
    Route::get('get-e-book-list-pagination', ['as' => 'v1.get-book-list', 'uses' => 'Api\V1\BookController@ebookList']);
    Route::get('get-book-category-list', ['as' => 'v1.get-book-category-list', 'uses' => 'Api\V1\BookCategoryController@getBookCategoryList']);
    Route::get('get-banner-list', ['as' => 'v1.get-banner-list', 'uses' => 'Api\V1\BannerController@getBannerList']);
    //faq
    Route::get('get-faq-list', ['as' => 'v1.get-faq-list', 'uses' => 'Api\V1\FaqController@getFaqList']);

    //book price list
    Route::get('get-book-price-list', ['as' => 'v1.get-book-price-list', 'uses' => 'Api\V1\BookPriceListController@getBookPriceList']);

    //branch location
    Route::get('get-branch-location', ['as' => 'v1.get-branch-location', 'uses' => 'Api\V1\BranchLocationController@getBranchLocation']);
    
    Route::get('get-googleApiKey', ['as' => 'v1.get-googleApiKey', 'uses' => 'Api\V1\GoogleApiKeyController@getgoogleApiKey']);



    Route::get('get-blog-list', ['as' => 'v1.get-blog-list', 'uses' => 'Api\V1\BlogController@blogList']);
    Route::get('get-blog-list-pagination', ['as' => 'v1.get-blog-list-pagination', 'uses' => 'Api\V1\BlogController@index']);
    Route::get('get-course-class-list-pagination', ['as' => 'v1.get-course-class-list-pagination', 'uses' => 'Api\V1\CourseClassController@index']);
    Route::get('get-course-class-detail/{id}', ['as' => 'v1.get-course-class-detail', 'uses' => 'Api\V1\CourseClassController@show']);
    Route::get('get-event-list-pagination', ['as' => 'v1.get-event-list-pagination', 'uses' => 'Api\V1\EventController@index']);
    Route::get('get-event-detail/{id}', ['as' => 'v1.get-event-detail', 'uses' => 'Api\V1\EventController@show']);
    Route::get('get-announcement-list-pagination', ['as' => 'v1.get-announcement-list-pagination', 'uses' => 'Api\V1\CourseAnnouncementController@index']);
    Route::get('get-announcement-detail/{id}', ['as' => 'v1.get-announcement-detail', 'uses' => 'Api\V1\CourseAnnouncementController@show']);
    Route::get('get-course-quiz-list-pagination', ['as' => 'v1.get-course-quiz-list-pagination', 'uses' => 'Api\V1\CourseQuizController@index']);
    Route::get('get-course-quiz-detail/{id}', ['as' => 'v1.get-course-quiz-detail', 'uses' => 'Api\V1\CourseQuizController@show']);
    Route::get('get-vendor-meeting', ['as' => 'v1.get-vendor-meeting', 'uses' => 'Api\V1\VendorMeetingController@index']);
    Route::get('get-vendor-meeting-detail/{id}', ['as' => 'v1.get-vendor-meeting-detail', 'uses' => 'Api\V1\VendorMeetingController@show']);
    Route::get('get-ssl-commerce-credential', ['as' => 'v1.get-ssl-commerce-credential', 'uses' => 'Api\V1\UtilityController@sslCommerceCredential']);
	
	

    Route::get('email-otp', 'Api\V1\UserDetailController@otpByEmail');
    Route::get('email-otp-verify', 'Api\V1\UserDetailController@emailOTPVerify');

	Route::get('get-quiz-list', ['as' => 'v1.get-quiz-list', 'uses' => 'Api\V1\QuizController@getQuizList']);
	Route::get('get-quiz-question-list', ['as' => 'v1.get-quiz-question-list', 'uses' => 'Api\V1\QuizController@getQuizQuestionList']);
	Route::get('get-quiz-answer-insert', ['as' => 'v1.get-quiz-answer-insert', 'uses' => 'Api\V1\QuizController@quizAnswer']);
	Route::get('get-quiz-user-result', ['as' => 'v1.get-quiz-user-result', 'uses' => 'Api\V1\QuizController@quizUserResult']);


	Route::get('post-cart-order-store', ['as' => 'v1.post-cart-order-store', 'uses' => 'Api\V1\SaleController@store']);
	
    Route::group(['middleware' => 'auth:api'], function () {
        //Route::resource('profiles', 'Api\V1\UserDetailController');
        Route::post('student-profile-update/{id}', 'Api\V1\UserDetailController@updateStudent');
        Route::post('student-profile-image', 'Api\V1\UserDetailController@profilePhoto');
        Route::get('profile-show', 'Api\V1\UserDetailController@showForApi');
        Route::post('pin-password-check', 'Api\V1\UserDetailController@pinPasswordCheck');
        Route::post('change-password/{id}', 'Auth\UpdatePasswordController@update');
        Route::get('user-api-logout', ['as' => 'v1.user-api-logout', 'uses' => 'Api\V1\UserDetailController@userApiLogout']);
        /*Route::get('get-course-category-list',['as' => 'v1.get-course-category-list', 'uses' => 'Api\V1\CourseCategoryController@courseCategoryList']);
        Route::get('get-course-list',['as' => 'v1.get-course-list', 'uses' => 'Api\V1\CourseController@getCourseList']);
        Route::get('get-book-list',['as' => 'v1.get-book-list', 'uses' => 'Api\V1\BookController@bookList']);
        Route::get('get-book-list-pagination',['as' => 'v1.get-book-list', 'uses' => 'Api\V1\BookController@index']);
        Route::get('get-e-book-list',['as' => 'v1.get-book-list', 'uses' => 'Api\V1\BookController@ebookListWithOutPagination']);
        Route::get('get-e-book-list-pagination',['as' => 'v1.get-book-list', 'uses' => 'Api\V1\BookController@ebookList']);*/
        Route::get('get-my-course-list', ['as' => 'v1.get-course-list', 'uses' => 'Api\V1\CourseController@getMyCourseList']);
        Route::get('get-my-course-list-pagination', ['as' => 'v1.get-course-list', 'uses' => 'Api\V1\CourseController@getMyCourseListWithPagination']);
        Route::get('get-my-course-class-list-pagination', ['as' => 'v1.get-my-course-class-list-pagination', 'uses' => 'Api\V1\CourseClassController@index']);
        Route::get('get-my-course-class-detail/{id}', ['as' => 'v1.get-my-course-class-detail', 'uses' => 'Api\V1\CourseClassController@show']);
        Route::post('post-my-course-rating-comment-store', ['as' => 'v1.post-my-course-rating-comment-store', 'uses' => 'Api\V1\CourseRatingController@store']);
        Route::post('post-my-course-assignment-store', ['as' => 'v1.post-my-course-assignment-store', 'uses' => 'Api\V1\CourseAssignmentController@store']);
        Route::get('get-my-course-assignment-list', ['as' => 'v1.get-my-course-assignment-list', 'uses' => 'Api\V1\CourseAssignmentController@index']);
        Route::get('get-my-event-list-pagination', ['as' => 'v1.get-my-event-list-pagination', 'uses' => 'Api\V1\EventController@index']);
        Route::get('get-my-event-detail/{id}', ['as' => 'v1.get-my-event-detail', 'uses' => 'Api\V1\EventController@show']);
        Route::post('post-event-invitation', ['as' => 'v1.post-event-invitation', 'uses' => 'Api\V1\EventRegisterController@store']);
        Route::get('get-my-notification-marked/{id}', ['as' => 'v1.get-my-notification-marked', 'uses' => 'Api\V1\NotificationController@markedAsRead']);
        Route::get('get-my-announcement-list-pagination', ['as' => 'v1.get-my-announcement-list-pagination', 'uses' => 'Api\V1\CourseAnnouncementController@index']);
        Route::get('get-my-announcement-detail/{id}', ['as' => 'v1.get-my-announcement-detail', 'uses' => 'Api\V1\CourseAnnouncementController@show']);
        Route::post('post-my-announcement-store', ['as' => 'v1.post-my-announcement-store', 'uses' => 'Api\V1\CourseAnnouncementController@store']);
        Route::get('get-my-course-quiz-list-pagination', ['as' => 'v1.get-course-quiz-list-pagination', 'uses' => 'Api\V1\CourseQuizController@index']);
        Route::get('get-my-course-quiz-detail/{id}', ['as' => 'v1.get-course-quiz-detail', 'uses' => 'Api\V1\CourseQuizController@show']);
        Route::post('post-my-course-quiz-store', ['as' => 'v1.post-my-course-quiz-store', 'uses' => 'Api\V1\CourseQuizController@store']);
        Route::post('post-my-book-rating-comment-store', ['as' => 'v1.post-my-book-rating-comment-store', 'uses' => 'Api\V1\BookRatingCommentController@store']);
        Route::get('get-my-all-notifications', ['as' => 'v1.get-my-all-notifications', 'uses' => 'Api\V1\NotificationController@index']);
        Route::post('post-my-all-notifications-marked', ['as' => 'v1.post-my-all-notifications-marked', 'uses' => 'Api\V1\NotificationController@markAllAsRead']);

        Route::get('get-my-vendor-meeting', ['as' => 'v1.get-my-vendor-meeting', 'uses' => 'Api\V1\VendorMeetingController@index']);
        Route::get('get-my-vendor-meeting-detail/{id}', ['as' => 'v1.get-my-vendor-meeting-detail', 'uses' => 'Api\V1\VendorMeetingController@show']);
        Route::get('get-my-course-result-list', ['as' => 'v1.get-my-course-result-list', 'uses' => 'Api\V1\CourseResultController@index']);
        Route::post('post-my-course-result-store', ['as' => 'v1.post-my-course-result-store', 'uses' => 'Api\V1\CourseResultController@store']);
        Route::get('get-my-course-chapter-list', ['as' => 'v1.get-my-course-chapter-list', 'uses' => 'Api\V1\CourseChapterController@index']);
        Route::post('post-my-course-chapter-store', ['as' => 'v1.post-my-course-chapter-store', 'uses' => 'Api\V1\CourseChapterController@store']);
        Route::get('get-my-course-progress-list', ['as' => 'v1.get-my-course-progress-list', 'uses' => 'Api\V1\CourseProgressController@index']);
        Route::post('post-my-course-progress-store', ['as' => 'v1.post-my-course-progress-store', 'uses' => 'Api\V1\CourseProgressController@store']);

        //Sale & Cart Routes
        Route::post('post-cart-order-store', ['as' => 'v1.post-cart-order-store', 'uses' => 'Api\V1\SaleController@store']);
        Route::get('get-universal-search', ['as' => 'v1.get-universal-search', 'uses' => 'Api\V1\SaleController@itemQuery']);
        Route::post('post-verify-cart-coupon', ['as' => 'v1.post-verify-cart-coupon', 'uses' => 'Api\V1\CouponController@check']);
        Route::get('get-purchase-history-pagination', ['as' => 'v1.get-purchase-history-pagination', 'uses' => 'Api\V1\SaleController@purchases']);
        Route::get('get-purchase-details/{id}', ['as' => 'v1.get-purchase-details', 'uses' => 'Api\V1\SaleController@show']);

        //FREE Book and Course
        Route::post('post-ebook-user-registration', ['as' => 'v1.post-ebook-user-registration', 'uses' => 'Api\V1\BookController@assignFreeBookUser']);
        
		
		
		Route::get('post-course-user-registration', ['as' => 'v1.post-course-user-registration', 'uses' => 'Api\V1\CourseController@assignFreeCourseToUser']);
		
    });
    //TODO Bad work need to switch to post method and on secure middleware
    // Currently working
    Route::get('post-sslcommerz-gateway-response', ['as' => 'v1.post-sslcommerz-gateway-response', 'uses' => 'Api\V1\TransactionController@store']);
});
