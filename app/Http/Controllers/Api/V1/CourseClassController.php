<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Backend\CourseManage\CourseClassRequest;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\Course\CourseChildCategoryService;
use App\Services\Backend\Course\CourseSubCategoryService;
use App\Services\Backend\CourseManage\CourseBatchService;
use App\Services\Backend\CourseManage\CourseChapterService;
use App\Services\Backend\CourseManage\CourseClassService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class CourseClassController
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $request['class_status'] = Constants::$user_active_status;
            $requestData = array_merge($companyWiseUser,$request->all());
            $data['course_classes'] = $this->courseClassService->showAllCourseClass($requestData)->paginate($request->display_item_per_page);
            //$data['companies'] = $this->companyService->showAllCompany($requestData)->get();
            //$data['course_categories'] = $this->courseCategoryService->showAllCourseCategory($requestData)->get();
            //$data['course_sub_categories'] = $this->courseSubCategoryService->showAllCourseSubCategory($requestData)->get();
            //$data['course_child_categories'] = $this->courseChildCategoryService->showAllCourseChildCategory($requestData)->get();
            //$data['courses'] = $this->courseService->showAllCourse($requestData)->get();
            //$data['branches'] = $this->branchService->showAllBranch($requestData)->get();
            //$data['course_chapters'] = $this->courseChapterService->showAllCourseChapter($requestData)->get();
            $data['request'] = $request->all();
            $data['status'] = true;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['request'] = $request->all();
            $data['status'] = false;
            $data['message'] = 'Course Class table not found!';
        }
        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseClassRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(CourseClassRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $course_class = $this->courseClassService->createCourseClass($request->except('class_video_id', '_wysihtml5_mode', 'class_image', 'class_file', 'class_video', '_token'));
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
                $course_class->fresh();
                $data['course_class'] = $course_class;
                $data['request'] = $request->all();
                $data['status'] = true;
                $data['message'] = 'Course Class created successfully';
            } else {
                $data['request'] = $request->all();
                $data['status'] = true;
                $data['message'] = 'Failed to create Course Class';
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['request'] = $request->all();
            $data['status'] = true;
            $data['message'] = 'Failed to create Course Class!!';
        }
        return response()->json($data, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $data['course_class'] = $this->courseClassService->courseClassById($id);
            $data['status'] = true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $data['status'] = false;
            $data['message'] = 'Course Class data not found!';
        }
        return response()->json($data,200);
    }

    /**
     * @param CourseClassRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(CourseClassRequest $request, $id): \Illuminate\Http\JsonResponse
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
                $course_class->fresh();
                $data['course_class'] = $course_class;
                $data['request'] = $request->all();
                $data['status'] = true;
                $data['message'] = 'Course Class updated successfully';
            } else {
                $data['request'] = $request->all();
                $data['status'] = false;
                $data['message'] = 'Failed to update Course Class';
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['request'] = $request->all();
            $data['status'] = false;
            $data['message'] = 'Failed to update Course Class!!';
        }
        return response()->json($data,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $user_get = $this->userService->whoIS($_REQUEST);
            if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
                $course_class = $this->courseClassService->courseClassById($id);
                if ($course_class) {
                    $course_class->delete();
                    $data['status'] = true;
                    $data['message'] = 'Course Class deleted successfully';
                }else{
                    DB::rollback();
                    $data['status'] = false;
                    $data['message'] = 'Course Class not found!';
                }
            }else{
                $data['status'] = false;
                $data['message'] = 'You Entered Wrong Password!';
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $data['status'] = false;
            $data['message'] = 'Course Class not found!';
        }
        return response()->json($data,200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCourseClassList(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser,$request->all());
            $courseClass = $this->courseClassService->showAllCourseClass($requestData)->get();
            if(count($courseClass)>0):
                $data['courseClass'] = $courseClass;
                $data['request'] = $request->all();
                $data['status'] = true;
            else:
                $data['request'] = $request->all();
                $data['status'] = false;
                $data['message'] = 'Data Not Found';
            endif;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $data['status'] = false;
            $data['message'] = 'Course Class not found!';
        }
        return response()->json($data,200);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCourseClassDetail(Request $request): \Illuminate\Http\JsonResponse
    {
        $companyWiseUser = $this->userService->user_role_display_for_api();
        $requestData = array_merge($companyWiseUser,$request->all());
        $courseClass = $this->courseClassService->showAllCourseClass($requestData)->first();
        if(count($courseClass)>0):
            $data['courseClass'] = $courseClass;
            $data['request'] = $request->all();
            $data['status'] = true;
        else:
            $data['request'] = $request->all();
            $data['status'] = false;
            $data['message'] = 'Data fot found!!';
        endif;
        return response()->json($data, 200);
    }

    /**
     * Download the specified resource.
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadFile($id): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $course_class = $this->courseClassService->courseClassById($id);
        $file_path = public_path($course_class->class_file);
        return response()->download($file_path);
    }

}
