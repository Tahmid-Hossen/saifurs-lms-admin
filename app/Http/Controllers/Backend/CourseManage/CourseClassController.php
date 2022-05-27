<?php

namespace App\Http\Controllers\Backend\CourseManage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\CourseManage\CourseClassRequest;
use App\Services\Backend\CourseManage\CourseClassService;
use App\Services\Backend\CourseManage\CourseChapterService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\Course\CourseSubCategoryService;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\Course\CourseChildCategoryService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\CourseManage\CourseBatchService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CourseClassController extends Controller
{
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
    * @var CourseBatchService
    */
    private $courseBatchService;

    /**
    * @var courseChildCategoryService
    */
    private $courseChildCategoryService;

    /**
    * @var CourseSubCategoryService
    */
    private $courseSubCategoryService;

    /**
     * @var CompanyService
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
     * @param CourseClassService $courseClassService
     * @param CourseChapterService $courseChapterService
     * @param CourseBatchService $courseBatchService
     * @param CourseService $courseService
     * @param CourseChildCategoryService $courseChildCategoryService
     * @param CourseSubCategoryService $courseSubCategoryService
     * @param CompanyService $companyService
     * @param CourseCategoryService $courseCategoryService
     * @param UserService $userService
     * @param BranchService $branchService
     */
    public function __construct(
        CourseClassService $courseClassService,
        CourseChapterService $courseChapterService,
        CourseBatchService $courseBatchService,
        CourseService $courseService,
        CourseChildCategoryService $courseChildCategoryService,
        CourseSubCategoryService $courseSubCategoryService,
        CompanyService $companyService,
        CourseCategoryService $courseCategoryService,
        UserService $userService,
        BranchService $branchService
    )
    {
        $this->courseClassService = $courseClassService;
        $this->courseChapterService = $courseChapterService;
        $this->courseBatchService = $courseBatchService;
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
            $request['class_sorting'] = isset($request['class_sorting'])?$request['class_sorting']:'DESC';
            $requestData = array_merge($companyWiseUser,$request->all());
            $course_classes = $this->courseClassService->showAllCourseClass($requestData)->paginate($request->display_item_per_page);
            // $total_course_chapters = $this->courseChapterService->showAllCourseChapter($request)->get();
            $companies = $this->companyService->showAllCompany([])->get();
            $courses = $this->courseService->showAllCourse($requestData)->get();
            $course_chapters = $this->courseChapterService->showAllCourseChapter($requestData)->get();
            return view('backend.course.course-class.index', compact('companies', 'request', 'courses', 'course_chapters', 'course_classes'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            throw new \Exception($e->getMessage());
            flash('Course Class table not found!')->error();
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
            $course_batches = $this->courseBatchService->showAllCourseBatch($companyWiseUser)->get();

            return view('backend.course.course-class.create', compact('companies', 'course_categories', 'course_sub_categories', 'branches', 'course_child_categories', 'courses', 'course_chapters', 'course_batches'));
        } catch (\Exception $e) {
            flash('Something wrong with Course Class Data!')->error();
            return Redirect::to('/backend/course-classes');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseClassRequest $request)
    {
        try {
            DB::beginTransaction();
            $course_class = $this->courseClassService->createCourseClass($request->except('class_video_id', '_wysihtml5_mode', 'class_image', 'class_file', 'class_video', '_token'));
            // dd($course_class);
            if ($course_class) {
                // Course Class Image
                $request['class_id'] = $course_class->id;
                if ($request->hasFile('class_image')) {
                    $image_url = $this->courseClassService->courseClassImage($request);
                    $course_class->class_image = $image_url;
                    $course_class->save();
                }
                if ($request->hasFile('class_file')) {
                    $file = $this->courseClassService->courseClassFile($request);
                    $course_class->class_file = $file;
                    $course_class->save();
                }
                if ($request->hasFile('class_video')) {
                    $video = $this->courseClassService->courseClassVideo($request);
                    $course_class->class_video = $video;
                    $course_class->save();
                }
                flash('Course Class created successfully')->success();
            } else {
                flash('Failed to create Course Class')->error();
            }
            DB::commit();
         } catch (\Exception $e) {
            throw  new \Exception($e->getMessage());
             DB::rollback();
             flash('Failed to create Course Class')->error();
             return redirect()->back()->withInput($request->all());
         }
        return redirect()->route('course-classes.index');
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
            $course_class = $this->courseClassService->courseClassById($id);
            // dd($course_class);
            return view('backend.course.course-class.show', compact('course_class'));
        } catch (\Exception $e) {
            flash('Course Class data not found!')->error();
            return redirect()->route('course-classes.index');
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
            $course_class = $this->courseClassService->courseClassById($id);
            $companyWiseUser = $this->userService->user_role_display();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $course_categories = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            $course_child_categories = $this->courseChildCategoryService->showAllCourseChildCategory($companyWiseUser)->get();
            $courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $course_chapters = $this->courseChapterService->showAllCourseChapter($companyWiseUser)->get();
            $course_batches = $this->courseBatchService->showAllCourseBatch($companyWiseUser)->get();

            return view('backend.course.course-class.edit', compact('course_class', 'companies', 'course_categories', 'course_sub_categories', 'course_child_categories', 'branches', 'courses', 'course_chapters', 'course_batches'));
        } catch (\Exception $e) {
            flash('Course Class data not found!')->error();
            return redirect()->route('course-classes.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourseClassRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $course_class = $this->courseClassService->updateCourseClass($request->except('class_video_id', '_wysihtml5_mode', 'class_image', 'class_file', 'class_video', '_token'), $id);

            if ($course_class) {
                // Course Class Category Image
                $request['class_id'] = $course_class->id;
                if ($request->hasFile('class_image')) {
                    $image_url = $this->courseClassService->courseClassImage($request);
                    $course_class->class_image = $image_url;
                    $course_class->save();
                }
                if ($request->hasFile('class_file')) {
                    $file = $course_class->class_file;

                    if(\File::exists(public_path($file))){
                        \File::delete(public_path($file));
                    }
                    $file = $this->courseClassService->courseClassFile($request);
                    $course_class->class_file = $file;
                    $course_class->save();
                }

                if ($request->hasFile('class_video')) {
                    $video = $course_class->class_video;
                    if(\File::exists(public_path($video))){
                        \File::delete(public_path($video));
                    }
                    $video = $this->courseClassService->courseClassVideo($request);
                    $course_class->class_video = $video;
                    $course_class->save();
                }

                flash('Course Class updated successfully')->success();
            } else {
                flash('Failed to update Course Class')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Course Class')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('course-classes.index');
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
            $course_class = $this->courseClassService->courseClassById($id);
            if ($course_class) {
                $course_class->delete();
                flash('Course Class deleted successfully')->success();
            }else{
                flash('Course Class not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('course-classes.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $request['class_sorting'] = isset($request['class_sorting'])?$request['class_sorting']:'DESC';
            $requestData = array_merge($companyWiseUser,$request->all());
            $classes = $this->courseClassService->showAllCourseClass($requestData)->get();
            return view('backend.course.course-class.pdf', compact('classes'));
        } catch (\Exception $e) {
            flash('Course Class table not found!')->error();
            return Redirect::to('/backend/course-classes');
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
            $request['class_sorting'] = isset($request['class_sorting'])?$request['class_sorting']:'DESC';
            $requestData = array_merge($companyWiseUser,$request->all());
            $classes = $this->courseClassService->showAllCourseClass($requestData)->orderBy('course_classes.id','DESC')->get();
            return view('backend.course.course-class.excel', compact('classes'));
        } catch (\Exception $e) {
            flash('Course Class table not found!')->error();
            return Redirect::to('/backend/course-classes');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCourseClassList(Request $request): \Illuminate\Http\JsonResponse
    {
        $companyWiseUser = $this->userService->user_role_display();
        $requestData = array_merge($companyWiseUser,$request->all());
        $request['class_sorting'] = isset($request['class_sorting'])?$request['class_sorting']:'DESC';
        $courseClass = $this->courseClassService->showAllCourseClass($requestData)->get();
        if(count($courseClass)>0):
            $message = response()->json(['status' => 200, 'data'=>$courseClass]);
        else:
            $message = response()->json(['status' => 404, 'message'=>'Data fot found']);
        endif;
        return $message;
    }

    public function downloadFile($id) {
        $course_class = $this->courseClassService->courseClassById($id);
        // dd($course_class);
        $file_path = public_path($course_class->class_file);
        return response()->download($file_path);
    }
}
