<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Backend\CourseManage\CourseChapterRequest;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\Course\CourseChildCategoryService;
use App\Services\Backend\Course\CourseSubCategoryService;
use App\Services\Backend\CourseManage\CourseChapterService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseChapterController
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
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:\Utility::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser,$request->all());
            $noOfClassProgress = 0;
            $noOfClass = 0;
            if(isset($request['course_id']) && !empty($request['course_id']) && $request['course_id']>0):
                $courses = $this->courseService->showAllCourse($requestData)->first();
                $noOfClassProgress = $courses->noOfClassProgress ?? 0;
                $noOfClass = $courses->noOfClass ?? 0;
            endif;
            $courseChapters = $this->courseChapterService->showAllCourseChapter($requestData)->with(['courseClass', 'courseClass.courseProgress']);
            if(isset($request['is_paginate']) && $request['is_paginate'] == 'yes'):
                $courseChaptersList = $courseChapters->paginate($request->display_item_per_page);
                $courseChaptersArray = array();
                if(count($courseChaptersList)>0):
                foreach($courseChaptersList as $courseChapter):
                    $courseChaptersArray[] = $courseChapter;
                    $courseChapter->total_class = 0;
                    $courseChapter->total_progress_count = 0;
                    foreach ($courseChapter->courseClass as $courseClass):
                        //$courseChapter->total_progress_count += $courseClass->courseProgressCount = ($courseClass->courseProgressWithUser($companyWiseUser['user_id']??null)??0);
                        $courseClass->is_play = ($courseClass->courseProgressWithUser($companyWiseUser['user_id']??null)??0);
                        $courseClass->class_video = $courseClass->class_video_full_path;
                        $courseClass->class_file = $courseClass->class_file_full_path;
                        $courseClass->makeHidden('courseProgress');
                    endforeach;
                endforeach;
                $paginate_properties = json_decode($courseChaptersList->toJSON());
                $data['courseChapters']['current_page'] = $paginate_properties->current_page;
                $data['courseChapters']['data'] = $courseChaptersArray;
                $data['courseChapters']['first_page_url'] = $paginate_properties->first_page_url;
                $data['courseChapters']['from'] = $paginate_properties->from;
                $data['courseChapters']['last_page'] = $paginate_properties->last_page;
                $data['courseChapters']['last_page_url'] = $paginate_properties->last_page_url;
                $data['courseChapters']['next_page_url'] = $paginate_properties->next_page_url;
                $data['courseChapters']['path'] = $paginate_properties->path;
                $data['courseChapters']['per_page'] = $paginate_properties->per_page;
                $data['courseChapters']['prev_page_url'] = $paginate_properties->prev_page_url;
                $data['courseChapters']['to'] = $paginate_properties->to;
                $data['courseChapters']['total'] = $paginate_properties->total;
                $data['status'] = true;
                $data['courseChapters']['noOfClassProgress'] = $noOfClassProgress;
                $data['courseChapters']['noOfClass'] = $noOfClass;
            else:
                $data['status'] = false;
                $data['message'] = 'Course Chapter data not found!';
            endif;
            else:
                $courseChaptersList = $courseChapters->get();
            ///dd($results);
                $courseChaptersArray = array();
                if(count($courseChaptersList)>0):
                    foreach($courseChaptersList as $courseChapter):
                        $courseChaptersArray[] = $courseChapter;
                        $courseChapter->total_class = 0;
                        $courseChapter->total_progress_count = 0;
                        foreach ($courseChapter->courseClass as $courseClass):
                            //$courseChapter->total_progress_count += $courseClass->courseProgressCount = ($courseClass->courseProgressWithUser($companyWiseUser['user_id']??null)??0);
                            $courseClass->is_play = ($courseClass->courseProgressWithUser($companyWiseUser['user_id']??null)??0);
                            $courseClass->class_video = $courseClass->class_video_full_path;
                            $courseClass->class_file = $courseClass->class_file_full_path;
                            $courseClass->makeHidden('courseProgress');
                        endforeach;
                    endforeach;
                    $data['courseChapters']['data'] = $courseChaptersArray;
                    $data['status'] = true;
                    $data['courseChapters']['noOfClassProgress'] = $noOfClassProgress;
                    $data['courseChapters']['noOfClass'] = $noOfClass;
                else:
                    $data['status'] = false;
                    $data['message'] = 'Course Chapter data not found!';
                endif;
            endif;
            //dd($courseChapters);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $data['status'] = false;
            $data['message'] = 'Course Chapter table not found!!';
        }
        $data['request'] = $request->all();
        return response()->json($data,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseChapterRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(CourseChapterRequest $request): JsonResponse
    {
        try {
            \DB::beginTransaction();
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
                $data['courseChapter'] = $course_chapter;
                $data['status'] = true;
                $data['message'] = 'Course Chapter created successfully';
            } else {
                $data['status'] = false;
                $data['message'] = 'Failed to create  Course Chapter';
            }
            \DB::commit();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback();
            $data['status'] = false;
            $data['message'] = 'Failed to create Course Chapter!!!';
        }
        return response()->json($data,200);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        try {
            $data['courseChapter'] = $this->courseChapterService->courseChapterById($id);
            $data['status'] = true;
        } catch (\Exception $e) {
            $data['status'] = false;
            $data['message'] = 'Course Chapter data not found!!!';
        }
        return response()->json($data,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CourseChapterRequest $request
     * @param $id
     * @return JsonResponse
     * @throws \Throwable
     */
    public function update(CourseChapterRequest $request, $id): JsonResponse
    {
        try {
            \DB::beginTransaction();
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
                $course_chapter->fresh();
                $data['courseChapter'] = $course_chapter;
                $data['status'] = true;
                $data['message'] = 'Course Chapter updated successfully';
            } else {
                $data['status'] = false;
                $data['message'] = 'Failed to update  Course Chapter';
            }
            \DB::commit();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback();
            $data['status'] = false;
            $data['message'] = 'Failed to update Course Chapter!!!';
        }
        return response()->json($data,200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     * @throws \Throwable
     */
    public function destroy($id): JsonResponse
    {
        try {
            \DB::beginTransaction();
            $user_get = $this->userService->whoIS($_REQUEST);
            if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
                $course_chapter = $this->courseChapterService->courseChapterById($id);
                if ($course_chapter) {
                    $course_chapter->delete();
                    $data['status'] = true;
                    $data['message'] = 'Course Chapter deleted successfully';
                }else{
                    $data['status'] = false;
                    $data['message'] = 'Course Chapter not found!';
                }
            }else{
                $data['status'] = false;
                $data['message'] = 'You Entered Wrong Password!';
            }
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            $data['status'] = false;
            $data['message'] = 'Failed to deleted Course Chapter!!!';
        }
        return response()->json($data,200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getCourseChapterList(Request $request): JsonResponse
    {
        $companyWiseUser = $this->userService->user_role_display();
        $requestData = array_merge($companyWiseUser,$request->all());
        $courseChapter = $this->courseChapterService->showAllCourseChapter($requestData)->get();
        if(count($courseChapter)>0):
            $message = response()->json(['status' =>true, 'data'=>$courseChapter]);
        else:
            $message = response()->json(['status' =>false, 'message'=>'Data fot found']);
        endif;
        return $message;
    }
}
