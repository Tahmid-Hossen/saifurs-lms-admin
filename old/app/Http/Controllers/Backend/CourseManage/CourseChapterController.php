<?php

namespace App\Http\Controllers\Backend\CourseManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\CourseManage\CourseChapterRequest;
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
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CourseChapterController extends Controller
{
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
     * @return RedirectResponse|Response
     * @throws \Exception
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $request['course_chapter_by_id'] = isset($request['course_chapter_by_id'])?$request['course_chapter_by_id']:'DESC';
            $requestData = array_merge($companyWiseUser,$request->all());
            $course_chapters = $this->courseChapterService->showAllCourseChapter($requestData)->paginate($request->display_item_per_page);
            // $total_course_chapters = $this->courseChapterService->showAllCourseChapter($request)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $course_categories = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            $course_child_categories = $this->courseChildCategoryService->showAllCourseChildCategory($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            return view('backend.course.course-chapter.index', compact('companies', 'request', 'course_child_categories', 'course_sub_categories', 'course_categories', 'branches', 'courses', 'course_chapters'));
        } catch (\Exception $e) {
           \Log::error($e->getMessage());
             flash('Course Chapter table not found!', 'error');
             return Redirect::to('/backend');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return RedirectResponse|Response
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

            return view('backend.course.course-chapter.create', compact('companies', 'course_categories', 'course_sub_categories', 'branches', 'course_child_categories', 'courses'));
        } catch (\Exception $e) {
            flash('Something wrong with Course Chapter Data!')->error();
            return Redirect::to('/backend/course-chapters');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse|Response
     */
    public function store(CourseChapterRequest $request)
    {
        try {
            DB::beginTransaction();
            $course_chapter = $this->courseChapterService->createCourseChapter($request->except('_wysihtml5_mode', 'chapter_image', 'chapter_file', '_token'));
            if ($course_chapter) {
                // Course Chapter Image
                $request['chapter_id'] = $course_chapter->id;
                if ($request->hasFile('chapter_image')) {
                    $image_url = $this->courseChapterService->courseChapterImage($request);
                    $course_chapter->chapter_image = $image_url;
                    $course_chapter->save();
                }
                if ($request->hasFile('chapter_file')) {
                    $file = $this->courseChapterService->courseChapterFile($request);
                    $course_chapter->chapter_file = $file;
                    $course_chapter->save();
                }
                flash('Course Chapter created successfully')->success();
            } else {
                flash('Failed to create Course Chapter')->error();
            }
            DB::commit();
         } catch (\Exception $e) {
             DB::rollback();
             flash('Failed to create Course Chapter')->error();
             return redirect()->back()->withInput($request->all());
         }
        return redirect()->route('course-chapters.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return RedirectResponse|Response
     */
    public function show($id)
    {
        try {
            $course_chapter = $this->courseChapterService->courseChapterById($id);
            return view('backend.course.course-chapter.show', compact('course_chapter'));
        } catch (\Exception $e) {
            flash('Course Chapter data not found!')->error();
            return redirect()->route('course-chapters.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return RedirectResponse|Response
     */
    public function edit($id)
    {
        try {
            $course_chapter = $this->courseChapterService->courseChapterById($id);
            $companyWiseUser = $this->userService->user_role_display();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $course_categories = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            $course_child_categories = $this->courseChildCategoryService->showAllCourseChildCategory($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();

            return view('backend.course.course-chapter.edit', compact('course_chapter', 'companies', 'course_categories', 'course_sub_categories', 'course_child_categories', 'branches', 'courses'));
        } catch (\Exception $e) {
            flash('Course Chapter data not found!')->error();
            return redirect()->route('course-chapters.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return RedirectResponse|Response
     */
    public function update(CourseChapterRequest $request, $id)
    {
        // try {
            DB::beginTransaction();
            $course_chapter = $this->courseChapterService->updateCourseChapter($request->except('_wysihtml5_mode', 'chapter_image', 'chapter_file', '_token'), $id);

            if ($course_chapter) {
                // Course Child Category Image
                $request['chapter_id'] = $course_chapter->id;
                if ($request->hasFile('chapter_image')) {
                    $image_url = $this->courseChapterService->courseChapterImage($request);
                    $course_chapter->chapter_image = $image_url;
                    $course_chapter->save();
                }

                if ($request->hasFile('chapter_file')) {
                    $file = $course_chapter->chapter_file;

                    if(\File::exists(public_path($file))){
                        \File::delete(public_path($file));
                    }

                    $file = $this->courseChapterService->courseChapterFile($request);
                    $course_chapter->chapter_file = $file;
                    $course_chapter->save();
                }

                flash('Course Chapter updated successfully')->success();
            } else {
                flash('Failed to update Course Chapter')->error();
            }
            DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     flash('Failed to update Course Chapter')->error();
        //     return redirect()->back()->withInput($request->all());
        // }
        return redirect()->route('course-chapters.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse|Response
     */
    public function destroy($id)
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
            $course_chapter = $this->courseChapterService->courseChapterById($id);
            if ($course_chapter) {
                $course_chapter->delete();
                flash('Course Chapter deleted successfully')->success();
            }else{
                flash('Course Chapter not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('course-chapters.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $request['course_chapter_by_id'] = isset($request['course_chapter_by_id'])?$request['course_chapter_by_id']:'DESC';
            $requestData = array_merge($companyWiseUser,$request->all());
            $chapters = $this->courseChapterService->showAllCourseChapter($requestData)->get();
            return view('backend.course.course-chapter.pdf', compact('chapters'));
        } catch (\Exception $e) {
            flash('Course Chapter table not found!')->error();
            return Redirect::to('/backend/course-chapters');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function excel(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $request['course_chapter_by_id'] = isset($request['course_chapter_by_id'])?$request['course_chapter_by_id']:'DESC';
            $requestData = array_merge($companyWiseUser,$request->all());
            $chapters = $this->courseChapterService->showAllCourseChapter($requestData)->orderBy('course_chapters.id','DESC')->get();
            return view('backend.course.course-chapter.excel', compact('chapters'));
        } catch (\Exception $e) {
            flash('Course Chapter table not found!')->error();
            return Redirect::to('/backend/course-chapters');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCourseChapterList(Request $request): \Illuminate\Http\JsonResponse
    {
        $companyWiseUser = $this->userService->user_role_display();
        $request['course_chapter_by_id'] = isset($request['course_chapter_by_id'])?$request['course_chapter_by_id']:'DESC';
        $requestData = array_merge($companyWiseUser,$request->all());
        $courseChapter = $this->courseChapterService->showAllCourseChapter($requestData)->get();
        if(count($courseChapter)>0):
            $message = response()->json(['status' => 200, 'data'=>$courseChapter]);
        else:
            $message = response()->json(['status' => 404, 'message'=>'Data fot found']);
        endif;
        return $message;
    }

    public function downloadFile($id) {
        $course_chapter = $this->courseChapterService->courseChapterById($id);
        // dd($course_chapter);
        $file_path = public_path($course_chapter->chapter_file);
        return response()->download($file_path);
    }
}
