<?php

namespace App\Services\Backend\Enrollment;

use App\Repositories\Backend\CourseManage\CourseBatchRepository;
use App\Repositories\Backend\Enrollment\EnrollmentRepository;
use App\Services\FileUploadService;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class EnrollmentService
{
    /**
     * @var EnrollmentRepository
     */
    private $enrollmentRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;
    /**
     * @var CourseBatchRepository
     */
    private $courseBatchRepository;

    /**
     * CourseLearnService constructor.
     * @param EnrollmentRepository $enrollmentRepository
     * @param FileUploadService $fileUploadService
     * @param CourseBatchRepository $courseBatchRepository
     */
    public function __construct(EnrollmentRepository $enrollmentRepository,
                                FileUploadService $fileUploadService,
                                CourseBatchRepository $courseBatchRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
        $this->fileUploadService = $fileUploadService;
        $this->courseBatchRepository = $courseBatchRepository;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createEnrollment($input)
    {
        try {
            if (!empty($input['user_id']) && !empty($input['batch_id'])) {
                $courseBatch = $this->courseBatchRepository->find($input['batch_id']);
                if ($courseBatch = $this->courseBatchRepository->manageCourseBatchToStudent($courseBatch, ['student_id' => $input['user_id']])) {
                    return $this->enrollmentRepository->firstOrCreate($input);
                }
            }
        } catch (ModelNotFoundException $e) {
            \Log::error('Enrollment not found');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateEnrollment($input, $id)
    {
        try {
            if ($enrollment = $this->enrollmentRepository->find($id)) {
                if (!empty($input['user_id']) && !empty($input['batch_id'])) {
                    $courseBatch = $this->courseBatchRepository->find($input['batch_id']);
                    if ($courseBatch = $this->courseBatchRepository->manageCourseBatchToStudent($courseBatch, ['student_id' => $input['user_id']])) {
                        return $this->enrollmentRepository->update($input, $id);
                    }
                }
            }
        } catch (ModelNotFoundException $e) {
            \Log::error('Enrollment not found');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteEnrollment($id)
    {
        return $this->enrollmentRepository->delete($id);
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function showAllEnrollment($input)
    {
        return $this->enrollmentRepository->enrollment($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function enrollmentById($id)
    {
        return $this->enrollmentRepository->find($id);
    }
}
