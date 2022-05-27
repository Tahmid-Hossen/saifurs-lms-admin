<?php

namespace App\Http\Controllers\Backend\CourseManage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CourseManage\CourseRatingRequest;
use App\Services\Backend\CourseManage\CourseRatingService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\Course\CourseChildCategoryService;
use App\Services\Backend\Course\CourseSubCategoryService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Exception;
use Illuminate\Http\Request;

class CourseRatingController extends Controller {
    /**
     * @var CourseRatingService
     */
    private $courseRatingService;

    /**
     * @var CourseService
     */
    private $courseService;

    /**
     * @var CourseCategoryService
     */
    private $courseCategoryService;

    /**
     * @var CourseSubCategoryService
     */
    private $courseSubCategoryService;

    /**
     * @var CourseChildCategoryService
     */
    private $courseChildCategoryService;

    /**
     * @var BranchService
     */
    private $branchService;

    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * CourseRatingController constructor.
     * @param CourseRatingService $courseRatingService
     * @param BranchService $branchService
     * @param UserService $userService
     * @param CompanyService $companyService
     * @param CourseService $courseService
     * @param CourseCategoryService $courseCategoryService
     * @param CourseSubCategoryService $courseSubCategoryService
     * @param CourseChildCategoryService $courseChildCategoryService
     */
    public function __construct(
        CourseRatingService $courseRatingService,
        BranchService $branchService,
        UserService $userService,
        CompanyService $companyService,
        CourseService $courseService,
        CourseCategoryService $courseCategoryService,
        CourseSubCategoryService $courseSubCategoryService,
        CourseChildCategoryService $courseChildCategoryService
    ) {
        $this->courseRatingService = $courseRatingService;
        $this->branchService = $branchService;
        $this->userService = $userService;
        $this->companyService = $companyService;
        $this->courseService = $courseService;
        $this->courseCategoryService = $courseCategoryService;
        $this->courseSubCategoryService = $courseSubCategoryService;
        $this->courseChildCategoryService = $courseChildCategoryService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @throws Exception
     */
    public function index( Request $request ) {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge( $companyWiseUser, $request->all() );
            $datas = $this->courseRatingService->showAllCourseRating( $requestData )->paginate( \Utility::$displayRecordPerPage );
            $companies = $this->companyService->showAllCompany( $companyWiseUser )->get();
            $courses = $this->courseService->showAllCourse( $requestData )->get();

            return View( 'backend.course.course-ratings.index', [
                'datas'     => $datas,
                'companies' => $companies,
                'request'   => $request,
                'courses'   => $courses,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Course ratings table not found!' )->error();
            return redirect()->to( '/' );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function create() {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany( $companyWiseUser )->get();
            $courses = $this->courseService->showAllCourse( $companyWiseUser )->get();
            $course_categories = $this->courseCategoryService->showAllCourseCategory( $companyWiseUser )->get();
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory( $companyWiseUser )->get();
            $course_child_categories = $this->courseChildCategoryService->showAllCourseChildCategory( $companyWiseUser )->get();
            return view( 'backend.course.course-ratings.create', [
                'course_categories'       => $course_categories,
                'companies'               => $companies,
                'courses'                 => $courses,
                'course_categories'       => $course_categories,
                'course_sub_categories'   => $course_sub_categories,
                'course_child_categories' => $course_child_categories,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Course ratings table not found!' )->error();
            return redirect( route( 'course-ratings.index' ) );
        }
    }

    /**
     * @param CourseRatingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( CourseRatingRequest $request ) {
        try {
            $this->courseRatingService->courseRatingCustomInsert( $request->all() );
            flash( 'Review-Rating of a Course has been Created successfully' )->success();
            return redirect( route( 'course-ratings.index' ) );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Failed to create Course rating!', 'error' );
            return back()->withInput( $request->all() );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show( $id ) {
        try {
            $data = $this->courseRatingService->showCourseRatingByID( $id );
            return view( 'backend.course.course-ratings.show', [
                'data' => $data,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Review-Rating of this Course isn\'t found !!' )->error();
            return redirect( route( 'course-ratings.index' ) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function edit( $id ) {
        try {
            $data = $this->courseRatingService->showCourseRatingByID( $id );
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany( $companyWiseUser )->get();
            $branches = $this->branchService->showAllBranch( $companyWiseUser )->get();
            $courses = $this->courseService->showAllCourse( $companyWiseUser )->get();
            return view( 'backend.course.course-ratings.edit', [
                'data'      => $data,
                'companies' => $companies,
                'branches'  => $branches,
                'courses'   => $courses,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Review-Rating of this Course isn\'t found !!' )->error();
            return redirect( route( 'course-ratings.index' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CourseRatingRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update( CourseRatingRequest $request, $id ) {
        try {
            $data = $this->courseRatingService->courseRatingCustomUpdate( $request->all(), $id );
            if ( $data ) {
                flash( 'Review-Rating of a Course has been updated successfully' )->success();
            } else {
                flash( 'Failed to update Course rating' )->error();
            }
        } catch ( Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Failed to update Course rating' )->error();
            return back()->withInput( $request->all() );
        }
        return redirect( route( 'course-ratings.index' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy( $id ) {
        $user_get = $this->userService->whoIS( $_REQUEST );
        if ( isset( $user_get ) && isset( $user_get->id ) && $user_get->id == auth()->user()->id ) {
            $data = $this->courseRatingService->showCourseRatingByID( $id );
            if ( $data ) {
                $data->delete();
                flash( 'Course Rating deleted successfully' )->success();
            } else {
                flash( 'Review-Rating of this Course isn\'t found !!' )->error();
            }
        } else {
            flash( 'You Entered Wrong Password!' )->error();
        }
        return redirect( route( 'course-ratings.index' ) );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function pdf( Request $request ) {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge( $companyWiseUser, $request->all() );
            $course_ratings = $this->courseRatingService->showAllCourseRating( $requestData )->get();
            return View( 'backend.course.course-ratings.pdf', [
                'datas' => $course_ratings,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Course Ratings table not found!' )->error();
            return redirect( route( 'course-ratings.index' ) );
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function excel( Request $request ) {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge( $companyWiseUser, $request->all() );
            $course_ratings = $this->courseRatingService->showAllCourseRating( $requestData )->get();
            return View( 'backend.course.course-ratings.excel', [
                'datas'   => $course_ratings,
                'request' => $request,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Course Ratings table not found!' )->error();
            return redirect( route( 'course-ratings.index' ) );
        }
    }
}
