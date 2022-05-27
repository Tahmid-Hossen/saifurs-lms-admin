<?php

namespace App\Http\Controllers\Backend\CourseManage;

use App\Http\Controllers\Controller;
use App\Models\Backend\Course\CourseSyllabus;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\CourseManage\CourseSyllabusRequest;
use App\Services\Backend\CourseManage\CourseSyllabusService;
use App\Services\Backend\CourseManage\CourseClassService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CourseSyllabusController extends Controller
{
    /**
    * @var CourseSyllabusService
    */
    private $courseSyllabusService;

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
     * @param CourseSyllabusService $courseSyllabusService
     * @param CourseClassService $courseClassService
     * @param CourseService $courseService
     * @param CompanyService $companyService
     * @param UserService $userService
     */
    public function __construct(
        CourseSyllabusService $courseSyllabusService,
        CourseClassService $courseClassService,
        CourseService $courseService,
        CompanyService $companyService,
        UserService $userService
    )
    {
        $this->courseSyllabusService = $courseSyllabusService;
        $this->courseClassService = $courseClassService;
        $this->courseService = $courseService;
        $this->companyService = $companyService;
        $this->userService = $userService;
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
            $request['course_syllabus_by_id'] = isset($request['course_syllabus_by_id'])?$request['course_syllabus_by_id']:'DESC';
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $companies = $this->companyService->showAllCompany($requestData)->get();
            $course_syllabuses = $this->courseSyllabusService->showAllCourseSyllabus($requestData)->paginate($request->display_item_per_page);
            $courses = $this->courseService->showAllCourse($requestData)->get();
            $course_classes = $this->courseClassService->showAllCourseClass($requestData)->get();
            return view('backend.course.course-syllabus.index', compact('request', 'courses', 'course_classes', 'course_syllabuses', 'companies'));
        } catch (\Exception $e) {
             flash('Syllabus table not found!')->error();
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
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $course_classes = $this->courseClassService->showAllCourseClass($companyWiseUser)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();

            return view('backend.course.course-syllabus.create', compact('courses', 'course_classes', 'companies'));
        } catch (\Exception $e) {
            flash('Something wrong with Syllabus Data!')->error();
            return Redirect::to('/backend/course-syllabuses');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(CourseSyllabusRequest $request)
    {
        $check = CourseSyllabus::where('course_id',$request->course_id)->where('company_id',$request->company_id)->first();
        if ($check){
            flash('Syllabus for this Course Already Exists! You can not create multiple Syllabus for this Course')->error();
            return redirect()->back();
        }
        else {
            try {
                DB::beginTransaction();
                $course_syllabus = $this->courseSyllabusService->createCourseSyllabus($request->except('_wysihtml5_mode', 'syllabus_file', '_token'));
                // dd($course_syllabus);
                if ($course_syllabus) {
                    // Course Syllabus File
                    $request['course_syllabus_id'] = $course_syllabus->id;

                    if ($request->hasFile('syllabus_file')) {
                        $file = $this->courseSyllabusService->courseSyllabusFile($request);
                        // dd($file);
                        $course_syllabus->syllabus_file = $file;
                        $course_syllabus->save();
                    }
                    flash('Syllabus created successfully')->success();
                } else {
                    flash('Failed to create Syllabus')->error();
                }
                DB::commit();
            } catch (\Exception $e) {
                throw  new \Exception($e->getMessage());
                DB::rollback();
                flash('Failed to create Syllabus')->error();
                return redirect()->back()->withInput($request->all());
            }
        }
        return redirect()->route('course-syllabuses.index');
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
            $course_syllabus = $this->courseSyllabusService->courseSyllabusById($id);
            // dd($course_syllabus);
            return view('backend.course.course-syllabus.show', compact('course_syllabus'));
        } catch (\Exception $e) {
            flash('Syllabus data not found!')->error();
            return redirect()->route('course-syllabuses.index');
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
            $course_syllabus = $this->courseSyllabusService->courseSyllabusById($id);
            $companyWiseUser = $this->userService->user_role_display();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $course_classes = $this->courseClassService->showAllCourseClass($companyWiseUser)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();

            return view('backend.course.course-syllabus.edit', compact('course_syllabus', 'courses', 'course_classes', 'companies'));
        } catch (\Exception $e) {
            flash('Course Syllabus data not found!')->error();
            return redirect()->route('course-syllabuses.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(CourseSyllabusRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $course_syllabus = $this->courseSyllabusService->updateCourseSyllabus($request->except('_wysihtml5_mode', 'syllabus_file', '_token'), $id);

            if ($course_syllabus) {
                // Course Syllabus File
                $request['syllabus_id'] = $course_syllabus->id;
                if ($request->hasFile('syllabus_file')) {
                    $file = $course_syllabus->syllabus_file;

                    if(\File::exists(public_path($file))){
                        \File::delete(public_path($file));
                    }

                    $file = $this->courseSyllabusService->courseSyllabusFile($request);
                    $course_syllabus->syllabus_file = $file;
                    $course_syllabus->save();
                }

                flash('Syllabus updated successfully')->success();
            }
            elseif ($course_syllabus == false){
                flash('Syllabus for this Course Already Exists! You can not create multiple Syllabus for this Course.')->error();
                return \redirect()->back();
            }
            else {
                flash('Failed to update Syllabus')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Syllabus')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('course-syllabuses.index');
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
            $course_syllabus = $this->courseSyllabusService->courseSyllabusById($id);
            if ($course_syllabus) {
                $course_syllabus->delete();
                flash('Syllabus deleted successfully')->success();
            }else{
                flash('Syllabus not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('course-syllabuses.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $request['course_syllabus_by_id'] = isset($request['course_syllabus_by_id'])?$request['course_syllabus_by_id']:'DESC';
            $requestData = array_merge($companyWiseUser,$request->all());
            $syllabuses = $this->courseSyllabusService->showAllCourseSyllabus($requestData)->get();
            return view('backend.course.course-syllabus.pdf', compact('syllabuses'));
        } catch (\Exception $e) {
            flash('Syllabus table not found!')->error();
            return Redirect::to('/backend/course-syllabuses');
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
            $request['course_syllabus_by_id'] = isset($request['course_syllabus_by_id'])?$request['course_syllabus_by_id']:'DESC';
            $requestData = array_merge($companyWiseUser,$request->all());
            $syllabuses = $this->courseSyllabusService->showAllCourseSyllabus($requestData)->orderBy('course_syllabuses.id','DESC')->get();
            return view('backend.course.course-syllabus.excel', compact('syllabuses'));
        } catch (\Exception $e) {
            flash('Syllabus table not found!')->error();
            return Redirect::to('/backend/course-syllabuses');
        }
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadFile($id) {
        $course_syllabus = $this->courseSyllabusService->courseSyllabusById($id);
        // dd($course_syllabus);
        $file_path = public_path($course_syllabus->syllabus_file);
        return response()->download($file_path);
    }
}
