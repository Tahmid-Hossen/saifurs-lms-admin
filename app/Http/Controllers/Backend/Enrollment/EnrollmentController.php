<?php

namespace App\Http\Controllers\Backend\Enrollment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\Enrollment\EnrollmentRequest;
use App\Services\Backend\Enrollment\EnrollmentService;
use App\Services\Backend\CourseManage\CourseBatchService;
use App\Services\Backend\CourseManage\CourseClassService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class EnrollmentController extends Controller
{
    /**
     * @var EnrollmentService
     */
    private $enrollmentService;

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
     * @param EnrollmentService $enrollmentService
     * @param CourseBatchService $courseBatchService
     * @param CourseClassService $courseClassService
     * @param CourseService $courseService
     * @param CompanyService $companyService
     * @param UserService $userService
     */
    public function __construct(
        EnrollmentService $enrollmentService,
        CourseBatchService $courseBatchService,
        CourseClassService $courseClassService,
        CourseService $courseService,
        CompanyService $companyService,
        UserService $userService
    )
    {
        $this->enrollmentService = $enrollmentService;
        $this->courseBatchService = $courseBatchService;
        $this->courseClassService = $courseClassService;
        $this->courseService = $courseService;
        $this->companyService = $companyService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $enrollments = $this->enrollmentService->showAllEnrollment($requestData)->paginate($request->display_item_per_page);
            $companies = $this->companyService->showAllCompany($requestData)->get();
            $courses = $this->courseService->showAllCourse($requestData)->get();
            $course_batches = $this->courseBatchService->showAllCourseBatch($requestData)->get();
            // $users = $this->userService->showAllUser($requestData)->get();
            $filters = $request->all();
            $users = $this->userService->getAllUser($filters);
            $course_classes = $this->courseClassService->showAllCourseClass($requestData)->get();
            return view('backend.enrollment.index',
                compact('request', 'courses', 'course_classes', 'enrollments', 'companies', 'course_batches'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Enrollment table not found!')->error();
            return Redirect::to('/backend');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $course_batches = $this->courseBatchService->showAllCourseBatch($companyWiseUser)->get();
            // $users = $this->userService->showAllUser($requestData)->get();
            $users = $this->userService->showAllUser($companyWiseUser)->whereHas('roles', function ($query) {
                $query->whereIn('name', ['Student']);
            })->get();
            $course_classes = $this->courseClassService->showAllCourseClass($companyWiseUser)->get();

            return view('backend.enrollment.create',
                compact('courses', 'course_classes', 'companies', 'course_batches', 'users'));
        } catch (\Exception $e) {
            flash('Something wrong with Enrollment Data!')->error();
            return Redirect::to('/backend/enrollments');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     * @throws \Throwable
     */
    public function store(EnrollmentRequest $request)
    {
        try {
            DB::beginTransaction();
            $enrollment = $this->enrollmentService->createEnrollment($request->except(['_token', 'branch_id']));
            if ($enrollment) {
                flash('Enrollment created successfully')->success();
            } else {
                flash('Failed to create Enrollment')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to create Enrollment')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('enrollments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $enrollment = $this->enrollmentService->enrollmentById($id);
            // dd($enrollment);
            return view('backend.enrollment.show', compact('enrollment'));
        } catch (\Exception $e) {
            flash('Enrollment data not found!')->error();
            return redirect()->route('enrollments.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        try {
            $enrollment = $this->enrollmentService->enrollmentById($id);
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $course_batches = $this->courseBatchService->showAllCourseBatch($companyWiseUser)->get();
            // $users = $this->userService->showAllUser($requestData)->get();
            $users = $this->userService->showAllUser($companyWiseUser)->whereHas('roles', function ($query) {
                $query->whereIn('name', ['Instructor', 'Student']);
            })->get();
            $course_classes = $this->courseClassService->showAllCourseClass($companyWiseUser)->get();

            return view('backend.enrollment.edit',
                compact('enrollment', 'companies', 'courses', 'course_batches', 'users', 'course_classes'));
        } catch (\Exception $e) {
            flash('Enrollment data not found!')->error();
            return redirect()->route('enrollments.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(EnrollmentRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $enrollment = $this->enrollmentService->updateEnrollment($request->except('_token'), $id);

            if ($enrollment) {
                flash('Enrollment updated successfully')->success();
            } else {
                flash('Failed to update Enrollment')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Enrollment')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('enrollments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
            $enrollment = $this->enrollmentService->enrollmentById($id);
            if ($enrollment) {
                $enrollment->delete();
                flash('Enrollment deleted successfully')->success();
            }else{
                flash('Enrollment not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('enrollments.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $enrollments = $this->enrollmentService->showAllEnrollment($requestData)->get();
            return view('backend.enrollment.pdf', compact('enrollments'));
        } catch (\Exception $e) {
            flash('Enrollment table not found!')->error();
            return Redirect::to('/backend/enrollments');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function excel(Request $request)
    {
        // dd($request);
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $enrollments = $this->enrollmentService->showAllEnrollment($requestData)->orderBy('enrollments.id','DESC')->get();
            return view('backend.enrollment.excel', compact('enrollments'));
        } catch (\Exception $e) {
            flash('Enrollment table not found!')->error();
            return Redirect::to('/backend/enrollments');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function print($id)
    {
        try {
            $enrollment = $this->enrollmentService->enrollmentById($id);
            // dd($enrollment);
            return view('backend.enrollment.print', compact('enrollment'));
        } catch (\Exception $e) {
            flash('Enrollment table not found!')->error();
            return Redirect::to('/backend/enrollments');
        }
    }
}
