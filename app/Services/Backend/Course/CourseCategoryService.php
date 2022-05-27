<?php


namespace App\Services\Backend\Course;


use App\Repositories\Backend\Course\CourseCategoryRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class CourseCategoryService
{
    /**
     * @var CourseCategoryRepository
     */
    private $courseCategoryRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * CourseCategoryService constructor.
     * @param CourseCategoryRepository $courseCategoryRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(CourseCategoryRepository $courseCategoryRepository, FileUploadService $fileUploadService)
    {
        $this->courseCategoryRepository = $courseCategoryRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createCourseCategory($input)
    {
        try {
            return $this->courseCategoryRepository->firstOrCreate($input);
        } catch (ModelNotFoundException $e) {
           \Log::error('Course Category not found');
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
    public function updateCourseCategory($input, $id)
    {
        try {
            $courseCategory = $this->courseCategoryRepository->find($id);
            $this->courseCategoryRepository->update($input, $id);
            return $courseCategory;
        } catch (ModelNotFoundException $e) {
           \Log::error('Course Category not found');
        } catch (Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCourseCategory($id)
    {
        return $this->courseCategoryRepository->delete($id);
    }

    /**
     * @param $input
     * @return Builder
     */
    public function showAllCourseCategory($input)
    {
        return $this->courseCategoryRepository->courseCategory($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function courseCategoryById($id)
    {
        return $this->courseCategoryRepository->find($id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function courseCategoryImage($input)
    {
        $data['image'] = $input->file('course_category_image');
        $data['image_name'] = 'course_category_image_' . $input['course_category_id'];
        $data['destination'] = UtilityService::$imageUploadPath['course_category_image'];
        $data['width'] = UtilityService::$companyLogoSize['width'];
        $data['height'] = UtilityService::$companyLogoSize['height'];
        $img = $this->fileUploadService->savePhoto($data);
        return $img;
    }

}
