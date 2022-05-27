<?php


namespace App\Services\Backend\CourseManage;


use App\Repositories\Backend\CourseManage\CourseBatchRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CourseBatchService
{
    /**
     * @var CourseBatchRepository
     */
    private $courseBatchRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * CourseBatchService constructor.
     * @param CourseBatchRepository $courseBatchRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(CourseBatchRepository $courseBatchRepository, FileUploadService $fileUploadService)
    {
        $this->courseBatchRepository = $courseBatchRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @param $course
     * @return false|mixed
     */
    public function createCourseBatch($input, $course)
    {
        try {
            //only for online recorded course
            $input['course_batch_start_date'] = date('Y-m-d');
            $input['course_batch_end_date'] = '9999-12-31';

            //for everyone else
            if (isset($input['course_batch_duration'])) {
                $dates = explode(' - ', $input['course_batch_duration']);
                $input['course_batch_start_date'] = $dates[0];
                $input['course_batch_end_date'] = $dates[1];
            }

            $input['batch_class_days'] = implode(',', array_keys(UtilityService::$working_days));
            $input['course_batch_name'] = $input['course_batch_name'] ?? $course->course_title;
            $input['course_id'] = $course->id;
            return $this->courseBatchRepository->create($input);
        } catch (ModelNotFoundException $e) {
            \Log::error('Course Batch not found');
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @param $course_batch_name
     * @return false|mixed
     */
    public function updateCourseBatch($input, $id, $course_batch_name)
    {
        try {
            if (isset($course_batch_name) && $course_batch_name != '') {
                $input['course_batch_name'] = $course_batch_name;
            }

            if (isset($input['course_batch_duration']) && isset($input['batch_class_days'])) {
                $date_range = explode(' - ', $input['course_batch_duration']);

                $start = $date_range[0] ?? null;
                $end = $date_range[1] ?? null;
                $input['course_batch_start_date'] = $start;
                $input['course_batch_end_date'] = $end;
                $input['batch_class_days'] = implode(',', $input['batch_class_days']);

                unset($input['course_batch_duration']);
            }

            $courseBatch = $this->courseBatchRepository->find($id);
            $this->courseBatchRepository->update($input, $id);
            return $courseBatch;
        } catch (ModelNotFoundException $e) {
            \Log::error('Course Batch not found');
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCourseBatch($id)
    {
        return $this->courseBatchRepository->delete($id);
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function showAllCourseBatch($input): \Illuminate\Database\Eloquent\Builder
    {
        return $this->courseBatchRepository->courseBatchFilterData($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function courseBatchById($id)
    {
        return $this->courseBatchRepository->find($id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function courseBatchLogo($input): ?string
    {
        $data['image'] = $input->file('course_batch_logo');
        $data['image_name'] = 'course_batch_logo_' . $input['course_batch_id'] . "_" . date('Y_m_d_h_i_s');
        $data['destination'] = UtilityService::$imageUploadPath['course_batch_logo'];
        $data['width'] = UtilityService::$courseBatchLogoSize['width'];
        $data['height'] = UtilityService::$courseBatchLogoSize['height'];
        $img = $this->fileUploadService->savePhoto($data);
        return $img;
    }

    /**
     * @param array $data
     * @return \App\Models\Backend\Course\CourseBatch|false|int|null
     */
    public function assignCourseBatchToStudent(array $data)
    {
        try {
            $courseBatch = $this->courseBatchRepository->find($data['course_batch_id']);
            return $this->courseBatchRepository->manageCourseBatchToStudent($courseBatch, $data);
        } catch (ModelNotFoundException $e) {
            return null;
        } catch (Exception $e) {
            return false;
        }
    }
}
