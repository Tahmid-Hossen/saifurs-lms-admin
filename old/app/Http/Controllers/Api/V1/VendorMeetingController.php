<?php

namespace App\Http\Controllers\Api\V1;

use App\Services\Backend\CourseManage\CourseBatchService;
use App\Services\Backend\CourseManage\CourseChapterService;
use App\Services\Backend\CourseManage\CourseClassService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\Setting\VendorMeetingService;
use App\Services\Backend\Setting\VendorService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserDetailsService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Illuminate\Http\Request;

class VendorMeetingController
{
    /**
     * @var VendorMeetingService
     */
    private $vendorMeetingService;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var CourseService
     */
    private $courseService;
    /**
     * @var CourseClassService
     */
    private $courseClassService;
    /**
     * @var CourseChapterService
     */
    private $courseChapterService;
    /**
     * @var CourseBatchService
     */
    private $courseBatchService;
    /**
     * @var VendorService
     */
    private $vendorService;
    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var BranchService
     */
    private $branchService;
    /**
     * @var UserDetailsService
     */
    private $userDetailsService;

    /**
     * VendorMeetingController constructor.
     * @param VendorMeetingService $vendorMeetingService
     * @param UserService $userService
     * @param CourseService $courseService
     * @param CourseClassService $courseClassService
     * @param CourseChapterService $courseChapterService
     * @param CourseBatchService $courseBatchService
     * @param VendorService $vendorService
     * @param CompanyService $companyService
     * @param BranchService $branchService
     * @param UserDetailsService $userDetailsService
     */
    public function __construct(
        VendorMeetingService $vendorMeetingService,
        UserService $userService,
        CourseService $courseService,
        CourseClassService $courseClassService,
        CourseChapterService $courseChapterService,
        CourseBatchService $courseBatchService,
        VendorService $vendorService,
        CompanyService $companyService,
        BranchService $branchService,
        UserDetailsService $userDetailsService
    )
    {
        $this->vendorMeetingService = $vendorMeetingService;
        $this->userService = $userService;
        $this->courseService = $courseService;
        $this->courseClassService = $courseClassService;
        $this->courseChapterService = $courseChapterService;
        $this->courseBatchService = $courseBatchService;
        $this->vendorService = $vendorService;
        $this->companyService = $companyService;
        $this->branchService = $branchService;
        $this->userDetailsService = $userDetailsService;
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
            $request['vendor_meeting_status'] = Constants::$user_active_status;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            //$data['companies'] = $this->companyService->showAllCompany($companyWiseUser)->get();
            //$data['branches'] = $this->branchService->showAllBranch($companyWiseUser)->get();
            //$data['vendors'] = $this->vendorService->ShowAllVendor($companyWiseUser)->get();
            //$data['courseBatches'] = $this->courseBatchService->showAllCourseBatch($companyWiseUser)->get();
            //$data['courseChapters'] = $this->courseChapterService->showAllCourseChapter($companyWiseUser)->get();
            //$data['courseClasses'] = $this->courseClassService->showAllCourseClass($companyWiseUser)->get();
            //$data['courses'] = $this->courseService->showAllCourse($companyWiseUser)->get();
            //$data['instructors'] = $this->userDetailsService->userDetails(array_merge(array('role_id_in'=>array(6,8)),$companyWiseUser))->get();
            $requestData = array_merge($companyWiseUser,$request->all());
            $data['vendorMeetings'] = $this->vendorMeetingService->ShowAllVendorMeeting($requestData)->paginate($request->display_item_per_page);
            $data['status'] = true;
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            $data['status'] = true;
            $data['message'] = 'Vendor Meeting table not found!!';
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
            $vendorMeeting = $this->vendorMeetingService->storeVendorMeeting($request->all());
            if ($vendorMeeting) {
                // Vendor Meeting Logo
                $request['vendor_meeting_id'] = $vendorMeeting->id;
                if ($request->hasFile('vendor_meeting_logo')) {
                    $image_url = $this->vendorMeetingService->vendorMeetingLogo($request);
                    $vendorMeeting->vendor_meeting_logo = $image_url;
                    $vendorMeeting->save();
                }
                $data['vendorMeeting'] = $vendorMeeting;
                $data['status'] = true;
                $data['message'] = 'Vendor Meeting created successfully';
            } else {
                \DB::rollback();
                $data['status'] = false;
                $data['message'] = 'Failed to create Vendor Meeting!';
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to create Vendor Meeting!!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $vendorMeeting = $this->vendorMeetingService->showVendorMeetingByID($id);
            $data['vendorMeeting'] = $vendorMeeting;
            $vendorMeeting->vendor_meeting_logo = $vendorMeeting->vendor_meeting_logo_full_path;
            $data['status'] = true;
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Vendor Meeting data not found!!';
        }
        return response()->json($data,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            \DB::beginTransaction();
            $vendorMeetingUpdate = $this->vendorMeetingService->updateVendorMeeting($request->all(), $id);
            if ($vendorMeetingUpdate) {
                // Vendor Meeting Logo
                $request['vendor_meeting_id'] = $vendorMeetingUpdate->id;
                if ($request->hasFile('vendor_meeting_logo')) {
                    $image_url = $this->vendorMeetingService->vendorMeetingLogo($request);
                    $vendorMeetingUpdate->vendor_meeting_logo = $image_url;
                    $vendorMeetingUpdate->save();
                }
                $data['vendorMeetingUpdate'] = $vendorMeetingUpdate;
                $data['status'] = true;
                $data['message'] = 'Vendor Meeting updated successfully';
            } else {
                \DB::rollback();
                $data['status'] = false;
                $data['message'] = 'Failed to updated Vendor Meeting';
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error( $e->getMessage() );
            $data['status'] = false;
            $data['message'] = 'Failed to updated Vendor Meeting!!';
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
                $vendor = $this->vendorMeetingService->showVendorMeetingByID($id);
                if ($vendor) {
                    $vendor->delete();
                    $data['status'] = true;
                    $data['message'] = 'Vendor Meeting deleted successfully';
                }else{
                    \DB::rollback();
                    $data['status'] = false;
                    $data['message'] = 'Vendor Meeting not found!';
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
            $data['message'] = 'Vendor Meeting not found!!';
        }
        return response()->json($data,200);
    }
}
