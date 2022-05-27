<?php

namespace App\Http\Controllers\Backend\CourseManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\CourseManage\CourseLearnRequest;
use App\Services\Backend\CourseManage\CourseLearnService;
use App\Services\Backend\CourseManage\CourseClassService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CourseLearnController extends Controller
{
    /**
    * @var CourseLearnService
    */
    private $courseLearnService;

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
     * @param CourseLearnService $courseLearnService
     * @param CourseClassService $courseClassService
     * @param CourseService $courseService
     * @param CompanyService $companyService
     * @param UserService $userService
     */
    public function __construct(
        CourseLearnService $courseLearnService,
        CourseClassService $courseClassService,
        CourseService $courseService,
        CompanyService $companyService,
        UserService $userService
    )
    {
        $this->courseLearnService = $courseLearnService;
        $this->courseClassService = $courseClassService;
        $this->courseService = $courseService;
        $this->companyService = $companyService;
        $this->userService = $userService;
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $request['course_learn_by_id'] = isset($request['course_learn_by_id'])?$request['course_learn_by_id']:'DESC';
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $course_learns = $this->courseLearnService->showAllCourseLearn($requestData)->paginate($request->display_item_per_page);
            $courses = $this->courseService->showAllCourse($requestData)->get();
            $course_classes = $this->courseClassService->showAllCourseClass($requestData)->get();
            $companies = $this->companyService->showAllCompany($requestData)->get();
            return view('backend.course.course-learn.index', compact('request', 'courses', 'course_classes', 'course_learns', 'companies'));
        } catch (\Exception $e) {
             flash('Learn table not found!')->error();
             return Redirect::to('/backend');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $course_classes = $this->courseClassService->showAllCourseClass($companyWiseUser)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();

            return view('backend.course.course-learn.create', compact('courses', 'course_classes', 'companies'));
        } catch (\Exception $e) {
            flash('Something wrong with Course Learn Data!')->error();
            return Redirect::to('/backend/course-learns');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseLearnRequest $request)
    {
        try {
            DB::beginTransaction();
            $course_learn = $this->courseLearnService->createCourseLearn($request->except('_wysihtml5_mode', '_token'));
            // dd($course_learn);
            if ($course_learn) {
                flash('Course Learn created successfully')->success();
            } else {
                flash('Failed to create Course Learn')->error();
            }
            DB::commit();
         } catch (\Exception $e) {
            throw  new \Exception($e->getMessage());
             DB::rollback();
             flash('Failed to create Course Learn')->error();
             return redirect()->back()->withInput($request->all());
         }
        return redirect()->route('course-learns.index');
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
            $course_learn = $this->courseLearnService->courseLearnById($id);
            // dd($course_learn);
            return view('backend.course.course-learn.show', compact('course_learn'));
        } catch (\Exception $e) {
            flash('Course Learn data not found!')->error();
            return redirect()->route('course-learns.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $course_learn = $this->courseLearnService->courseLearnById($id);
            $companyWiseUser = $this->userService->user_role_display();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $course_classes = $this->courseClassService->showAllCourseClass($companyWiseUser)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();

            return view('backend.course.course-learn.edit', compact('course_learn', 'courses', 'course_classes', 'companies'));
        } catch (\Exception $e) {
            flash('Course Learn data not found!')->error();
            return redirect()->route('course-learns.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseLearnRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $course_learn = $this->courseLearnService->updateCourseLearn($request->except('_token'), $id);

            if ($course_learn) {
                flash('Course Learn updated successfully')->success();
            } else {
                flash('Failed to update Course Learn')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Course Learn')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('course-learns.index');
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
            $course_learn = $this->courseLearnService->courseLearnById($id);
            if ($course_learn) {
                $course_learn->delete();
                flash('Course Learn deleted successfully')->success();
            }else{
                flash('Course Learn not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('course-learns.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $request['course_learn_by_id'] = isset($request['course_learn_by_id'])?$request['course_learn_by_id']:'DESC';
            $requestData = array_merge($companyWiseUser,$request->all());
            $learns = $this->courseLearnService->showAllCourseLearn($requestData)->get();
            return view('backend.course.course-learn.pdf', compact('learns'));
        } catch (\Exception $e) {
            flash('Learn table not found!')->error();
            return Redirect::to('/backend/course-learns');
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
            $request['course_learn_by_id'] = isset($request['course_learn_by_id'])?$request['course_learn_by_id']:'DESC';
            $requestData = array_merge($companyWiseUser,$request->all());
            $learns = $this->courseLearnService->showAllCourseLearn($requestData)->orderBy('course_learns.id','DESC')->get();
            return view('backend.course.course-learn.excel', compact('learns'));
        } catch (\Exception $e) {
            flash('Learn table not found!')->error();
            return Redirect::to('/backend/course-learns');
        }
    }
}
