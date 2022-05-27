<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class VendorMeetingController extends Controller
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
     *
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            $vendors = $this->vendorService->ShowAllVendor($companyWiseUser)->get();
            $courseBatches = $this->courseBatchService->showAllCourseBatch($companyWiseUser)->get();
            $courseChapters = $this->courseChapterService->showAllCourseChapter($companyWiseUser)->get();
            $courseClasses = $this->courseClassService->showAllCourseClass($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $instructors = $this->userDetailsService->userDetails(array_merge(array('role_id_in'=>array(6,8)),$companyWiseUser))->get();
            $requestData = array_merge($companyWiseUser,$request->all());
            $vendorMeetings = $this->vendorMeetingService->ShowAllVendorMeeting($requestData)->paginate($request->display_item_per_page);
            return view(
                'backend.setting.vendor-meetings.index',
                compact(
                    'vendorMeetings', 'request','companies', 'branches', 'vendors', 'courseBatches',
                    'courseChapters', 'courseClasses', 'courses', 'instructors'
                )
            );
        } catch (\Exception $e) {
            flash('Vendor Meeting table not found!')->error();
            return Redirect::to('/backend');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $courseBatches = $this->courseBatchService->showAllCourseBatch($companyWiseUser)->get();
            $vendors = $this->vendorService->ShowAllVendor($companyWiseUser)->get();
            return view('backend.setting.vendor-meetings.create', compact('companies', 'courses', 'vendors', 'courseBatches'));
        } catch (\Exception $e) {
            flash('Something wrong with Vendor Meeting Data!')->error();
            return Redirect::to('/vendor-meetings');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $vendorMeeting = $this->vendorMeetingService->storeVendorMeeting($request->all());
            if ($vendorMeeting) {
                // Vendor Meeting Logo
                $request['vendor_meeting_id'] = $vendorMeeting->id;
                if ($request->hasFile('vendor_meeting_logo')) {
                    $image_url = $this->vendorMeetingService->vendorMeetingLogo($request);
                    $vendorMeeting->vendor_meeting_logo = $image_url;
                    $vendorMeeting->save();
                }
                flash('Vendor Meeting created successfully')->success();
            } else {
                flash('Failed to create Vendor Meeting')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to create Vendor Meeting')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('vendor-meetings.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $vendorMeeting = $this->vendorMeetingService->showVendorMeetingByID($id);
            return view('backend.setting.vendor-meetings.show', compact('vendorMeeting'));
        } catch (\Exception $e) {
            flash('Vendor Meeting data not found!')->error();
            return redirect()->route('vendor-meetings.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $vendorMeeting = $this->vendorMeetingService->showVendorMeetingByID($id);
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $courseBatches = $this->courseBatchService->showAllCourseBatch($companyWiseUser)->get();
            $vendors = $this->vendorService->ShowAllVendor($companyWiseUser)->get();
            return view('backend.setting.vendor-meetings.edit', compact('vendorMeeting', 'companies', 'courses', 'courseBatches', 'vendors'));
        } catch (\Exception $e) {
            flash('Vendor Meeting data not found!')->error();
            return redirect()->route('vendor-meetings.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $vendorMeetingUpdate = $this->vendorMeetingService->updateVendorMeeting($request->all(), $id);
            if ($vendorMeetingUpdate) {
                // Vendor Meeting Logo
                $request['vendor_meeting_id'] = $vendorMeetingUpdate->id;
                if ($request->hasFile('vendor_meeting_logo')) {
                    $image_url = $this->vendorMeetingService->vendorMeetingLogo($request);
                    $vendorMeetingUpdate->vendor_meeting_logo = $image_url;
                    $vendorMeetingUpdate->save();
                }
                flash('Vendor Meeting updated successfully')->success();
            } else {
                flash('Failed to updated Vendor Meeting')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to updated Vendor Meeting')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('vendor-meetings.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
            $vendor = $this->vendorMeetingService->showVendorMeetingByID($id);
            if ($vendor) {
                $vendor->delete();
                flash('Vendor Meeting deleted successfully')->success();
            }else{
                flash('Vendor Meeting not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('vendor-meetings.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|mixed
     */
    public function pdf(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $vendorMeetings = $this->vendorMeetingService->ShowAllVendorMeeting($requestData)->get();
            return view('backend.setting.vendor-meetings.pdf', compact('vendorMeetings'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Vendor Meeting table not found!')->error();
            return Redirect::to('/backend');
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|mixed
     */
    public function excel(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $vendorMeetings = $this->vendorMeetingService->ShowAllVendorMeeting($requestData)->get();
            return view('backend.setting.vendor-meetings.excel', compact('vendorMeetings'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Vendor Meeting table not found!')->error();
            return Redirect::to('/backend');
        }
    }
}
