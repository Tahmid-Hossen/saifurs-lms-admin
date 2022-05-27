<?php

namespace App\Http\Controllers\Backend\CourseManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\CourseManage\CourseQuestionAnswerRequest;
use App\Services\Backend\CourseManage\CourseQuestionAnswerService;
use App\Services\Backend\CourseManage\CourseQuestionService;
use App\Services\Backend\User\UserService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\CourseManage\CourseClassService;
use App\Services\Backend\CourseManage\CourseChapterService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CourseQuestionAnswerController extends Controller
{
    /**
    * @var CourseQuestionAnswerService
    */
    private $courseQuestionAnswerService;

    /**
    * @var CourseQuestionService
    */
    private $courseQuestionService;

    /**
    * @var CourseClassService
    */
    private $courseClassService;

    /**
    * @var CourseChapterService
    */
    private $courseChapterService;

    /**
    * @var CourseService
    */
    private $courseService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * @param CourseQuestionAnswerService $courseQuestionAnswerService
     * @param CourseQuestionService $courseQuestionService
     * @param CourseClassService $courseClassService
     * @param CourseChapterService $courseChapterService
     * @param CourseService $courseService
     * @param UserService $userService
     * @param CompanyService $companyService
     */
    public function __construct(
        CourseQuestionAnswerService $courseQuestionAnswerService,
        CourseQuestionService $courseQuestionService,
        CourseClassService $courseClassService,
        CourseChapterService $courseChapterService,
        CourseService $courseService,
        UserService $userService,
        CompanyService $companyService
    )
    {
        $this->courseQuestionAnswerService = $courseQuestionAnswerService;
        $this->courseQuestionService = $courseQuestionService;
        $this->courseClassService = $courseClassService;
        $this->courseChapterService = $courseChapterService;
        $this->courseService = $courseService;
        $this->userService = $userService;
        $this->companyService = $companyService;
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
            $companies = $this->companyService->showAllCompany($requestData)->get();
            $courses = $this->courseService->showAllCourse($requestData)->get();
            $question_answers = $this->courseQuestionAnswerService->showAllCourseQuestionAnswer($requestData)->paginate($request->display_item_per_page);
            $questions = $this->courseQuestionService->showAllCourseQuestion($requestData)->get();
            return view('backend.course.question-answer.index', compact('question_answers', 'request', 'questions', 'companies', 'courses'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
             flash('Answer table not found!')->error();
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
            $questions = $this->courseQuestionService->showAllCourseQuestion($companyWiseUser)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $course_chapters = $this->courseChapterService->showAllCourseChapter($companyWiseUser)->get();
            $course_classes = $this->courseClassService->showAllCourseClass($companyWiseUser)->get();

            return view('backend.course.question-answer.create', compact('questions', 'companies', 'courses', 'course_chapters', 'course_classes'));
        } catch (\Exception $e) {
            flash('Something wrong with Answer Data!')->error();
            return Redirect::to('/backend/question-answers');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseQuestionAnswerRequest $request)
    {
        //DB::beginTransaction();
        try {
            $course_question = $this->courseQuestionAnswerService->createCourseQuestionAnswer($request->except('_token'));
            // dd($course_question);
            if ($course_question) {
                flash('Answer created successfully')->success();
            } else {
                flash('Failed to create Answer')->error();
            }
            //DB::commit();
         } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
             //DB::rollback();
             flash('Failed to create Answer')->error();
             return redirect()->back()->withInput($request->all());
         }
        return redirect()->route('question-answers.index');
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
            $question_answer = $this->courseQuestionAnswerService->courseQuestionAnswerById($id);
            // dd($question_answer);
            return view('backend.course.question-answer.show', compact('question_answer'));
        } catch (\Exception $e) {
            flash('Answer data not found!')->error();
            return redirect()->route('question-answers.index');
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
            $question_answer = $this->courseQuestionAnswerService->courseQuestionAnswerById($id);
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $questions = $this->courseQuestionService->showAllCourseQuestion($companyWiseUser)->get();
            $course_chapters = $this->courseChapterService->showAllCourseChapter($companyWiseUser)->get();
            $course_classes = $this->courseClassService->showAllCourseClass($companyWiseUser)->get();

            return view('backend.course.question-answer.edit', compact('question_answer', 'questions', 'companies', 'courses', 'course_chapters', 'course_classes'));
        } catch (\Exception $e) {
            flash('Answer data not found!')->error();
            return redirect()->route('question-answers.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseQuestionAnswerRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $question_answer = $this->courseQuestionAnswerService->updateCourseQuestionAnswer($request->except('_token'), $id);

            if ($question_answer) {
                flash('Answer updated successfully')->success();
            } else {
                flash('Failed to update Answer')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Answer')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('question-answers.index');
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
            $question_answer = $this->courseQuestionAnswerService->courseQuestionAnswerById($id);
            if ($question_answer) {
                $question_answer->delete();
                flash('Answer deleted successfully')->success();
            }else{
                flash('Answer not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('question-answers.index');
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
            $question_answers = $this->courseQuestionAnswerService->showAllCourseQuestionAnswer($requestData)->get();
            return view('backend.course.question-answer.pdf', compact('question_answers'));
        } catch (\Exception $e) {
            flash('Answer table not found!')->error();
            return Redirect::to('/backend/question-answers');
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
            $requestData = array_merge($companyWiseUser,$request->all());
            $question_answers = $this->courseQuestionAnswerService->showAllCourseQuestionAnswer($requestData)->orderBy('course_question_answers.id','DESC')->get();
            return view('backend.course.question-answer.excel', compact('question_answers'));
        } catch (\Exception $e) {
            flash('Answer table not found!')->error();
            return Redirect::to('/backend/question-answers');
        }
    }
}
