<?php

namespace App\Http\Controllers\Backend\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\CourseManage\CourseQuestionRequest;
use App\Services\Backend\CourseManage\CourseQuestionService;
use App\Services\Backend\Quiz\QuizService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class QuestionController extends Controller
{
    /**
    * @var CourseQuestionService
    */
    private $courseQuestionService;

    
    private $companyService;

    
    private $userService;
	
	private $quizService;
    
    /**
     * @param CourseQuestionService $courseQuestionService
     * @param QuizService $quizService
     * @param CompanyService $companyService
     * @param UserService $userService
     */
    public function __construct(
        CourseQuestionService $courseQuestionService,
        QuizService $quizService,
        CompanyService $companyService,
        UserService $userService
    )
    {
        $this->courseQuestionService = $courseQuestionService;
        $this->quizService = $quizService;
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
            $course_questions = $this->courseQuestionService->showAllCourseQuestion($requestData)->paginate($request->display_item_per_page);
            $companies = $this->companyService->showAllCompany($requestData)->get();
			
            return view('backend.quiz.question.index', compact('companies', 'request', 'course_questions'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
             flash('Question table not found!')->error();
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
            $quizes = $this->quizService->showAllQuiz($companyWiseUser)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();

            return view('backend.quiz.question.create', compact('companies', 'quizes'));
        } catch (\Exception $e) {
            flash('Something wrong with Course Question Data!')->error();
            return Redirect::to('/backend/course-classes');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseQuestionRequest $request)
    {		
		dd($request->all());
        try {
            DB::beginTransaction();
            $course_question = $this->courseQuestionService->createCourseQuestion($request->except('question_image', '_token'));
             //dd($course_question);
            //if ($course_question) {
                // Course Question Image
               /* $request['question_id'] = $course_question->id;
                if ($request->hasFile('question_image')) {
                    $image_url = $this->courseQuestionService->courseQuestionImage($request);
                    $course_question->question_image = $image_url;
                    $course_question->save();
                }*/
                flash('Question created successfully')->success();
            /*} else {
                flash('Failed to create Question')->error();
            }*/
            DB::commit();
         } catch (\Exception $e) {
            throw  new \Exception($e->getMessage());
             DB::rollback();
             flash('Failed to create Question')->error();
             return redirect()->back()->withInput($request->all());
         }
        return redirect()->route('questions.index');
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
            $course_question = $this->courseQuestionService->courseQuestionById($id);
            // dd($course_question);
            return view('backend.quiz.question.show', compact('course_question'));
        } catch (\Exception $e) {
            flash('Course Question data not found!')->error();
            return redirect()->route('questions.index');
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
            $course_question = $this->courseQuestionService->courseQuestionById($id);
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $quizes = $this->quizService->showAllQuiz($companyWiseUser)->get();

            return view('backend.quiz.question.edit', compact('course_question', 'companies', 'quizes'));
        } catch (\Exception $e) {
            flash('Course Question data not found!')->error();
            return redirect()->route('questions.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseQuestionRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $course_question = $this->courseQuestionService->updateCourseQuestion($request->except('question_image', '_token'), $id);

            if ($course_question) {
                // Course Question Category Image
                $request['question_id'] = $course_question->id;
                if ($request->hasFile('question_image')) {
                    $image_url = $this->courseQuestionService->courseQuestionImage($request);
                    $course_question->question_image = $image_url;
                    $course_question->save();
                }

                flash('Question updated successfully')->success();
            } else {
                flash('Failed to update Question')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Question')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('questions.index');
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
            $course_question = $this->courseQuestionService->courseQuestionById($id);
            if ($course_question) {
                $course_question->delete();
                flash('Question deleted successfully')->success();
            }else{
                flash('Question not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('questions.index');
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
            $questions = $this->courseQuestionService->showAllCourseQuestion($requestData)->get();
            return view('backend.quiz.question.pdf', compact('questions'));
        } catch (\Exception $e) {
            flash('Question table not found!')->error();
            return Redirect::to('/backend/questions');
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
            $questions = $this->courseQuestionService->showAllCourseQuestion($requestData)->orderBy('course_questions.id','DESC')->get();
            return view('backend.quiz.question.excel', compact('questions'));
        } catch (\Exception $e) {
            flash('Question table not found!')->error();
            return Redirect::to('/backend/questions');
        }
    }

    public function getCourseQuestionList(Request $request): \Illuminate\Http\JsonResponse
    {
        $companyWiseUser = $this->userService->user_role_display();
        $requestData = array_merge($companyWiseUser,$request->all());
        $courseQuestion = $this->courseQuestionService->showAllCourseQuestion($requestData)->get();
        if(count($courseQuestion)>0):
            $message = response()->json(['status' => 200, 'data'=>$courseQuestion]);
        else:
            $message = response()->json(['status' => 404, 'message'=>'Data fot found']);
        endif;
        return $message;
    }
}
