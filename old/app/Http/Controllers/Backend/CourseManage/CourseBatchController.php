<?php

namespace App\Http\Controllers\Backend\CourseManage;

use App\Http\Controllers\Controller;
use App\Services\Backend\CourseManage\CourseBatchService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CourseBatchController extends Controller
{
    /**
     * @var CourseBatchService
     */
    private $courseBatchService;
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
     * CourseBatchController constructor.
     * @param CourseBatchService $courseBatchService
     * @param UserService $userService
     * @param CompanyService $companyService
     * @param CourseService $courseService
     */
    public function __construct(
        CourseBatchService $courseBatchService,
        UserService $userService,
        CompanyService $companyService,
        CourseService $courseService
    )
    {
        $this->middleware('auth');
        $this->courseBatchService = $courseBatchService;
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
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $request['course_batch_order_by_id'] = isset($request['course_batch_order_by_id'])?$request['course_batch_order_by_id']:'DESC';
            $requestData = array_merge($companyWiseUser,$request->all());
            $courseBatches = $this->courseBatchService->showAllCourseBatch($requestData)->paginate($request->display_item_per_page);
            return view(
                'backend.course.course-batches.index',
                compact('courseBatches', 'request', 'companies', 'courses'));
        } catch (\Exception $e) {
            flash('Course Batch table not found!')->error();
            return Redirect::to('/backend');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            return view('backend.course.course-batches.create', compact('companies', 'courses'));
        } catch (\Exception $e) {
            flash('Something wrong with Course Batch Data!')->error();
            return Redirect::to('/backend/course-batches');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $course = $this->courseService->courseById($request->course_id);
            $courseBatch = $this->courseBatchService->createCourseBatch($request->except('course_batch_logo', 'student_id', '_token'), $course);
            if ($courseBatch) {
                // Course Batch Logo
                $request['course_batch_id'] = $courseBatch->id;
                $this->courseBatchService->assignCourseBatchToStudent($request->all());
                if ($request->hasFile('course_batch_logo')) {
                    $image_url = $this->courseBatchService->courseBatchLogo($request);
                    $courseBatch->course_batch_logo = $image_url;
                    $courseBatch->save();
                    flash('Course Batch created successfully')->success();
                }
            } else {
                flash('Failed to create Course Batch')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to create Course Batch')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('course-batches.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $courseBatch = $this->courseBatchService->courseBatchById($id);
            $students = $courseBatch->student;
            return view('backend.course.course-batches.show', compact('courseBatch', 'students'));
        } catch (\Exception $e) {
            flash('Course Batch data not found!')->error();
            return redirect()->route('course-batches.index');
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
            $courseBatch = $this->courseBatchService->courseBatchById($id);
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            return view('backend.course.course-batches.edit', compact('courseBatch', 'companies', 'courses'));
        } catch (\Exception $e) {
            flash('Course Batch data not found!')->error();
            return redirect()->route('course-batches.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $courseBatch = $this->courseBatchService->updateCourseBatch($request->except('course_batch_logo', 'student_id', '_token'), $id, $c_name = null, $c_b_name = null);
            if ($courseBatch) {
                // Course Batch Logo
                $request['course_batch_id'] = $courseBatch->id;
                $this->courseBatchService->assignCourseBatchToStudent($request->all());
                if ($request->hasFile('course_batch_logo')) {
                    $image_url = $this->courseBatchService->courseBatchLogo($request);
                    $courseBatch->course_batch_logo = $image_url;
                    $courseBatch->save();
                    flash('Course Batch update successfully')->success();
                }

                flash('Course Batch update successfully')->success();
            } else {
                flash('Failed to update Course Batch')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Course Batch')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('course-batches.index');
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
            $courseBatch = $this->courseBatchService->courseBatchById($id);
            if ($courseBatch) {
                $courseBatch->delete();
                flash('Course Batch deleted successfully')->success();
            }else{
                flash('Course Batch not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('course-batches.index');
    }

    /**
     * @param $id
     * @return array|false|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|mixed
     */
    public function courseBatchStudentList($id)
    {
        try {
            $courseBatch = $this->courseBatchService->courseBatchById($id);
            $students = $courseBatch->student;
            return view('backend.course.course-batches.course-batch-student-list', compact('students'));
        } catch (\Exception $e) {
            flash('Course Batch data not found!')->error();
            return redirect()->route('course-batches.index');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function courseBatchList(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $request['course_batch_order_by_id'] = isset($request['course_batch_order_by_id'])?$request['course_batch_order_by_id']:'DESC';
            $requestData = array_merge($companyWiseUser,$request->all());
            $courseBatches = $this->courseBatchService->showAllCourseBatch($requestData)->get();
            if (count($courseBatches) > 0):
                $message = response()->json(['status' => 200, 'data' => $courseBatches]);
            else:
                $message = response()->json(['status' => 200, 'message' => 'Data not Found']);
            endif;
        } catch (\Exception $e) {
            $message = response()->json(['status' => 404, 'message' => 'Course Batch data not found!']);
        }
        return $message;
    }
}
