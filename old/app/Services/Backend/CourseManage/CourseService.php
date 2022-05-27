<?php


namespace App\Services\Backend\CourseManage;


use App\Http\Requests\Backend\CourseManage\CourseRequest;
use App\Models\Backend\Course\Course;
use App\Repositories\Backend\CourseManage\CourseBatchRepository;
use App\Repositories\Backend\CourseManage\CourseRepository;
use App\Repositories\Backend\Enrollment\EnrollmentRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use File;

class CourseService
{
    /**
     * @var CourseRepository
     */
    private $courseRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;
    /**
     * @var EnrollmentRepository
     */
    private $enrollmentRepository;
    /**
     * @var CourseBatchRepository
     */
    private $courseBatchRepository;

    /**
     * CourseCategoryService constructor.
     * @param CourseRepository $courseRepository
     * @param FileUploadService $fileUploadService
     * @param EnrollmentRepository $enrollmentRepository
     * @param CourseBatchRepository $courseBatchRepository
     */
    public function __construct(CourseRepository      $courseRepository,
                                FileUploadService     $fileUploadService,
                                EnrollmentRepository  $enrollmentRepository,
                                CourseBatchRepository $courseBatchRepository
    )
    {
        $this->courseRepository = $courseRepository;
        $this->fileUploadService = $fileUploadService;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->courseBatchRepository = $courseBatchRepository;
    }

    /**
     * @param CourseRequest $request
     * @param array $tags
     * @return bool|mixed
     * @throws \Exception
     */
    public function createCourse(CourseRequest $request, array $tags)
    {
        try {

            $course_data = $request->except(['course_image', 'course_file', 'course_video', '_token', 'course_tags']);

            $course = $this->courseRepository->create($course_data);
            $request['course_id'] = $course->id;
            if ($request->hasFile('course_image')) {
                $course->course_image = $this->courseImage($request) ?? null;
            }
            if ($request->hasFile('course_file')) {
                $course->course_file = $this->courseFile($request) ?? null;
            }
            if ($request->hasFile('course_video')) {
                $course->course_video = $this->courseVideo($request) ?? null;
            }

            $course->save();

            if (!empty($tags)) {
                $this->courseRepository->manageTags($course, $tags);
            }
            return $course;
        } catch (ModelNotFoundException $e) {
            \Log::error('Course not found');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param CourseRequest $request
     * @param array $tags
     * @param int $id
     * @return bool|mixed
     */
    public function updateCourse(CourseRequest $request, array $tags, int $id)
    {

        try {
            // $course = $this->courseRepository->find($id);
            $course_data = $request->except(['course_image', 'course_file', 'course_video', '_token', 'course_tags']);

            $course = $this->courseRepository->update($course_data, $id);
            $request['course_id'] = $id;
            if ($request->hasFile('course_image')) {
                $course->course_image = $this->courseImage($request) ?? null;
            }
            if ($request->hasFile('course_file')) {
                $file = $course->course_file;

                if (\File::exists(public_path($file))) {
                    \File::delete(public_path($file));
                }
                $course->course_file = $this->courseFile($request) ?? null;
            }
            if ($request->hasFile('course_video')) {
                $video = $course->course_video;

                if (\File::exists(public_path($video))) {
                    \File::delete(public_path($video));
                }
                $course->course_video = $this->courseVideo($request) ?? null;
            }

            if($course->course_option == "Offline") {
                $course->course_type = NULL;
            }

            $course->save();

            if (!empty($tags)) {
                $this->courseRepository->manageTags($course, $tags);
            }
            return $course;
        } catch (ModelNotFoundException $e) {
            \Log::error('Course not found');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCourse($id)
    {
        return $this->courseRepository->delete($id);
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function showAllCourse($input)
    {
        return $this->courseRepository->course($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function courseById($id)
    {
        return $this->courseRepository->find($id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function courseImage($input)
    {
        $data['image'] = $input->file('course_image');
        $data['image_name'] = 'course_image_' . $input['course_id'] . "_" . date('Y_m_d_h_i_s');
        $data['destination'] = UtilityService::$imageUploadPath['course_image'];
        $data['width'] = UtilityService::$courseImageSize['width'];
        $data['height'] = UtilityService::$courseImageSize['height'];
        $img = $this->fileUploadService->savePhoto($data);
        return $img;
    }

    /**
     * @param $input
     * @return string|null
     */
    public function courseFile($input)
    {
        $data['file'] = $input->file('course_file');
        $data['file_name'] = 'file_name_' . $input['course_id'] . "_" . date('Y_m_d_h_i_s');
        $data['destination'] = UtilityService::$FilesUploadPath['course_file'];
        $data['max'] = UtilityService::$FileSize['max'];
        $c_file = $this->fileUploadService->saveFiles($data);
        return $c_file;
    }

    public function courseVideo($input)
    {
        $data['file'] = $input->file('course_video');
        $data['file_name'] = 'file_name_' . $input['course_id'] . "_" . date('Y_m_d_h_i_s');
        $data['destination'] = UtilityService::$FilesUploadPath['course_video'];
        // $data['min'] = UtilityService::$FileSize['min'];
        $c_file = $this->fileUploadService->saveFiles($data);
        return $c_file;
    }


    /**
     * @param array $inputs
     * @return bool
     */
    public function enrollCourseToUser(array $inputs): bool
    {
        try {

            //Add User To Enroll List
            $enrollmentData = [
                'company_id' => $inputs['company_id'] ?? null,
                'course_id' => $inputs['course_id'] ?? null,
                'user_id' => $inputs['user_id'] ?? null,
                'batch_id' => $inputs['batch_id'] ?? null,
                'order_id' => '',
                'enroll_details' => 'free course enrollment' ?? '',
                'enroll_status' => 'ACTIVE'
            ];
            return (bool)$this->enrollmentRepository->create($enrollmentData);
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return false;
        }
    }

    public function assignCourseTOUser(array $inputs): array
    {
        try {
            if (isset($inputs['course_id']) && isset($inputs['user_id']) && isset($inputs['batch_id'])) {
                $course_id = $inputs['course_id'];
                $batch_id = $inputs['batch_id'];
                $user_id = $inputs['user_id'];

                $course = $this->courseRepository->find($course_id);
                $inputs = [
                    'user_id' => $user_id,
                    'course_id' => $course_id,
                    'batch_id' => $batch_id,
                    'company_id' => $course->company_id
                ];

                if ($this->enrollCourseToUser($inputs)) {
                    $batch = $this->courseBatchRepository->find($batch_id);
                    $batch->student()->syncWithoutDetaching($user_id);
                    if ($batch->save()) {
                        return ['status' => true, 'message' => 'course and batch assigned to user'];
                    } else {
                        return ['status' => false, 'message' => 'Course and Batch assigned to user failed'];
                    }
                }
            }
            return ['status' => false, 'message' => 'Course or User information missing'];
        } catch (ModelNotFoundException | \Exception $exception) {
            \Log::error($exception->getMessage());
            return ['status' => false, 'message' => $exception->getMessage()];
        }
    }
}
