<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Backend\CourseManage\CourseRatingRequest;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\Course\CourseChildCategoryService;
use App\Services\Backend\Course\CourseSubCategoryService;
use App\Services\Backend\CourseManage\CourseRatingService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use Illuminate\Http\Request;

class CourseRatingController
{
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
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request ): \Illuminate\Http\JsonResponse
    {
        try {
            $request->display_item_per_page = $request->display_item_per_page ?? \Utility::$displayRecordPerPage;
            $request['course_rating_comment_sort_by_id'] = $request['course_rating_comment_sort_by_id'] ?? 'DESC';
            //$companyWiseUser = $this->userService->user_role_display_for_api();
            $companyWiseUser = array();
            $requestData = array_merge( $companyWiseUser, $request->all() );
            $data['courseRating'] = $this->courseRatingService->showAllCourseRating( $requestData )->paginate( $request->display_item_per_page );
            //$data['companies'] = $this->companyService->showAllCompany( $companyWiseUser )->get();
            //$data['courses'] = $this->courseService->showAllCourse( $requestData )->get();
            $data['status'] = true;
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            $data['status'] = true;
            $data['message'] = 'Course ratings table not found!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseRatingRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CourseRatingRequest $request ): \Illuminate\Http\JsonResponse
    {
        try {
            \DB::beginTransaction();
            $courseRating = $this->courseRatingService->courseRatingCustomInsert( $request->all() );
            $data['courseRating'] = $courseRating;
            $data['status'] = true;
            $data['message'] = 'Review-Rating of a Course has been Created successfully';
            \DB::commit();
        } catch ( \Exception $e ) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to create Course rating!!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function show($id ): \Illuminate\Http\JsonResponse
    {
        try {
            $courseRating = $this->courseRatingService->showCourseRatingByID( $id );
            $data['courseRating'] = $courseRating;
            $data['status'] = true;
        } catch ( \Exception $e ) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Review-Rating of this Course isn\'t found !!';
        }
        return response()->json($data,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CourseRatingRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(CourseRatingRequest $request, $id ): \Illuminate\Http\JsonResponse
    {
        try {
            \DB::beginTransaction();
            $courseRating = $this->courseRatingService->courseRatingCustomUpdate( $request->all(), $id );
            if ( $courseRating ) {
                $data['courseRating'] = $courseRating;
                $data['status'] = true;
                $data['message'] = 'Review-Rating of a Course has been updated successfully';
                \DB::commit();
            } else {
                \DB::rollback();
                $data['status'] = false;
                $data['message'] = 'Failed to create Update rating';
            }
        } catch ( \Exception $e ) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to create Update rating!!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroy($id ): \Illuminate\Http\JsonResponse
    {
        try {
            \DB::beginTransaction();
            $user_get = $this->userService->whoIS( $_REQUEST );
            if ( isset( $user_get ) && isset( $user_get->id ) && $user_get->id == auth()->user()->id ) {
                $data = $this->courseRatingService->showCourseRatingByID( $id );
                if ( $data ) {
                    $data->delete();
                    $data['status'] = true;
                    $data['message'] = 'Course Rating deleted successfully';
                } else {
                    \DB::rollback();
                    $data['status'] = false;
                    $data['message'] = 'Review-Rating of this Course isn\'t found !';
                }
            } else {
                $data['status'] = false;
                $data['message'] = 'You Entered Wrong Password!';
            }
            \DB::commit();
        } catch ( \Exception $e ) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Review-Rating of this Course isn\'t found !!';
        }
        return response()->json($data,200);
    }
}
