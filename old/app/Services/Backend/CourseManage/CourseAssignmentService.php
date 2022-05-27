<?php


namespace App\Services\Backend\CourseManage;


use App\Repositories\Backend\CourseManage\CourseAssignmentRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Exception;

class CourseAssignmentService
{
    /**
     * @var CourseAssignmentRepository
     */
    private $courseAssignmentRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * CourseAssignmentService constructor.
     * @param CourseAssignmentRepository $courseAssignmentRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(CourseAssignmentRepository $courseAssignmentRepository, FileUploadService $fileUploadService)
    {
        $this->courseAssignmentRepository = $courseAssignmentRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createCourseAssignment($input)
    {
        try {
            return $this->courseAssignmentRepository->firstOrCreate($input);
        } catch (ModelNotFoundException $e) {
            \Log::error('Course Assignment not found');
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateCourseAssignment($input, $id)
    {
        try {
            $courseAssignment = $this->courseAssignmentRepository->find($id);
            $this->courseAssignmentRepository->update($input, $id);
            return $courseAssignment;
        } catch (ModelNotFoundException $e) {
            \Log::error('Course Assignment not found');
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCourseAssignment($id)
    {
        return $this->courseAssignmentRepository->delete($id);
    }

    /**
     * @param $input
     * @return Builder
     */
    public function showAllCourseAssignment($input)
    {
        return $this->courseAssignmentRepository->courseAssignmentFilterData($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function courseAssignmentById($id)
    {
        return $this->courseAssignmentRepository->find($id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function courseAssignmentLogo($input)
    {
        $data['file'] = $input->file('course_assignment_document');
        $data['file_name'] = 'course_assignment_document_' . $input['course_assignment_id']."_".date('Y_m_d_h_i_s');
        $data['destination'] = UtilityService::$imageUploadPath['course_assignment_document'];
        $img = $this->fileUploadService->saveFiles($data);
        return $img;
    }
}
