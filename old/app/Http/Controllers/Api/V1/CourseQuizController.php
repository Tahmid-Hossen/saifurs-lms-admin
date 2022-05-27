<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Backend\Quiz\QuizRequest;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\Course\CourseChildCategoryService;
use App\Services\Backend\Course\CourseSubCategoryService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\Quiz\QuizService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseQuizController
{
    /**
     * @var QuizService
     */
    private $quizService;

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
     * QuizController constructor.
     * @param QuizService $quizService
     * @param BranchService $branchService
     * @param UserService $userService
     * @param CompanyService $companyService
     * @param CourseService $courseService
     * @param CourseCategoryService $courseCategoryService
     * @param CourseSubCategoryService $courseSubCategoryService
     * @param CourseChildCategoryService $courseChildCategoryService
     */
    public function __construct(
        QuizService $quizService,
        BranchService $branchService,
        UserService $userService,
        CompanyService $companyService,
        CourseService $courseService,
        CourseCategoryService $courseCategoryService,
        CourseSubCategoryService $courseSubCategoryService,
        CourseChildCategoryService $courseChildCategoryService
    ) {
        $this->quizService = $quizService;
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
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge( $companyWiseUser, $request->all() );
            $data['quizzes'] = $this->quizService->showAllQuiz( $requestData )->paginate( $request->display_item_per_page );
            $data['companies'] = $this->companyService->showAllCompany( $companyWiseUser )->get();
            $data['courses'] = $this->courseService->showAllCourse( $requestData )->get();
            $data['status'] = true;
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            $data['status'] = true;
            $data['message'] = 'Quizzes table not found!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuizRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(QuizRequest $request ): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $data['quiz'] = $this->quizService->quiz_custom_insert( $request->all() );
            $data['status'] = true;
            $data['message'] = 'A Quiz has been Created Successfully';
            DB::commit();
        } catch ( \Exception $e ) {
            DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to create a Quiz!';
        }
        return response()->json($data,200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id ): \Illuminate\Http\JsonResponse
    {
        try {
            $data['quiz'] = $this->quizService->showQuizByID( $id );
            $data['status'] = true;
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Data of This Quiz isn\'t found !!';
        }
        return response()->json($data,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuizRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(QuizRequest $request, $id ): \Illuminate\Http\JsonResponse
    {
        try {
            $quiz = $this->quizService->quiz_custom_update( $request->all(), $id );
            if ( $quiz ) {
                $data['quiz'] = $quiz;
                $data['status'] = true;
                $data['message'] = 'A Quiz has been Updated Successfully';
                DB::commit();
            } else {
                DB::rollback();
                $data['status'] = false;
                $data['message'] = 'Failed to update Quiz';
            }
        } catch ( Exception $e ) {
            DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to update Quiz!!';
        }
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
            DB::beginTransaction();
            $user_get = $this->userService->whoIS( $_REQUEST );
        if ( isset( $user_get ) && isset( $user_get->id ) && $user_get->id == auth()->user()->id ) {
            $quiz = $this->quizService->showQuizByID( $id );
            if ( $quiz ) {
                $quiz->delete();
                $data['status'] = true;
                $data['message'] = 'A Quiz has been deleted successfully';
            } else {
                DB::rollback();
                $data['status'] = false;
                $data['message'] = 'Data of This Quiz isn\'t found !';
            }
        } else {
            $data['status'] = false;
            $data['message'] = 'You Entered Wrong Password!';
        }
        } catch ( \Exception $e ) {
            DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Data of This Quiz isn\'t found !!';
        }
        return response()->json($data,200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getQuizList(Request $request ): \Illuminate\Http\JsonResponse
    {
        $companyWiseUser = $this->userService->user_role_display_for_api();
        $requestData = array_merge( $companyWiseUser, $request->all() );
        $quizzes = $this->quizService->showAllQuiz( $requestData )->get();
        if ( count( $quizzes ) > 0 ):
            $data['quizzes'] = $quizzes;
            $data['status'] = true;
        else:
            $data['status'] = false;
            $data['message'] = 'Data of This Quiz isn\'t found !';
        endif;
        return response()->json($data,200);
    }
}
