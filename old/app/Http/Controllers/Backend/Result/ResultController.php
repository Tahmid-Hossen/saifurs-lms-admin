<?php

namespace App\Http\Controllers\Backend\Result;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\Result\ResultRequest;
use App\Services\Backend\Result\ResultService;
use App\Services\Backend\Quiz\QuizService;
use App\Services\Backend\CourseManage\CourseBatchService;
use App\Services\Backend\CourseManage\CourseClassService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ResultController extends Controller
{
    /**
     * @var ResultService
     */
    private $resultService;

    /**
     * @var QuizService
     */
    private $quizService;

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
     * @param ResultService $resultService
     * @param QuizService $quizService
     * @param CourseBatchService $courseBatchService
     * @param CourseClassService $courseClassService
     * @param CourseService $courseService
     * @param CompanyService $companyService
     * @param UserService $userService
     */
    public function __construct(
        ResultService $resultService,
        QuizService $quizService,
        CourseBatchService $courseBatchService,
        CourseClassService $courseClassService,
        CourseService $courseService,
        CompanyService $companyService,
        UserService $userService
    )
    {
        $this->resultService = $resultService;
        $this->quizService = $quizService;
        $this->courseBatchService = $courseBatchService;
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
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $results = $this->resultService->showAllResult($requestData)->paginate($request->display_item_per_page);
            $companies = $this->companyService->showAllCompany($requestData)->get();
            $courses = $this->courseService->showAllCourse($requestData)->get();
            $course_batches = $this->courseBatchService->showAllCourseBatch($requestData)->get();
            $quizzes = $this->quizService->showAllQuiz($requestData)->get();
            $filters = $request->all();
            $users = $this->userService->getAllUser($filters);
            $course_classes = $this->courseClassService->showAllCourseClass($requestData)->get();
            return view('backend.result.index',
                compact('request', 'courses', 'course_classes', 'results', 'companies', 'course_batches', 'quizzes'));
        } catch (\Exception $e) {
            flash('Result table not found!')->error();
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
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $course_batches = $this->courseBatchService->showAllCourseBatch($companyWiseUser)->get();
            $quizzes = $this->quizService->showAllQuiz($companyWiseUser)->get();
            $course_classes = $this->courseClassService->showAllCourseClass($companyWiseUser)->get();
            $users = $this->userService->showAllUser($companyWiseUser)->whereHas('roles', function ($query) {
                $query->whereIn('name', ['Student']);
            })->get();

            return view('backend.result.create',
                compact('courses', 'course_classes', 'companies', 'course_batches', 'quizzes', 'users'));
        } catch (\Exception $e) {
            flash('Something wrong with Result Data!')->error();
            return Redirect::to('/backend/results');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResultRequest $request)
    {
        try {
            DB::beginTransaction();
            $result = $this->resultService->customResultStore($request->except('_token'));
            // dd($result);
            if ($result) {
                flash('Result created successfully')->success();
            } else {
                flash('Failed to create Result')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to create Result')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('results.index');
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
            $result = $this->resultService->resultById($id);
            // dd($result);
            return view('backend.result.show', compact('result'));
        } catch (\Exception $e) {
            flash('Result data not found!')->error();
            return redirect()->route('results.index');
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
            $result = $this->resultService->resultById($id);
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $course_batches = $this->courseBatchService->showAllCourseBatch($companyWiseUser)->get();
            $quizzes = $this->quizService->showAllQuiz($companyWiseUser)->get();
            $course_classes = $this->courseClassService->showAllCourseClass($companyWiseUser)->get();
            $users = $this->userService->showAllUser($companyWiseUser)->whereHas('roles', function ($query) {
                $query->whereIn('name', ['Student']);
            })->get();

            return view('backend.result.edit',
                compact('result', 'companies', 'courses', 'course_batches', 'quizzes', 'course_classes', 'users'));
        } catch (\Exception $e) {
            flash('Result data not found!')->error();
            return redirect()->route('results.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResultRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $result = $this->resultService->updateResult($request->except('_token'), $id);

            if ($result) {
                flash('Result updated successfully')->success();
            } else {
                flash('Failed to update Result')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Result')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('results.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
            $result = $this->resultService->resultById($id);
            if ($result) {
                $result->delete();
                flash('Result deleted successfully')->success();
            }else{
                flash('Result not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('results.index');
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
            $results = $this->resultService->showAllResult($requestData)->get();
            return view('backend.result.pdf', compact('results'));
        } catch (\Exception $e) {
            flash('Result table not found!')->error();
            return Redirect::to('/backend/results');
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
            $results = $this->resultService->showAllResult($requestData)->orderBy('results.id','DESC')->get();
            return view('backend.result.excel', compact('results'));
        } catch (\Exception $e) {
            flash('Result table not found!')->error();
            return Redirect::to('/backend/results');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function print($id)
    {
        try {
            $result = $this->resultService->resultById($id);
            // dd($result);
            return view('backend.result.print', compact('result'));
        } catch (\Exception $e) {
            flash('Result table not found!')->error();
            return Redirect::to('/backend/results');
        }
    }
}
