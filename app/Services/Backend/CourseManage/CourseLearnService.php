<?php

namespace App\Services\Backend\CourseManage;

use App\Repositories\Backend\CourseManage\CourseLearnRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;


class CourseLearnService
{
    /**
     * @var CourseLearnRepository
     */
    private $courseLearnRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * CourseLearnService constructor.
     * @param CourseLearnRepository $courseLearnRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(CourseLearnRepository $courseLearnRepository, FileUploadService $fileUploadService)
    {
        $this->courseLearnRepository = $courseLearnRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createCourseLearn($input)
    {
        // dd($input);
        try {
            return $this->courseLearnRepository->firstOrCreate($input);
        } catch (ModelNotFoundException $e) {
           \Log::error('Learn not found');
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
    public function updateCourseLearn($input, $id)
    {
        try{
            $course_Learn = $this->courseLearnRepository->find($id);
            // dd($course_Learn);
            $this->courseLearnRepository->update($input, $id);
            return $course_Learn;
        } catch (ModelNotFoundException $e) {
           \Log::error('Learn not found');
        } catch (\Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCourseLearn($id)
    {
        return $this->courseLearnRepository->delete($id);
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function showAllCourseLearn($input)
    {
        return $this->courseLearnRepository->courseLearn($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function courseLearnById($id)
    {
        return $this->courseLearnRepository->find($id);
    }

}
