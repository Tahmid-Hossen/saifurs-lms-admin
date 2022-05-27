<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Backend\CourseManage\CourseAssignmentApiRequest;
use App\Services\Backend\CourseManage\CourseAssignmentService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Illuminate\Http\Request;

class CourseAssignmentController
{
    /**
     * @var CourseAssignmentService
     */
    private $courseAssignmentService;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var CourseService
     */
    private $courseService;

    /**
     * CourseAssignmentController constructor.
     * @param CourseAssignmentService $courseAssignmentService
     * @param UserService $userService
     * @param CompanyService $companyService
     * @param CourseService $courseService
     */
    public function __construct(
        CourseAssignmentService $courseAssignmentService,
        UserService $userService,
        CompanyService $companyService,
        CourseService $courseService
    )
    {
        $this->courseAssignmentService = $courseAssignmentService;
        $this->userService = $userService;
        $this->companyService = $companyService;
        $this->courseService = $courseService;
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
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser,$request->all());
            $data['courseAssignments'] = $this->courseAssignmentService->showAllCourseAssignment($requestData)->paginate($request->display_item_per_page);
            //$data['companies'] = $this->companyService->showAllCompany($requestData)->get();
            //$data['courses'] = $this->courseService->showAllCourse($requestData)->get();
            $data['status'] = true;
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            $data['status'] = true;
            $data['message'] = 'Course Assignment table not found!!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseAssignmentApiRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CourseAssignmentApiRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            \DB::beginTransaction();
            $courseAssignment = $this->courseAssignmentService->createCourseAssignment($request->except('course_assignment_document', '_token'));
            if ($courseAssignment) {
                // Course Assignment Document
                $request['course_assignment_id'] = $courseAssignment->id;
                if ($request->hasFile('course_assignment_document')) {
                    $image_url = $this->courseAssignmentService->courseAssignmentLogo($request);
                    $courseAssignment->course_assignment_document = $image_url;
                    $courseAssignment->save();
                }
                $data['courseAssignment'] = $courseAssignment;
                $data['status'] = true;
                $data['message'] = 'Assignment submitted successfully';
            } else {
                \DB::rollback();
                $data['status'] = false;
                $data['message'] = 'Assignment submission failed';
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Assignment submission failed';
        }
        $data['request'] = $request->all();
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
            $courseAssignment = $this->courseAssignmentService->courseAssignmentById($id);
            $data['courseAssignment'] = $courseAssignment;
            $data['status'] = true;
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Course Assignment data not found!';
        }
        return response()->json($data,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CourseAssignmentApiRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(CourseAssignmentApiRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            \DB::beginTransaction();
            $courseAssignment = $this->courseAssignmentService->updateCourseAssignment($request->except('course_assignment_document', '_token'), $id);
            if ($courseAssignment) {
                // Course Assignment Document
                $request['course_assignment_id'] = $courseAssignment->id;
                if ($request->hasFile('course_assignment_document')) {
                    $image_url = $this->courseAssignmentService->courseAssignmentLogo($request);
                    $courseAssignment->course_assignment_document = $image_url;
                    $courseAssignment->save();
                }
                $data['courseAssignment'] = $courseAssignment;
                $data['status'] = true;
                $data['message'] = 'Course Assignment update successfully';
            } else {
                \DB::rollback();
                $data['status'] = false;
                $data['message'] = 'Failed to update Course Assignment';
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to update Course Assignment!!';
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
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            \DB::beginTransaction();
            $user_get = $this->userService->whoIS($_REQUEST);
            if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
                $courseAssignment = $this->courseAssignmentService->courseAssignmentById($id);
                if ($courseAssignment) {
                    $courseAssignment->delete();
                    $data['status'] = true;
                    $data['message'] = 'Course Assignment deleted successfully';
                }else{
                    \DB::rollback();
                    $data['status'] = false;
                    $data['message'] = 'Course Assignment not found!';
                }
            }else{
                $data['status'] = false;
                $data['message'] = 'You Entered Wrong Password!';
            }
            \DB::commit();
        } catch ( \Exception $e ) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Course Assignment not found!!';
        }
        return response()->json($data,200);
    }

    /**
     * Update Review the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function updateReview(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            \DB::beginTransaction();
            $courseAssignment = $this->courseAssignmentService->updateCourseAssignment($request->except('course_assignment_document', '_token'), $id);
            if ($courseAssignment) {
                // Course Assignment Document
                $request['course_assignment_id'] = $courseAssignment->id;
                if ($request->hasFile('course_assignment_document')) {
                    $image_url = $this->courseAssignmentService->courseAssignmentLogo($request);
                    $courseAssignment->course_assignment_document = $image_url;
                    $courseAssignment->save();
                }
                $data['courseAssignment'] = $courseAssignment;
                $data['status'] = true;
                $data['message'] = 'Course Assignment Review update successfully';
            } else {
                \DB::rollback();
                $data['status'] = false;
                $data['message'] = 'Failed to update Course Assignment Review';
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to update Course Assignment Review!!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }
}

