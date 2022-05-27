<?php

namespace App\Http\Controllers\Backend\CourseManage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CourseManage\CourseRequest;
use App\Services\Backend\Common\TagService;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\Course\CourseChildCategoryService;
use App\Services\Backend\Course\CourseSubCategoryService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\CourseManage\CourseBatchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\BranchService;

use App\Services\Backend\User\UserService;
use App\Services\PushNotificationService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Exception;
use App\Models\User;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseBatch;

class CourseController extends Controller
{
    /**
     * @var TagService
     */
    private $tagService;

    private $branchService;

    /**
     * @var CourseService
     */
    private $courseService;

    /**
     * @var CourseBatchService
     */
    private $courseBatchService;

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
     * @var companyService
     */
    private $companyService;

    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var PushNotificationService
     */
    private $pushNotificationService;

    /**
     * @param TagService $tagService
     * @param CourseChildCategoryService $courseChildCategoryService
     * @param CourseSubCategoryService $courseSubCategoryService
     * @param CourseCategoryService $courseCategoryService
     * @param CourseService $courseService
     * @param CourseBatchService $courseBatchService
     * @param BranchService $branchService
     * @param CompanyService $companyService
     * @param UserService $userService
     * @param PushNotificationService $pushNotificationService
     */
    public function __construct(BranchService $branchService,TagService $tagService, CourseChildCategoryService $courseChildCategoryService, CourseSubCategoryService $courseSubCategoryService, CourseCategoryService $courseCategoryService, CourseService $courseService, CompanyService $companyService, UserService $userService, PushNotificationService $pushNotificationService, CourseBatchService $courseBatchService)
    {
        $this->branchService = $branchService;
        $this->courseChildCategoryService = $courseChildCategoryService;
        $this->courseSubCategoryService = $courseSubCategoryService;
        $this->courseCategoryService = $courseCategoryService;
        $this->courseService = $courseService;
        $this->companyService = $companyService;
        $this->userService = $userService;
        $this->tagService = $tagService;
        $this->pushNotificationService = $pushNotificationService;
        $this->courseBatchService = $courseBatchService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return RedirectResponse|Response
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $courses = $this->courseService->showAllCourse($requestData)->paginate($request->display_item_per_page);
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $total_courses = $this->courseService->showAllCourse($companyWiseUser)->get();
            $course_categories = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            $course_child_categories = $this->courseChildCategoryService->showAllCourseChildCategory($companyWiseUser)->get();
            return view('backend.course.course.index', compact('courses', 'companies', 'request', 'course_child_categories', 'course_sub_categories', 'course_categories', 'total_courses'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Course table not found!')->error();
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
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $course_categories = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            $course_child_categories = $this->courseChildCategoryService->showAllCourseChildCategory($companyWiseUser)->get();
            $tags = $this->tagService->ShowAllTag($companyWiseUser)->get();

            return view('backend.course.course.create', compact('companies', 'tags', 'course_categories', 'course_sub_categories', 'course_child_categories'));
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
            flash('Something wrong with Course Data!')->error();
            return Redirect::to('/backend/course');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseRequest $request
     * @return RedirectResponse|Response
     */
    public function store(CourseRequest $request)
    {
/*        dd($request->all());*/
        $validated = $request->validate([
            'course_slug' => 'unique:course,course_slug',
            'course_position' => 'nullable|unique:course,course_position',
        ]);

        try {
            \DB::beginTransaction();
            $tags = [];
            if ($request->input('course_tags.*')) {
                $tags = $this->tagService->getAllTagId($request->input('course_tags.*'));
            }

            if ($course = $this->courseService->createCourse($request, $tags)) {
                flash('Course created successfully')->success();

                if(isset($request->course_type) && $request->course_type == "Recorded") {
                    $courseBatch = $this->courseBatchService->createCourseBatch($request->except('_token'), $course);

                }
            }

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());
            flash('Failed to create Course')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('course.index');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function show($id)
    {
        try {
            $course = $this->courseService->courseById($id);
            return view('backend.course.course.show', compact('course'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Course data not found!')->error();
            return redirect()->route('course.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function edit($id)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $course = $this->courseService->courseById($id);
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $branches = $this->branchService->showAllBranch($companyWiseUser)->get();
            $course_categories = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $course_sub_categories = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            $course_child_categories = $this->courseChildCategoryService->showAllCourseChildCategory($companyWiseUser)->get();
            $tags = $this->tagService->ShowAllTag(array())->get();

            return view('backend.course.course.edit', compact('branches','course', 'tags', 'companies', 'course_categories', 'course_sub_categories', 'course_child_categories'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Course data not found!')->error();
            return redirect()->route('course.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|Response
     */

    public function update(CourseRequest $request, $id)
    {
        $validated = $request->validate([
            'course_slug' => 'unique:course,course_slug,' . $id,
            'course_position' => 'nullable|unique:course,course_position,' . $id,
        ]);

        try {
            DB::beginTransaction();
            $tags = [];

            if ($request->input('course_tags.*')) {
                $tags = $this->tagService->getAllTagId($request->input('course_tags.*'));
            }

            if ($course = $this->courseService->updateCourse($request, $tags, $id)) {
                flash('Course updated successfully')->success();
            }

            $batches = CourseBatch::where('course_id', $request->course_id)->get();
            foreach($batches as $batch)
            {
                $c_batch = $batch;
            }

            if(isset($c_batch->id)) {
                if(isset($request->course_type) && $request->course_type == "Recorded") {
                    $course_name = explode(' ', $request->course_title);
                    $b_course_name = implode('-', $course_name);
                    $course_batch_name = $b_course_name . '-' . \Carbon\Carbon::now()->format('d-m-y');

                    $courseBatch = $this->courseBatchService->updateCourseBatch($request->except('course_batch_logo', 'student_id', '_token', 'course_option', 'course_category_id', 'course_sub_category_id', 'course_child_category_id', 'course_title', 'course_short_description', 'course_requirements', '_wysihtml5_mode', 'course_description', 'course_duration', 'course_duration_expire', 'course_video_id', 'course_video_url', 'course_is_assignment', 'course_is_certified', 'course_is_subscribed', 'course_download_able', 'course_status', 'course_featured', 'course_language', 'course_content_type', 'course_type', 'course_batch_duration', 'course_tags', 'course_regular_price', 'course_discount', 'course_image', 'course_file'), $c_batch->id, $course_batch_name);
                }
            } else {
                if(isset($request->course_type) && $request->course_type == "Recorded") {
                    $course_name = explode(' ', $request->course_title);
                    $b_course_name = implode('-', $course_name);
                    $course_batch_name = $b_course_name . '-' . \Carbon\Carbon::now()->format('d-m-y');
                    $courseBatch = $this->courseBatchService->createCourseBatch($request->except('course_batch_logo', 'student_id', '_token', 'course_option', 'course_category_id', 'course_sub_category_id', 'course_child_category_id', 'course_title', 'course_short_description', 'course_requirements', '_wysihtml5_mode', 'course_description', 'course_duration', 'course_duration_expire', 'course_video_id', 'course_video_url', 'course_is_assignment', 'course_is_certified', 'course_is_subscribed', 'course_download_able', 'course_status', 'course_featured', 'course_language', 'course_content_type', 'course_type', 'course_batch_duration', 'course_tags', 'course_regular_price', 'course_discount', 'course_image', 'course_file', '_method'), $id, $course_batch_name);

                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error($e->getMessage());
            flash('Failed to create Course')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('course.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse|Response
     */
    public function destroy($id)
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if (isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id) {
            $course = $this->courseService->courseById($id);
            if ($course) {
                $course->delete();
                flash('Course deleted successfully')->success();
            } else {
                flash('Course not found!')->error();
            }
        } else {
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('course.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $courses = $this->courseService->showAllCourse($requestData)->orderBy('course.id', 'DESC')->get();
            return view('backend.course.course.pdf', compact('courses'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Course table not found!')->error();
            return Redirect::to('/backend/course');
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
            $requestData = array_merge($companyWiseUser, $request->all());
            $courses = $this->courseService->showAllCourse($requestData)->orderBy('course.id', 'DESC')->get();
            return view('backend.course.course.excel', compact('courses'));
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Course table not found!')->error();
            return Redirect::to('/backend/course');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCourseList(Request $request)
    {
        $companyWiseUser = $this->userService->user_role_display();
        $requestData = array_merge($companyWiseUser, $request->all());
        $courses = $this->courseService->showAllCourse($requestData)->get();
        // dd($courses);
        if (count($courses) > 0):
            $message = response()->json(['status' => 200, 'data' => $courses]);
        else:
            $message = response()->json(['status' => 404, 'message' => 'Data Not Found']);
        endif;
        return $message;
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|RedirectResponse|\Illuminate\Routing\Redirector|void
     */
    public function courseMarkedAsRead($id)
    {
        try {
            $user = Auth::user();
            $notification = $user->notifications->find($id);
            $notification->markAsRead();
            $course_id = $notification->data['id'];
            return redirect(route('course.show', $course_id));
        } catch (Exception $exception) {
            \Log::error($exception->getMessage());
            flash('Notification Not Found', 'error');
            return redirect(back('course.index'));
        }

    }


    public function downloadFile($id)
    {
        $course = $this->courseService->courseById($id);
        // dd($course);
        $file_path = public_path($course->course_file);
        return response()->download($file_path);
    }


}
