<?php

namespace App\Services\Backend\Course;

use App\Repositories\Backend\Course\CourseChildCategoryRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;


class CourseChildCategoryService
{
    /**
     * @var CourseChildCategoryRepository
     */
    private $courseChildCategoryRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * CourseCategoryService constructor.
     * @param CourseChildCategoryRepository $courseChildCategoryRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(CourseChildCategoryRepository $courseChildCategoryRepository, FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
        $this->courseChildCategoryRepository = $courseChildCategoryRepository;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createCourseChildCategory($input)
    {
        try {
            return $this->courseChildCategoryRepository->firstOrCreate($input);
        } catch (ModelNotFoundException $e) {
            \Log::error('Course Child Category not found');
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
    public function updateCourseChildCategory($input, $id)
    {
        try{
            $course_child_category = $this->courseChildCategoryRepository->find($id);
            // dd($course_child_category);
            $this->courseChildCategoryRepository->update($input, $id);
            return $course_child_category;
        } catch (ModelNotFoundException $e) {
            \Log::error('Course Child Category not found');
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCourseChildCategory($id)
    {
        return $this->courseChildCategoryRepository->delete($id);
    }


    public function showAllCourseChildCategory($input)
    {
        return $this->courseChildCategoryRepository->courseChildCategory($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function courseChildCategoryById($id)
    {
        return $this->courseChildCategoryRepository->find($id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function courseChildCategoryImage($input)
    {
        // dd($input);
        $data['image'] = $input->file('course_child_category_image');
        $data['image_name'] = 'course_child_category_image_'.$input['course_child_category_id'];
        $data['destination'] = UtilityService::$imageUploadPath['course_child_category_image'];
        $data['width'] = UtilityService::$companyLogoSize['width'];
        $data['height'] = UtilityService::$companyLogoSize['height'];
        $img = $this->fileUploadService->savePhoto($data);
        // dd($img);
        return $img;
    }

    // public function courseChildCategorySlug($input)
    // {
    //     $slug = Str::slug($input->course_child_category_title);
    //     return response()->json(['course_child_category_slug' => $slug]);
    //     // return $slug;
    // }



}
