<?php

namespace App\Http\Controllers\Backend\CourseManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\CourseManage\CourseQuestionRequest;
use App\Services\Backend\CourseManage\CourseQuestionService;
use App\Services\Backend\CourseManage\CourseClassService;
use App\Services\Backend\CourseManage\CourseChapterService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\Course\CourseSubCategoryService;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\Course\CourseChildCategoryService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CourseQuestionController extends Controller
{
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
    * @var CourseSubCategoryService
    */
    private $courseChildCategoryService;

    /**
    * @var CourseSubCategoryService
    */
    private $courseSubCategoryService;

    /**
     * @var companyService
     */
    private $companyService;

    /**
     * @var courseCategoryService
     */
    private $courseCategoryService;

    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var BranchService
     */
    private $branchService;

    /**
     * @param CourseQuestionService $courseQuestionService
     * @param CourseClassService $courseClassService
     * @param CourseChapterService $courseChapterService
     * @param CourseService $courseService
     * @param CourseChildCategoryService $courseChildCategoryService
     * @param CourseSubCategoryService $courseSubCategoryService
     * @param CompanyService $companyService
     * @param CourseCategoryService $courseCategoryService
     * @param UserService $userService
     * @param BranchService $branchService
     */
    public function __construct(
        CourseQuestionService $courseQuestionService,
        CourseClassService $courseClassService,
        CourseChapterService $courseChapterService,
        CourseService $courseService,
        CourseChildCategoryService $courseChildCategoryService,
        CourseSubCategoryService $courseSubCategoryService,
        CompanyService $companyService,
        CourseCategoryService $courseCategoryService,
        UserService $userService,
        BranchService $branchService
    )
    {
        $this->courseQuestionService = $courseQuestionService;
        $this->courseClassService = $courseClassService;
        $this->courseChapterService = $courseChapterService;
        $this->courseService = $courseService;
        $this->courseChildCategoryService = $courseChildCategoryService;
        $this->courseSubCategoryService = $courseSubCategoryService;
        $this->companyService = $companyService;
        $this->courseCategoryService = $courseCategoryService;
        $this->userService = $userService;
        $this->branchService = $branchService;
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
            // $total_course_chapters = $this->courseChapterService->showAllCourseChapter($request)->get();
            $companies = $this->companyService->showAllCompany($requestData)->get();
            $course_categories = $this->courseCategoryService->showAllCourseCategory($requestData)->get();
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($requestData)->get();
            $course_child_categories = $this->courseChildCategoryService->showAllCourseChildCategory($requestData)->get();
            $courses = $this->courseService->showAllCourse($requestData)->get();
            $branches = $this->branchService->showAllBranch($requestData)->get();
            $course_chapters = $this->courseChapterService->showAllCourseChapter($requestData)->get();
            $course_classes = $this->courseClassService->showAllCourseClass($requestData)->get();
            return view('backend.course.course-question.index', compact('companies', 'request', 'course_child_categories', 'course_sub_categories', 'course_categories', 'branches', 'courses', 'course_chapters', 'course_classes', 'course_questions'));
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
            $course_categories = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            $course_child_categories = $this->courseChildCategoryService->showAllCourseChildCategory($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            $course_chapters = $this->courseChapterService->showAllCourseChapter($companyWiseUser)->get();
            $course_classes = $this->courseClassService->showAllCourseClass($companyWiseUser)->get();

            return view('backend.course.course-question.create', compact('companies', 'course_categories', 'course_sub_categories', 'branches', 'course_child_categories', 'courses', 'course_chapters', 'course_classes'));
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
        try {
            DB::beginTransaction();
            $course_question = $this->courseQuestionService->createCourseQuestion($request->except('question_image', '_token'));
            // dd($course_question);
            if ($course_question) {
                // Course Question Image
                $request['question_id'] = $course_question->id;
                if ($request->hasFile('question_image')) {
                    $image_url = $this->courseQuestionService->courseQuestionImage($request);
                    $course_question->question_image = $image_url;
                    $course_question->save();
                }
                flash('Question created successfully')->success();
            } else {
                flash('Failed to create Question')->error();
            }
            DB::commit();
         } catch (\Exception $e) {
            throw  new \Exception($e->getMessage());
             DB::rollback();
             flash('Failed to create Question')->error();
             return redirect()->back()->withInput($request->all());
         }
        return redirect()->route('course-questions.index');
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
            return view('backend.course.course-question.show', compact('course_question'));
        } catch (\Exception $e) {
            flash('Course Question data not found!')->error();
            return redirect()->route('course-questions.index');
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
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $course_categories = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            $course_child_categories = $this->courseChildCategoryService->showAllCourseChildCategory($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $course_chapters = $this->courseChapterService->showAllCourseChapter($companyWiseUser)->get();
            $course_classes = $this->courseClassService->showAllCourseClass($companyWiseUser)->get();

            return view('backend.course.course-question.edit', compact('course_question', 'companies', 'course_categories', 'course_sub_categories', 'course_child_categories', 'branches', 'courses', 'course_chapters', 'course_classes'));
        } catch (\Exception $e) {
            flash('Course Question data not found!')->error();
            return redirect()->route('course-questions.index');
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
        return redirect()->route('course-questions.index');
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
        return redirect()->route('course-questions.index');
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
            return view('backend.course.course-question.pdf', compact('questions'));
        } catch (\Exception $e) {
            flash('Question table not found!')->error();
            return Redirect::to('/backend/course-questions');
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
            return view('backend.course.course-question.excel', compact('questions'));
        } catch (\Exception $e) {
            flash('Question table not found!')->error();
            return Redirect::to('/backend/course-questions');
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
