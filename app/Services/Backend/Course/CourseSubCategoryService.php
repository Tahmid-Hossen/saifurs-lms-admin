<?php

namespace App\Services\Backend\Course;

use App\Repositories\Backend\Course\CourseSubCategoryRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class CourseSubCategoryService
{
    /**
     * @var CourseSubCategoryRepository
     */
    private $courseSubCategoryRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * CourseCategoryService constructor.
     * @param CourseSubCategoryRepository $courseSubCategoryRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(CourseSubCategoryRepository $courseSubCategoryRepository, FileUploadService $fileUploadService)
    {
        $this->courseSubCategoryRepository = $courseSubCategoryRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createCourseSubCategory($input)
    {
        try {
            return $this->courseSubCategoryRepository->firstOrCreate($input);
        } catch (ModelNotFoundException $e) {
           \Log::error('Course Sub Category not found');
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
    public function updateCourseSubCategory($input, $id)
    {
        try {
            $course_sub_category = $this->courseSubCategoryRepository->find($id);
            // dd($course_sub_category);
            $this->courseSubCategoryRepository->update($input, $id);
            return $course_sub_category;
        } catch (ModelNotFoundException $e) {
           \Log::error('Course Sub Category not found');
        } catch (Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCourseSubCategory($id)
    {
        return $this->courseSubCategoryRepository->delete($id);
    }

    /**
     * @param $input
     * @return Builder
     */
    public function showAllCourseSubCategory($input)
    {
        return $this->courseSubCategoryRepository->courseSubCategory($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function courseSubCategoryById($id)
    {
        return $this->courseSubCategoryRepository->find($id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function courseSubCategoryImage($input)
    {
        // dd($input);
        $data['image'] = $input->file('course_sub_category_image');
        $data['image_name'] = 'course_sub_category_image_' . $input['course_sub_category_id'];
        $data['destination'] = UtilityService::$imageUploadPath['course_sub_category_image'];
        $data['width'] = UtilityService::$companyLogoSize['width'];
        $data['height'] = UtilityService::$companyLogoSize['height'];
        $img = $this->fileUploadService->savePhoto($data);
        // dd($img);
        return $img;
    }

}
