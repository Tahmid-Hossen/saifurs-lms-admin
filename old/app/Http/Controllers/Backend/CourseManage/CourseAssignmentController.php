<?php

namespace App\Http\Controllers\Backend\CourseManage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CourseManage\CourseAssignmentRequest;
use App\Services\Backend\CourseManage\CourseAssignmentService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CourseAssignmentController extends Controller
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
        $this->middleware('auth');
        $this->courseAssignmentService = $courseAssignmentService;
        $this->userService = $userService;
        $this->companyService = $companyService;
        $this->courseService = $courseService;
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
            $request['course_assignment_order_by_id'] = isset($request['course_assignment_order_by_id'])?$request['course_assignment_order_by_id']:'DESC';
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $courseAssignments = $this->courseAssignmentService->showAllCourseAssignment($requestData)->paginate($request->display_item_per_page);
            $companies = $this->companyService->showAllCompany($requestData)->get();
            $courses = $this->courseService->showAllCourse($requestData)->get();
            return view(
                'backend.course.course-assignments.index',
                compact('courseAssignments', 'request', 'companies', 'courses'));
        } catch (\Exception $e) {
            flash('Course Assignment table not found!')->error();
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
            return view('backend.course.course-assignments.create', compact('companies', 'courses'));
        } catch (\Exception $e) {
            flash('Something wrong with Course Assignment Data!')->error();
            return Redirect::to('/backend/course-assignments');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(CourseAssignmentRequest $request)
    {
        try {
            DB::beginTransaction();
            $courseAssignment = $this->courseAssignmentService->createCourseAssignment($request->except('course_assignment_document', '_token'));
            if ($courseAssignment) {
                // Course Assignment Document
                $request['course_assignment_id'] = $courseAssignment->id;
                if ($request->hasFile('course_assignment_document')) {
                    $image_url = $this->courseAssignmentService->courseAssignmentLogo($request);
                    $courseAssignment->course_assignment_document = $image_url;
                    $courseAssignment->save();
                    flash('Assignment submitted successfully')->success();
                }
            } else {
                flash('Assignment submission failed')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to create Course Assignment')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('course-assignments.index');
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
            $courseAssignment = $this->courseAssignmentService->courseAssignmentById($id);
            return view('backend.course.course-assignments.show', compact('courseAssignment'));
        } catch (\Exception $e) {
            flash('Course Assignment data not found!')->error();
            return redirect()->route('course-assignments.index');
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
            $courseAssignment = $this->courseAssignmentService->courseAssignmentById($id);
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            return view('backend.course.course-assignments.edit', compact('courseAssignment', 'companies', 'courses'));
        } catch (\Exception $e) {
            flash('Course Assignment data not found!')->error();
            return redirect()->route('course-assignments.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CourseAssignmentRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(CourseAssignmentRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $courseAssignment = $this->courseAssignmentService->updateCourseAssignment($request->except('course_assignment_document', '_token'), $id);
            if ($courseAssignment) {
                // Course Assignment Document
                $request['course_assignment_id'] = $courseAssignment->id;
                if ($request->hasFile('course_assignment_document')) {
                    $image_url = $this->courseAssignmentService->courseAssignmentLogo($request);
                    $courseAssignment->course_assignment_document = $image_url;
                    $courseAssignment->save();
                    flash('Course Assignment created successfully')->success();
                }

                flash('Course Assignment update successfully')->success();
            } else {
                flash('Failed to update Course Assignment')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Course Assignment')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('course-assignments.index');
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
            $courseAssignment = $this->courseAssignmentService->courseAssignmentById($id);
            if ($courseAssignment) {
                $courseAssignment->delete();
                flash('Course Assignment deleted successfully')->success();
            }else{
                flash('Course Assignment not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('course-assignments.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $request['course_assignment_order_by_id'] = isset($request['course_assignment_order_by_id'])?$request['course_assignment_order_by_id']:'DESC';
            $requestData = array_merge($companyWiseUser,$request->all());
            $courseAssignments = $this->courseAssignmentService->showAllCourseAssignment($requestData)->orderBy('course_assignments.id','DESC')->get();
            return view('backend.course.course-assignments.pdf', compact('courseAssignments'));
        } catch (\Exception $e) {
            flash('Course Assignment table not found!')->error();
            return Redirect::to('/backend/course-assignments');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function excel(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $request['course_assignment_order_by_id'] = isset($request['course_assignment_order_by_id'])?$request['course_assignment_order_by_id']:'DESC';
            $requestData = array_merge($companyWiseUser,$request->all());
            $courseAssignments = $this->courseAssignmentService->showAllCourseAssignment($requestData)->orderBy('course_assignments.id','DESC')->get();
            return view('backend.course.course-assignments.excel', compact('courseAssignments'));
        } catch (\Exception $e) {
            flash('Course Assignment table not found!')->error();
            return Redirect::to('/backend/course-assignments');
        }
    }

    /**
     * @param $id
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|mixed
     */
    public function assignmentReview($id)
    {
        try {
            $courseAssignment = $this->courseAssignmentService->courseAssignmentById($id);
            return view('backend.course.course-assignments.assignment-review', compact('courseAssignment'));
        } catch (\Exception $e) {
            flash('Course Assignment data not found!')->error();
            return redirect()->route('course-assignments.index');
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function updateReview(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $courseAssignment = $this->courseAssignmentService->updateCourseAssignment($request->except('course_assignment_document', '_token'), $id);
            if ($courseAssignment) {
                // Course Assignment Document
                $request['course_assignment_id'] = $courseAssignment->id;
                if ($request->hasFile('course_assignment_document')) {
                    $image_url = $this->courseAssignmentService->courseAssignmentLogo($request);
                    $courseAssignment->course_assignment_document = $image_url;
                    $courseAssignment->save();
                    flash('Course Assignment created successfully')->success();
                }

                flash('Course Assignment update successfully')->success();
            } else {
                flash('Failed to update Course Assignment')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Course Assignment')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('course-assignments.index');
    }

    public function assignmentMarkedAsRead($id)
    {
        try {
            $user = Auth::user();
            $notification = $user->notifications->find($id);
            $notification->markAsRead();
            $assignment_id = $notification->data['id'];
            return redirect(route('course-assignments.show', $assignment_id));
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            flash('Notification Not Found', 'error');
            return redirect(back('course-assignments.index'));
        }

    }
}
