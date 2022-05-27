<?php

namespace App\Http\Controllers\Backend\Announcement;

use App\Http\Controllers\Controller;
use App\Models\Backend\Course\Course;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\Course\CourseSubCategoryService;
use App\Services\Backend\Course\CourseChildCategoryService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\Backend\Announcement\AnnouncementService;
use App\Services\UtilityService;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\Announcement\AnnouncementRequest;

class AnnouncementController extends Controller {

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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index( Request $request ) {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:\Utility::$displayRecordPerPage;
            $request['announcement_order_by_date'] = 'asc';
            $request['announcement_order_by_id'] = 'desc';
            $request['announcement_order_by_current_status'] = 'asc';
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge( $companyWiseUser, $request->all() );
            $datas = $this->announcementService->showAllAnnouncement( $requestData )->paginate( $request->display_item_per_page );
            $companies = $this->companyService->showAllCompany( $requestData )->get();
            $courses = $this->courseService->showAllCourse($requestData)->get();
            return View( 'backend.announcement.index', [
                'datas'       => $datas,
                'companies'   => $companies,
                'request'     => $request,
                'courses' => $courses
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Announcement table not found!' )->error();
            return redirect( route( 'announcement.index' ) );
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
            $courses=$this->courseService->showAllCourse($companyWiseUser)->get();
            $course_categories = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();;
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            $course_child_categories = $this->courseChildCategoryService->showAllCourseChildCategory($companyWiseUser)->get();
            return view( 'backend.announcement.create', [
                'course_categories'=>$course_categories,
                'companies'  => $companies,
                'courses'=>$courses,
                'course_categories'=>$course_categories,
                'course_sub_categories'=>$course_sub_categories,
                'course_child_categories'=>$course_child_categories,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Announcement table not found!' )->error();
            return redirect( route( 'announcements.index' ) );
        }
    }

    /**
     * @param AnnouncementRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( AnnouncementRequest $request ) {
        try {
            $this->announcementService->announcement_custom_insert( $request->all() );
            flash('Announcement Created successfully')->success();
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash('Failed to create Announcement!', 'error');
            return back()->withInput($request->all());
        }
        return redirect(route('announcements.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show( $id ) {
        try {
            $announcement = $this->announcementService->showAnnouncementByID($id);
            return view('backend.announcement.show', [
                'announcement' => $announcement
            ]);
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            flash('Announcement data not found!')->error();
            return redirect(route('announcements.index'));
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
            $announcement = $this->announcementService->showAnnouncementByID($id);
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $course_categories = $this-> courseCategoryService -> showAllCourseCategory($companyWiseUser)->get();
            return view('backend.announcement.edit', [
                'announcement'=>$announcement,
                'companies'=>$companies,
                'branches'=>$branches,
                'courses'=>$courses,
                'course_categories'=>$course_categories
            ]);
        } catch (\Exception $e) {
            \Log::error( $e->getMessage() );
            flash('Announcement data not found!')->error();
            return redirect(route('announcements.index'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AnnouncementRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update( AnnouncementRequest $request, $id ) {
        try {
            $announcement = $this->announcementService->announcement_custom_update($request->all(), $id);
            if ($announcement) {
                flash('An Anouncement has been Updated Successfully')->success();
            } else {
                flash('Failed to update Announcement')->error();
            }
        } catch (Exception $e) {
            \Log::error( $e->getMessage() );
            flash('Failed to update Announcement')->error();
            return back()->withInput($request->all());
        }
        return redirect(route('announcements.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy( $id ) {
        $user_get = $this->userService->whoIS($_REQUEST);
        if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
            $announcement = $this->announcementService->showAnnouncementByID($id);
            if ($announcement) {
                $announcement->delete();
                flash('An Anouncement has been Deleted Successfully')->success();
            }else{
                flash('Announcement not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect(route('announcements.index'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function pdf( Request $request ) {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $announcements = $this->announcementService->showAllAnnouncement( $requestData )->get();
            return View( 'backend.announcement.pdf', [
                'datas'   => $announcements
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Announcements table not found!' )->error();
            return redirect( route( 'announcements.index' ) );
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function excel( Request $request ) {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $announcements = $this->announcementService->showAllAnnouncement( $requestData )->get();
            return View( 'backend.announcement.excel', [
                'datas'   => $announcements
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Announcements table not found!' )->error();
            return redirect( route( 'announcements.index' ) );
        }
    }

    public function getAnnouncementList(Request $request): \Illuminate\Http\JsonResponse
    {
        $companyWiseUser = $this->userService->user_role_display();
        // $request['course_chapter_by_id'] = isset($request['course_chapter_by_id'])?$request['course_chapter_by_id']:'DESC';
        $requestData = array_merge($companyWiseUser,$request->all());
        $announcementList = $this->announcementService->showAllAnnouncement($requestData)->get();
        if(count($announcementList)>0):
            $message = response()->json(['status' => 200, 'data'=>$announcementList]);
        else:
            $message = response()->json(['status' => 404, 'message'=>'Data fot found']);
        endif;
        return $message;
    }
}
