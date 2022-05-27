<?php

namespace App\Services\Backend\CourseManage;

use App\Repositories\Backend\CourseManage\CourseProgressRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CourseProgressService
{
    /**
     * @var CourseProgressRepository
     */
    private $courseProgressRepository;

    /**
     * CourseProgressService constructor.
     *
     * @param CourseProgressRepository $courseProgressRepository
     */
    public function __construct(CourseProgressRepository $courseProgressRepository)
    {
        $this->courseProgressRepository = $courseProgressRepository;
    }

    /**
     * @param $input
     * @return false|mixed
     */
    public function createCourseProgress($input)
    {
        try {
            return $this->courseProgressRepository->firstOrCreate($input);
        } catch (ModelNotFoundException $e) {
            \Log::error('Course Progress not found');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return false|mixed
     */
    public function updateCourseProgress($input, $id)
    {
        try {
            $courseProgress = $this->courseProgressRepository->find($id);
            $this->courseProgressRepository->update($input, $id);
            return $courseProgress;
        } catch (ModelNotFoundException $e) {
            \Log::error('Course Progress not found');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCourseProgress($id)
    {
        return $this->courseProgressRepository->delete($id);
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function showAllCourseProgress($input): \Illuminate\Database\Eloquent\Builder
    {
        return $this->courseProgressRepository->courseProgressFilterData($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function courseProgressById($id)
    {
        return $this->courseProgressRepository->find($id);
    }
}
