<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Requests\Backend\CourseManage\CourseRequest;
use App\Services\Backend\Common\TagService;
use App\Services\Backend\Course\CourseCategoryService;
use App\Services\Backend\Course\CourseChildCategoryService;
use App\Services\Backend\Course\CourseSubCategoryService;
use App\Services\Backend\CourseManage\CourseService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CourseController
{
    /**
     * @var TagService
     */
    private $tagService;

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
     * @var companyService
     */
    private $companyService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param CourseChildCategoryService $courseChildCategoryService
     * @param CourseSubCategoryService $courseSubCategoryService
     * @param CourseCategoryService $courseCategoryService
     * @param CourseService $courseService
     * @param CompanyService $companyService
     * @param UserService $userService
     * @param TagService $tagService
     */
    public function __construct(
        TagService                 $tagService,
        CourseChildCategoryService $courseChildCategoryService,
        CourseSubCategoryService   $courseSubCategoryService,
        CourseCategoryService      $courseCategoryService,
        CourseService              $courseService,
        CompanyService             $companyService,
        UserService                $userService
    )
    {
        $this->courseChildCategoryService = $courseChildCategoryService;
        $this->courseSubCategoryService = $courseSubCategoryService;
        $this->courseCategoryService = $courseCategoryService;
        $this->courseService = $courseService;
        $this->companyService = $companyService;
        $this->userService = $userService;
        $this->tagService = $tagService;
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
            $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : UtilityService::$displayRecordPerPage;
            $request['course_status'] = Constants::$user_active_status;
            $request['is_batch'] = true;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $data['companies'] = $this->companyService->showAllCompany($companyWiseUser)->get();
            $data['course_categories'] = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $data['course_sub_categories'] = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            $data['course_child_categories'] = $this->courseChildCategoryService->showAllCourseChildCategory($companyWiseUser)->get();
            $requestData = array_merge($companyWiseUser, $request->all());
            $data['courses'] = $this->courseService->showAllCourse($requestData)->paginate($request->display_item_per_page);
            $data['request'] = $request->all();
            $data['status'] = true;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Course table not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        try {
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $data['course_categories'] = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $data['course_sub_categories'] = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            $data['course_child_categories'] = $this->courseChildCategoryService->showAllCourseChildCategory($companyWiseUser)->get();
            $data['companies'] = $this->companyService->showAllCompany($companyWiseUser)->get();
            $data['tags'] = $this->tagService->ShowAllTag($companyWiseUser)->get();
            $data['status'] = true;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Something wrong with Course Data!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CourseRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(CourseRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $tags = [];
            if ($request->input('course_tags.*')) {
                $tags = $this->tagService->getAllTagId($request->input('course_tags.*'));
            }
            $data['course'] = $this->courseService->createCourse($request, $tags);

            if ($data['course']) {
                $data['status'] = true;
                $data['message'] = 'Course created successfully!';
            } else {
                $data['status'] = true;
                $data['message'] = 'Failed to create Course!';
            }
            $data['request'] = $request->all();
            $jsonReturn = response()->json($data, 200);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to create Course!'], 200);
        }
        return $jsonReturn;
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
            $course = $this->courseService->courseById($id);
            $data['course'] = $course;
            $data['course']['course_image'] = $course->course_image_full_path;
            $data['course']['course_video'] = $course->course_video_full_path;
            $data['course']['course_total_comment'] = $course->course_total_comment;
            $data['course']['course_rating_point'] = $course->course_rating_point;
            $data['course']['course_best_seller'] = 0;
            $data['course']['course_category_title'] = $course->courseCategory->course_category_title;
            $data['course']['course_sub_category_title'] = $course->courseSubCategory->course_sub_category_title;
            $data['course']['course_child_category_title'] = $course->courseChildCategory->course_child_category_title;
            $data['course'] = collect($course)->forget(['course_category', 'course_sub_category', 'course_child_category'])->all();
            $data['course']['tags'] = $course->tags;
            /*$courseCommentArray = array();
            if(isset($course->courseComment)):
                foreach ($course->courseComment as $courseComment):
                    if(isset($courseComment->user->userDetails)):
                        $courseComment->user->userDetails;
                        $courseComment->name = $courseComment->user->name;
                        $courseComment->first_name = $courseComment->user->userDetails->first_name;
                        $courseComment->last_name = $courseComment->user->userDetails->last_name;
                        $courseComment->user_detail_photo = $courseComment->user->userDetails->user_detail_photo_full_link;
                        $courseCommentArray[] = $courseComment->makeHidden('user');
                    endif;
                endforeach;
            endif;
            $data['course']['course_comment'] = $course->courseComment;*/
            $ratingRatingArray = array();
            if (isset($course->courseRatingGroup)):
                foreach ($course->courseRatingGroup as $courseRatingGroup):
                    $ratingRatingArray[$courseRatingGroup->text_course_rating_stars] = \CHTML::numberFormat((($courseRatingGroup->total_course_rating_stars * 100) / $course->course_total_comment));
                endforeach;
            endif;
            $data['course']['course_rating_group'] = array_merge(\Utility::$ratingStarGroup, $ratingRatingArray);
            $chapterArray = array();
            if (isset($course->chapters)):
                foreach ($course->chapters as $chapter):
                    $chapter->chapter_image = $chapter->chapter_image_full_path;
                    $chapter->chapter_file = $chapter->chapter_file_full_path;
                    //$chapter->courseClass;
                    $chapterClassesArray = array();
                    if (isset($chapter->courseActiveClass)):
                        foreach ($chapter->courseActiveClass as $class):
                            $class->class_image = $class->class_image_full_path;
                            $class->class_file = $class->class_file_full_path;
                            $class->class_video = $class->class_video_full_path;
                            $chapterClassesArray[] = $class;
                        endforeach;
                    endif;
                    $chapter->course_class = $chapterClassesArray;
                    $chapter->makeHidden('course_chapter');
                    $chapter->makeHidden('course_active_class');
                    $chapterArray[] = $chapter;
                endforeach;
                $data['course']['chapters'] = $chapterArray;
            else:
                $data['course']['chapters'] = [];
            endif;
            //TODO REMOVE THIS CODE BY DISCUSSION SHAHEEN
            $classesArray = array();
            if (isset($course->classes)):
                foreach ($course->classes as $class):
                    if ($class->class_status == 'ACTIVE'):
                        $class->class_image = $class->class_image_full_path;
                        $class->class_file = $class->class_file_full_path;
                        $class->class_video = $class->class_video_full_path;
                        $classesArray[] = $class;
                    endif;
                endforeach;
            endif;
            $data['course']['classes'] = $classesArray;
            $syllabusArray = array();
            if (isset($course->syllabuses)):
                foreach ($course->syllabuses as $syllabus):
                    $syllabusArray[] = $syllabus;
                    $syllabus->syllabus_file = $syllabus->syllabus_file_full_path;
                endforeach;
            endif;
            $data['course']['syllabuses'] = $syllabusArray;
            $data['course']['learns'] = $course->learns;
            $meetingArray = array();
            if (isset($course->courseMeeting)):
                foreach ($course->courseMeeting as $courseMeeting):
                    $courseMeeting->vendor_meeting_logo = $courseMeeting->vendor_meeting_logo_full_path;
                    if (isset($courseMeeting->instructor)):
                        $courseMeeting->instructor;
                        $courseMeeting->instructor->userDetails;
                        $courseMeeting->instructor->userDetails->user_detail_photo = $courseMeeting->instructor->userDetails->user_detail_photo_full_link;
                    endif;
                    $meetingArray[] = $courseMeeting;
                    //$courseMeeting->makeHidden(['instructor']);
                endforeach;
            endif;
            $data['course']['meeting'] = $meetingArray;
            $batchArray = array();
            if (isset($course->batches)):
                foreach ($course->batches->sortBy('course_batch_start_date') as $batch):
                    $batch->course_batch_logo = $batch->course_batch_logo_full_path;

                    $batch->duration = ucwords(str_replace([' before', ' ago', ' after'], ['', '', ''],
                        \Carbon\Carbon::parse($batch->course_batch_start_date)->diffForHumans(\Carbon\Carbon::parse($batch->course_batch_end_date))));
                    $batch->batch_class_days_formatted = UtilityService::daysSeparator($batch->batch_class_days);

                    $data['course']['total_batch'] = $course->batches->count();
                    $data['course']['total_instructor'] = $course->batches->count();
                    $data['course']['total_student'] = 0;
                    $data['course']['student_list_id'] = array();
                    $course_instructor = array();
                    if (isset($course->batches)):
                        foreach ($course->batches as $batches):
                            if (isset($batches->instructor)) {
                                $course_instructor [] = array(
                                    'course_batch_id' => $batches->id,
                                    'instructor_name' => $batches->instructor->name,
                                    'instructor_mobile_number' => $batches->instructor->mobile_number,
                                    'instructor_email' => $batches->instructor->email,
                                    'instructor_detail_first_name' => $batches->instructor->userDetails->first_name ?? "",
                                    'instructor_detail_last_name' => $batches->instructor->userDetails->last_name ?? "",
                                    'instructor_detail_photo' => $batches->instructor->userDetails->user_detail_photo_full_link ?? "",
                                    'instructor_detail_bio' => "Hello there! Thanks for coming here and reading all about me, " . $batches->instructor->name . ". I'm a British trained teacher (Post-Graduate in Education and Cambridge qualified) and I'm really excited to meet you. My courses focus on teaching you strategies and skills for IELTS and English Language and also " . $course->courseCategory->course_category_title . " . I've taught thousands of students both in person and with my online courses and I'm really excited to share my knowledge with you, too. I love hearing from students so if feel free to drop me a message and say \"hello\". See you inside! ",
                                );
                            } else {

                                $course_instructor = [];
                            }
                            //dd($course_instructor,$course->batches);
                            $data['course']['total_student'] += $batches->student->count();
                            $data['course']['student_list_id'] = array_merge($data['course']['student_list_id'], $batches->student->pluck('id')->toArray());
                            $batches->makeHidden(['student']);
                        endforeach;
                    endif;
                    $data['course']['instructor_list'] = $course_instructor;

                    // batches details
                    $batch->branch;
                    $batch['instructor']['userDetails']['user_detail_photo'] = $batch->instructor->userDetails->user_detail_photo_full_link ?? "http://127.0.0.1:8000/assets/img/user-default.png";
                    $batch['instructor']['userDetails']['user_detail_bio'] = "Hello there! Thanks for coming here and reading all about me, " . $batch->instructor->name . ". I'm a British trained teacher (Post-Graduate in Education and Cambridge qualified) and I'm really excited to meet you. My courses focus on teaching you strategies and skills for IELTS and English Language and also . I've taught thousands of students both in person and with my online courses and I'm really excited to share my knowledge with you, too. I love hearing from students so if feel free to drop me a message and say \"hello\". See you inside! ";

                    $batchArray[] = $batch;
                endforeach;
            endif;
            $data['course']['batches'] = $batchArray;
            //$data['course']['instructor'] = $course->batches->instructor;
            $data['status'] = true;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Course data not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function edit($id): JsonResponse
    {
        try {
            $data['course'] = $this->courseService->courseById($id);
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $data['companies'] = $this->companyService->showAllCompany($companyWiseUser)->get();
            $data['course_categories'] = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            $data['course_sub_categories'] = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            $data['course_child_categories'] = $this->courseChildCategoryService->showAllCourseChildCategory($companyWiseUser)->get();
            $data['tags'] = $this->tagService->ShowAllTag($companyWiseUser)->get();
            $data['status'] = true;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Course data not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CourseRequest $request
     * @param $id
     * @return JsonResponse
     * @throws \Throwable
     */
    public function update(CourseRequest $request, $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $tags = [];
            if ($request->input('course_tags.*')) {
                $tags = $this->tagService->getAllTagId($request->input('course_tags.*'));
            }
            $data['course'] = $this->courseService->updateCourse($request, $tags, $id);
            if ($data['course']) {
                $data['status'] = true;
                $data['message'] = 'Course updated successfully!';
            } else {
                $data['status'] = false;
                $data['message'] = 'Failed to updated Course!';
            }
            $data['request'] = $request->all();
            $jsonReturn = response()->json($data, 200);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to create Course!'], 200);
        }
        return $jsonReturn;
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
            DB::beginTransaction();
            $user_get = $this->userService->whoIS($_REQUEST);
            if (isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id) {
                $course = $this->courseService->courseById($id);
                if ($course) {
                    $course->delete();
                    $data['message'] = 'Course deleted successfully';
                    $data['status'] = true;
                    $jsonReturn = response()->json($data, 200);
                } else {
                    $jsonReturn = response()->json(['status' => false, 'message' => 'Course not found!'], 200);
                }
            } else {
                flash('You Entered Wrong Password!')->error();
                $jsonReturn = response()->json(['status' => false, 'message' => 'You Entered Wrong Password!'], 200);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to deleted Course!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function getCourseList(Request $request): JsonResponse
    {
        Log::info($request->all());
        try {
            DB::beginTransaction();
            $request['course_status'] = Constants::$course_active_status;
            $request['is_batch'] = true;
            //$request['is_instructor'] = true;
            $companyWiseUser = []; //$this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser, $request->all());
            $requestData['course_sorting'] = 'desc';
            $coursesArray = array();
            $courses = $this->courseService->showAllCourse($requestData)->skip(0)->take(UtilityService::$displayRecordPerPage)->get();
            if (count($courses) > 0):
                foreach ($courses as $course):
                    //$coursesArray [] = $course;
                    $course->course_title = strtoupper($course->course_title);
                    $course->course_total_comment = $course->course_total_comment;
                    $course->course_rating_point = $course->course_rating_point;
                    $course->course_best_seller = 0;
                    $course->total_batch = $course->batches->count();
                    $course->total_instructor = $course->batches->count();
                    $course->total_student = 0;
                    $course_instructor = array();
                    $course->student_list_id = array();
                    foreach ($course->batches as $batches):
                        if (isset($batches->instructor)) {
                            $course_instructor [] = array(
                                'instructor_name' => $batches->instructor->name ?? "",
                                'instructor_mobile_number' => $batches->instructor->mobile_number ?? "",
                                'instructor_email' => $batches->instructor->email ?? "",
                                'instructor_detail_first_name' => $batches->instructor->userDetails->first_name ?? "",
                                'instructor_detail_last_name' => $batches->instructor->userDetails->last_name ?? "",
                            );
                        } else {
                            $course_instructor = [];
                        }


                        $course->total_student += $batches->student->count();
                        $course->student_list_id = $batches->student->pluck('id');
                        $batches->makeHidden(['student']);
                    endforeach;
                    $course->instructor = $course_instructor;
                    $coursesArray[] = $course->makeHidden('batches');
                endforeach;
                $data['courses'] = $coursesArray;
                $data['status'] = true;
            else:
                $data['status'] = false;
                $data['message'] = 'Data Not Found';
            endif;
            $data['request'] = $request->all();
            DB::commit();
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to found Course!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getCourseListWithPagination(Request $request): JsonResponse
    {
        Log::info($request->all());
        try {
            $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : UtilityService::$displayRecordPerPage;
            $request['course_status'] = Constants::$user_active_status;
            $request['is_batch'] = true;
            //@TODO get all course based to company
            $companyWiseUser = []; //$this->userService->user_role_display_for_api();
            //$data['companies'] = $this->companyService->showAllCompany($companyWiseUser)->get();
            //$data['course_categories'] = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            //$data['course_sub_categories'] = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            //$data['course_child_categories'] = $this->courseChildCategoryService->showAllCourseChildCategory($companyWiseUser)->get();

            $filters_option = (explode('-', $request->course_type));
            $request['course_option'] = $filters_option[0];
            if (isset($filters_option[1])) {
                $request['course_type'] = $filters_option[1];
            }

            $requestData = array_merge($companyWiseUser, $request->all());
            $coursesArray = array();
            $courses = $this->courseService->showAllCourse($requestData)->paginate($request->display_item_per_page);
            if (count($courses) > 0):
                foreach ($courses as $course):
                    //$coursesArray [] = $course;
                    $course->course_title = strtoupper($course->course_title);
                    $course->course_total_comment = $course->course_total_comment;
                    $course->course_rating_point = $course->course_rating_point;
                    $course->course_best_seller = 0;
                    $course->total_batch = $course->batches->count();
                    $course->total_instructor = $course->batches->count();
                    $course->total_student = 0;
                    $course_instructor = array();
                    $course->student_list_id = array();
                    foreach ($course->batches as $batches):

                        if (isset($batches->instructor)) {
                            $course_instructor [] = array(
                                'instructor_name' => $batches->instructor->name ?? "",
                                'instructor_mobile_number' => $batches->instructor->mobile_number ?? "",
                                'instructor_email' => $batches->instructor->email ?? "",
                                'instructor_detail_first_name' => $batches->instructor->userDetails->first_name ?? "",
                                'instructor_detail_last_name' => $batches->instructor->userDetails->last_name ?? "",
                            );
                        } else {
                            $course_instructor = [];
                        }
                        // $course_instructor [] = array(
                        //     'instructor_name' => $batches->instructor->name ?? "",
                        //     'instructor_mobile_number' => $batches->instructor->mobile_number ?? "",
                        //     'instructor_email' => $batches->instructor->email ?? "",
                        //     'instructor_detail_first_name' => $batches->instructor->userDetails->first_name ?? "",
                        //     'instructor_detail_last_name' => $batches->instructor->userDetails->last_name ?? "",
                        // );

                        $course->total_student += $batches->student->count();
                        $course->student_list_id = $batches->student->pluck('id');
                        $batches->makeHidden(['student']);
                    endforeach;
                    $course->instructor = $course_instructor;
                    $coursesArray[] = $course->makeHidden('batches');
                endforeach;
                $paginate_properties = json_decode($courses->toJSON());
                $data['courses']['current_page'] = $paginate_properties->current_page;
                $data['courses']['data'] = $coursesArray;
                $data['courses']['first_page_url'] = $paginate_properties->first_page_url;
                $data['courses']['from'] = $paginate_properties->from;
                $data['courses']['last_page'] = $paginate_properties->last_page;
                $data['courses']['last_page_url'] = $paginate_properties->last_page_url;
                $data['courses']['next_page_url'] = $paginate_properties->next_page_url;
                $data['courses']['path'] = $paginate_properties->path;
                $data['courses']['per_page'] = $paginate_properties->per_page;
                $data['courses']['prev_page_url'] = $paginate_properties->prev_page_url;
                $data['courses']['to'] = $paginate_properties->to;
                $data['courses']['total'] = $paginate_properties->total;
                $data['request'] = $request->all();
                $data['status'] = true;
                $data['request'] = $request->all();
                $data['status'] = true;
            else:
                $data['status'] = false;
                $data['message'] = 'Data Not Found';
            endif;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Course table not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function getMyCourseList(Request $request): JsonResponse
    {
        Log::info($request->all());
        try {
            DB::beginTransaction();
            $request['course_status'] = Constants::$course_active_status;
            $request['is_batch'] = true;
            //$request['is_instructor'] = true;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser, $request->all());
            $coursesArray = array();
            $courses = $this->courseService->showAllCourse($requestData)->skip(0)->take(\Utility::$displayRecordPerPage)->get();
            if (count($courses) > 0):
                foreach ($courses as $course):
                    //$coursesArray [] = $course;
                    $course->course_title = strtoupper($course->course_title);
                    $course->course_total_comment = $course->course_total_comment;
                    $course->course_rating_point = $course->course_rating_point;
                    $course->course_best_seller = 0;
                    $course->total_batch = $course->batches->count();
                    $course->total_instructor = $course->batches->count();
                    $course->total_student = 0;
                    $course_instructor = array();
                    $course->student_list_id = array();
                    foreach ($course->batches as $batches):
                        $course_instructor [] = array(
                            'instructor_name' => $batches->instructor->name,
                            'instructor_mobile_number' => $batches->instructor->mobile_number,
                            'instructor_email' => $batches->instructor->email,
                            'instructor_detail_first_name' => $batches->instructor->userDetails->first_name,
                            'instructor_detail_last_name' => $batches->instructor->userDetails->last_name,
                        );

                        $course->total_student += $batches->student->count();
                        $course->student_list_id = $batches->student->pluck('id');
                        $batches->makeHidden(['student']);
                    endforeach;
                    $course->instructor = $course_instructor;
                    $coursesArray[] = $course->makeHidden('batches');
                endforeach;
                $data['courses'] = $coursesArray;
                $data['status'] = true;
            else:
                $data['status'] = false;
                $data['message'] = 'Data Not Found';
            endif;
            $data['request'] = $request->all();
            DB::commit();
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Failed to found Course!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getMyCourseListWithPagination(Request $request): JsonResponse
    {
        Log::info($request->all());
        try {
            $request->display_item_per_page = $request->display_item_per_page ?? \Utility::$displayRecordPerPage;
            $request['course_status'] = Constants::$user_active_status;
            $request['is_batch'] = true;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            //$data['companies'] = $this->companyService->showAllCompany($companyWiseUser)->get();
            //$data['course_categories'] = $this->courseCategoryService->showAllCourseCategory($companyWiseUser)->get();
            //$data['course_sub_categories'] = $this->courseSubCategoryService->showAllCourseSubCategory($companyWiseUser)->get();
            //$data['course_child_categories'] = $this->courseChildCategoryService->showAllCourseChildCategory($companyWiseUser)->get();
            $requestData = array_merge($companyWiseUser, $request->all());
            $coursesArray = array();
            $courses = $this->courseService->showAllCourse($requestData)->paginate($request->display_item_per_page);
            if (count($courses) > 0):
                foreach ($courses as $course):
                    //$coursesArray [] = $course;
                    $course->course_title = strtoupper($course->course_title);
                    $course->course_total_comment = $course->course_total_comment;
                    $course->course_rating_point = $course->course_rating_point;
                    $course->course_best_seller = 0;
                    $course->total_batch = $course->batches->count();
                    $course->total_instructor = $course->batches->count();
                    $course->total_student = 0;
                    $course_instructor = array();
                    $course->student_list_id = array();
                    foreach ($course->batches as $batches):
                        $course_instructor [] = array(
                            'instructor_name' => $batches->instructor->name,
                            'instructor_mobile_number' => $batches->instructor->mobile_number,
                            'instructor_email' => $batches->instructor->email,
                            'instructor_detail_first_name' => $batches->instructor->userDetails->first_name,
                            'instructor_detail_last_name' => $batches->instructor->userDetails->last_name,
                        );

                        $course->total_student += $batches->student->count();
                        $course->student_list_id = $batches->student->pluck('id');
                        $batches->makeHidden(['student']);
                    endforeach;
                    $course->instructor = $course_instructor;
                    $coursesArray[] = $course->makeHidden('batches');
                endforeach;
                $paginate_properties = json_decode($courses->toJSON());
                $data['courses']['current_page'] = $paginate_properties->current_page;
                $data['courses']['data'] = $coursesArray;
                $data['courses']['first_page_url'] = $paginate_properties->first_page_url;
                $data['courses']['from'] = $paginate_properties->from;
                $data['courses']['last_page'] = $paginate_properties->last_page;
                $data['courses']['last_page_url'] = $paginate_properties->last_page_url;
                $data['courses']['next_page_url'] = $paginate_properties->next_page_url;
                $data['courses']['path'] = $paginate_properties->path;
                $data['courses']['per_page'] = $paginate_properties->per_page;
                $data['courses']['prev_page_url'] = $paginate_properties->prev_page_url;
                $data['courses']['to'] = $paginate_properties->to;
                $data['courses']['total'] = $paginate_properties->total;
                $data['request'] = $request->all();
                $data['status'] = true;
                $data['request'] = $request->all();
                $data['status'] = true;
            else:
                $data['status'] = false;
                $data['message'] = 'Data Not Found';
            endif;
            $jsonReturn = response()->json($data, 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $jsonReturn = response()->json(['status' => false, 'message' => 'Course table not found!'], 200);
        }
        return $jsonReturn;
    }


    public function assignFreeCourseToUser(Request $request): JsonResponse
    {
        \DB::beginTransaction();
        try {
            $jsonResponse = $this->courseService->assignCourseTOUser($request->except('_token'));
            \DB::commit();
            return response()->json($jsonResponse, 200);
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            \DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Something went wrong.'], 200);
        }
    }
}
