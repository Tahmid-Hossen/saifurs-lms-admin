<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Backend\Announcement\AnnouncementRequest;
use App\Services\Backend\Announcement\AnnouncementService;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\Course\CourseChildCategoryService;
use App\Services\Backend\Course\CourseSubCategoryService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseAnnouncementController
{
    /**
     * @var AnnouncementService
     */
    private $announcementService;

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
     * AnnouncementController constructor.
     * @param AnnouncementService $announcementService
     * @param BranchService $branchService
     * @param UserService $userService
     * @param CompanyService $companyService
     * @param CourseService $courseService
     * @param CourseCategoryService $courseCategoryService
     * @param CourseSubCategoryService $courseSubCategoryService
     * @param CourseChildCategoryService $courseChildCategoryService
     */
    public function __construct(
        AnnouncementService $announcementService,
        BranchService $branchService,
        UserService $userService,
        CompanyService $companyService,
        CourseService $courseService,
        CourseCategoryService $courseCategoryService,
        CourseSubCategoryService $courseSubCategoryService,
        CourseChildCategoryService $courseChildCategoryService
    ) {
        $this->announcementService = $announcementService;
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
            $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge( $companyWiseUser, $request->all() );
            $data['announcements'] = $this->announcementService->showAllAnnouncement( $requestData )->paginate( $request->display_item_per_page );
            //$data['companies'] = $this->companyService->showAllCompany( $requestData )->get();
            //$data['courses'] = $this->courseService->showAllCourse($requestData)->get();
            $data['status'] = true;
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            $data['status'] = true;
            $data['message'] = 'Announcement table not found!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AnnouncementRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(AnnouncementRequest $request ): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $data['announcement'] = $this->announcementService->announcement_custom_insert( $request->all() );
            $data['status'] = true;
            $data['message'] = 'Announcement Created successfully';
            DB::commit();
        } catch ( \Exception $e ) {
            DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to create Announcement!';
        }
        return response()->json($data,200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id ): \Illuminate\Http\JsonResponse
    {
        try {
            $data['announcement'] = $this->announcementService->showAnnouncementByID($id);
            $data['status'] = true;
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Announcement data not found!';
        }
        return response()->json($data,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AnnouncementRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(AnnouncementRequest $request, $id ): \Illuminate\Http\JsonResponse
    {
        try {
            $announcement = $this->announcementService->announcement_custom_update($request->all(), $id);
            if ($announcement) {
                $data['announcement'] = $announcement;
                $data['status'] = true;
                $data['message'] = 'An Announcement has been Updated Successfully';
                DB::commit();
            } else {
                DB::rollback();
                $data['status'] = false;
                $data['message'] = 'Failed to update Announcement';
            }
        } catch (Exception $e) {
            DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to update Announcement!!';
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
            $user_get = $this->userService->whoIS($_REQUEST);
            if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
                $announcement = $this->announcementService->showAnnouncementByID($id);
                if ($announcement) {
                    $announcement->delete();
                    $data['status'] = true;
                    $data['message'] = 'An Announcement has been Deleted Successfully';
                }else{
                    DB::rollback();
                    $data['status'] = false;
                    $data['message'] = 'Announcement not found!';
                }
            }else{
                $data['status'] = false;
                $data['message'] = 'You Entered Wrong Password!';
            }
        } catch ( \Exception $e ) {
            DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Announcement not found!!';
        }
        return response()->json($data,200);
    }

}
