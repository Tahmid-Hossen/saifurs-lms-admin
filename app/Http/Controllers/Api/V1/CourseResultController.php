<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Backend\Result\ResultRequest;
use App\Services\Backend\CourseManage\CourseBatchService;
use App\Services\Backend\CourseManage\CourseClassService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\Quiz\QuizService;
use App\Services\Backend\Result\ResultService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CourseResultController
{
    /**
     * @var ResultService
     */
    private $resultService;

    /**
     * @var QuizService
     */
    private $quizService;

    /**
     * @var CourseBatchService
     */
    private $courseBatchService;

    /**
     * @var CourseClassService
     */
    private $courseClassService;

    /**
     * @var CourseService
     */
    private $courseService;

    /**
     * @var companyService
     */
    private $companyService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param ResultService $resultService
     * @param QuizService $quizService
     * @param CourseBatchService $courseBatchService
     * @param CourseClassService $courseClassService
     * @param CourseService $courseService
     * @param CompanyService $companyService
     * @param UserService $userService
     */
    public function __construct(
        ResultService $resultService,
        QuizService $quizService,
        CourseBatchService $courseBatchService,
        CourseClassService $courseClassService,
        CourseService $courseService,
        CompanyService $companyService,
        UserService $userService
    )
    {
        $this->resultService = $resultService;
        $this->quizService = $quizService;
        $this->courseBatchService = $courseBatchService;
        $this->courseClassService = $courseClassService;
        $this->courseService = $courseService;
        $this->companyService = $companyService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            //$companyWiseUser = $this->userService->user_role_display();
            $companyWiseUser = array();
            $requestData = array_merge($companyWiseUser,$request->all());
            $data['results'] = $this->resultService->showAllResult($requestData)->paginate($request->display_item_per_page);
            $data['status'] = true;
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Result table not found!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ResultRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(ResultRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            \DB::beginTransaction();
            $result = $this->resultService->customResultStore($request->except('_token'));
            if ($result) {
                $data['status'] = true;
                $data['message'] = 'Result Stored successfully';
            } else {
                \DB::rollback();
                $data['status'] = false;
                $data['message'] = 'Failed to Store Result';
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to Store Result!!';
        }
        return response()->json($data,200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $result = $this->resultService->resultById($id);
            $data['result'] = $result;
            $data['status'] = true;
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Result data not found!!';
        }
        return response()->json($data,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ResultRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(ResultRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            \DB::beginTransaction();
            $result = $this->resultService->updateResult($request->except('_token'), $id);
            if ($result) {
                $data['result'] = $result;
                $data['status'] = true;
                $data['message'] = 'Result updated successfully';
            } else {
                \DB::rollback();
                $data['status'] = false;
                $data['message'] = 'Failed to update Result';
                flash('Failed to update Result')->error();
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to update Result!!';
            flash('Failed to update Result')->error();
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
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            \DB::beginTransaction();
            $user_get = $this->userService->whoIS($_REQUEST);
            if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
                $result = $this->resultService->resultById($id);
                if ($result) {
                    $result->delete();
                    $data['status'] = true;
                    $data['message'] = 'Result deleted successfully';
                }else{
                    \DB::rollback();
                    $data['status'] = false;
                    $data['message'] = 'Result is not found!';
                }
            }else{
                $data['status'] = false;
                $data['message'] = 'You Entered Wrong Password!';
            }
        } catch ( \Exception $e ) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Result is not found!!';
        }
        return response()->json($data,200);
    }
}
