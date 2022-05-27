<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\Backend\CourseManage\CourseProgressService;
use App\Services\Backend\User\UserService;
use Illuminate\Http\Request;

class CourseProgressController
{
    /**
     * @var CourseProgressService
     */
    private $courseProgressService;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * CourseProgressController constructor.
     *
     * @param CourseProgressService $courseProgressService
     * @param UserService $userService
     */
    public function __construct(CourseProgressService $courseProgressService, UserService $userService)
    {
        $this->courseProgressService = $courseProgressService;
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
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:\Utility::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser,$request->all());
            $data['courseProgresses'] = $this->courseProgressService->showAllCourseProgress($requestData)->paginate($request->display_item_per_page);
            $data['status'] = true;
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            $data['status'] = true;
            $data['message'] = 'Course Progress table not found!!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            \DB::beginTransaction();
            $courseProgress = $this->courseProgressService->createCourseProgress($request->except('course_Progress_document', '_token'));
            if ($courseProgress) {
                $data['courseProgress'] = $courseProgress;
                $data['status'] = true;
                $data['message'] = 'Course Progress created successfully';
            } else {
                \DB::rollback();
                $data['status'] = false;
                $data['message'] = 'Failed to create Course Progress';
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to create Course Progress!!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }
}
