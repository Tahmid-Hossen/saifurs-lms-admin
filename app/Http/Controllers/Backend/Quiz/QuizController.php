<?php

namespace App\Http\Controllers\Backend\Quiz;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Quiz\QuizRequest;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Quiz\Quiz;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\Course\CourseChildCategoryService;
use App\Services\Backend\Course\CourseSubCategoryService;
use App\Services\Backend\Quiz\QuizService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Exception;
use Illuminate\Http\Request;

class QuizController extends Controller {
    /**
     * @var QuizService
     */
    private $quizService;

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
     * QuizController constructor.
     * @param QuizService $quizService
     * @param BranchService $branchService
     * @param UserService $userService
     * @param CompanyService $companyService
     * @param CourseService $courseService
     * @param CourseCategoryService $courseCategoryService
     * @param CourseSubCategoryService $courseSubCategoryService
     * @param CourseChildCategoryService $courseChildCategoryService
     */
    public function __construct(
        QuizService $quizService,
        //BranchService $branchService,
        UserService $userService,
        CompanyService $companyService,
        CourseService $courseService
        //CourseCategoryService $courseCategoryService,
        //CourseSubCategoryService $courseSubCategoryService,
        //CourseChildCategoryService $courseChildCategoryService
    ) {
        $this->quizService = $quizService;
        //$this->branchService = $branchService;
        $this->userService = $userService;
        $this->companyService = $companyService;
        $this->courseService = $courseService;
        //$this->courseCategoryService = $courseCategoryService;
        //$this->courseSubCategoryService = $courseSubCategoryService;
        //$this->courseChildCategoryService = $courseChildCategoryService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index( Request $request ) {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge( $companyWiseUser, $request->all() );
            $datas = $this->quizService->showAllQuiz( $requestData )->paginate( UtilityService::$displayRecordPerPage );
            $companies = $this->companyService->showAllCompany( $companyWiseUser )->get();
            $courses = $this->courseService->showAllCourse( $requestData )->get();
            return View( 'backend.quiz.quiz-topics.index', [
                'datas'     => $datas,
                'companies' => $companies,
                'request'   => $request,
                'courses'   => $courses,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Quizzes table not found!' )->error();
            return redirect( route( 'quizzes.index' ) );
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
            $courses = $this->courseService->showAllCourse( $companyWiseUser )->get();
			
            return view( 'backend.quiz.quiz-topics.create', [
                'companies'               => $companies,
                'courses'                 => $courses,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Quizzes table not found!' )->error();
            return redirect( route( 'quizzes.index' ) );
        }
    }

    /**
     * @param QuizRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( QuizRequest $request ) {
        try {
            $this->quizService->quiz_custom_insert( $request->all() );
            flash( 'A Quiz has been Created Successfully' )->success();
            return redirect( route( 'quizzes.index' ) );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Failed to Create a Quiz!' )->error();
            return back()->withInput( $request->all() );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show( $id ) {
        try {
            $quiz = $this->quizService->showQuizByID( $id );
            return view( 'backend.quiz.quiz-topics.show', [
                'quiz' => $quiz,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Datas of This Quiz isn\'t found !!' )->error();
            return redirect( route( 'quizzes.index' ) );
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
            $quiz = $this->quizService->showQuizByID( $id );
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany( $companyWiseUser )->get();
            $courses = $this->courseService->showAllCourse( $companyWiseUser )->get();
            return view( 'backend.quiz.quiz-topics.edit', [
                'quiz'      => $quiz,
                'companies' => $companies,
                'courses'   => $courses,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Datas of This Quiz isn\'t found !!' )->error();
            return redirect( route( 'quizzes.index' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuizRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update( QuizRequest $request, $id ) {
		//dd($request->all());
        try {
            $quiz = $this->quizService->quiz_custom_update( $request->all(), $id );
            if ( $quiz ) {
                flash( 'A Quiz has been Updated Successfully' )->success();
            } else {
                flash( 'Failed to Update the Quiz' )->error();
            }
        } catch ( Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Failed to Update the Quiz' )->error();
            return back()->withInput( $request->all() );
        }
        return redirect( route( 'quizzes.index' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy( $id ) {
        $user_get = $this->userService->whoIS( $_REQUEST );
        if ( isset( $user_get ) && isset( $user_get->id ) && $user_get->id == auth()->user()->id ) {
            $quiz = $this->quizService->showQuizByID( $id );
            if ( $quiz ) {
                $quiz->delete();
                flash( 'A Quiz has been deleted successfully' )->success();
            } else {
                flash( 'Datas of This Quiz isn\'t found !!' )->error();
            }
        } else {
            flash( 'You Entered Wrong Password!' )->error();
        }
        return redirect( route( 'quizzes.index' ) );
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function pdf( Request $request ) {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge( $companyWiseUser, $request->all() );
            $quizzes = $this->quizService->showAllQuiz( $requestData )->get();
            return View( 'backend.quiz.quiz-topics.pdf', [
                'datas' => $quizzes,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Quizzes table not found!' )->error();
            return redirect( route( 'quizzes.index' ) );
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function excel( Request $request ) {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge( $companyWiseUser, $request->all() );
            $quizzes = $this->quizService->showAllQuiz( $requestData )->get();
            return View( 'backend.quiz.quiz-topics.excel', [
                'datas'   => $quizzes,
                'request' => $request,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Quizzes table not found!' )->error();
            return redirect( route( 'quizzes.index' ) );
        }
    }

    public function getQuizList( Request $request ) {
        $companyWiseUser = $this->userService->user_role_display();
        $requestData = array_merge( $companyWiseUser, $request->all() );
        $quizzes = $this->quizService->showAllQuiz( $requestData )->get();
        if ( count( $quizzes ) > 0 ):
            $message = response()->json( ['status' => 200, 'data' => $quizzes] );
        else:
            $message = response()->json( ['status' => 404, 'message' => 'Data Not Found'] );
        endif;
        return $message;
    }
	
	
}
