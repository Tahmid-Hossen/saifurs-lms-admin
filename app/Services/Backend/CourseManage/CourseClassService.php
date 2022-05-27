<?php

namespace App\Services\Backend\CourseManage;

use App\Repositories\Backend\CourseManage\CourseClassRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;


class CourseClassService
{
    /**
     * @var CourseClassRepository
     */
    private $courseClassRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * CourseChapterService constructor.
     * @param CourseClassRepository $courseClassRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(CourseClassRepository $courseClassRepository, FileUploadService $fileUploadService)
    {
        $this->courseClassRepository = $courseClassRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createCourseClass($input)
    {
        // dd($input);
        // try {
            return $this->courseClassRepository->firstOrCreate($input);
        // } catch (ModelNotFoundException $e) {
        //    \Log::error('Course Class not found');
        // } catch (\Exception $e) {
        //    \Log::error($e->getMessage());
        // }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateCourseClass($input, $id)
    {
        try{
            $course_class = $this->courseClassRepository->find($id);
            // dd($course_class);
            $this->courseClassRepository->update($input, $id);
            return $course_class;
        } catch (ModelNotFoundException $e) {
           \Log::error('Course Class not found');
        } catch (\Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCourseClass($id)
    {
        return $this->courseClassRepository->delete($id);
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function showAllCourseClass($input)
    {
        return $this->courseClassRepository->courseClass($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function courseClassById($id)
    {
        return $this->courseClassRepository->find($id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function courseClassImage($input)
    {
        // dd($input);
        $data['image'] = $input->file('class_image');
        $data['image_name'] = 'course_class_image_'.$input['class_id']."_".date('Y_m_d_h_i_s');
        $data['destination'] = UtilityService::$imageUploadPath['course_class_image'];
        $img = $this->fileUploadService->savePhoto($data);
        return $img;
    }

    public function courseClassFile($input)
    {
        $data['file'] = $input->file('class_file');
        $data['file_name'] = 'file_name_' . $input['class_id']."_".date('Y_m_d_h_i_s');
        $data['destination'] = UtilityService::$FilesUploadPath['course_class_file'];
        $data['max'] = UtilityService::$FileSize['max'];
        $class_file = $this->fileUploadService->saveFiles($data);
        return $class_file;
    }

    public function courseClassVideo($input)
    {
        $data['file'] = $input->file('class_video');
        $data['file_name'] = 'file_name_' . $input['class_id']."_".date('Y_m_d_h_i_s');
        $data['destination'] = UtilityService::$FilesUploadPath['course_class_video'];
        // $data['min'] = UtilityService::$FileSize['min'];
        $class_video = $this->fileUploadService->saveFiles($data);
        return $class_video;
    }

}
