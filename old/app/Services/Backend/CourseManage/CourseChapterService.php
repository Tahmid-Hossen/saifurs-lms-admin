<?php

namespace App\Services\Backend\CourseManage;

use App\Repositories\Backend\CourseManage\CourseChapterRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;


class CourseChapterService
{
    /**
     * @var CourseChapterRepository
     */
    private $courseChapterRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * CourseChapterService constructor.
     * @param CourseChapterRepository $courseChapterRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(CourseChapterRepository $courseChapterRepository, FileUploadService $fileUploadService)
    {
        $this->courseChapterRepository = $courseChapterRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createCourseChapter($input)
    {
        try {
            return $this->courseChapterRepository->firstOrCreate($input);
        } catch (ModelNotFoundException $e) {
           \Log::error('Course Chapter not found');
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
    public function updateCourseChapter($input, $id)
    {
        try{
            $course_chapter = $this->courseChapterRepository->find($id);
            $this->courseChapterRepository->update($input, $id);
            return $course_chapter;
        } catch (ModelNotFoundException $e) {
           \Log::error('Course Chapter not found');
        } catch (\Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCourseChapter($id)
    {
        return $this->courseChapterRepository->delete($id);
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function showAllCourseChapter($input)
    {
        return $this->courseChapterRepository->courseChapter($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function courseChapterById($id)
    {
        return $this->courseChapterRepository->find($id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function courseChapterImage($input)
    {
        $data['image'] = $input->file('chapter_image');
        $data['image_name'] = 'course_chapter_image_'.$input['chapter_id']."_".date('Y_m_d_h_i_s');
        $data['destination'] = UtilityService::$imageUploadPath['course_chapter_image'];
        $img = $this->fileUploadService->savePhoto($data);
        return $img;
    }

    public function courseChapterFile($input)
    {
        $data['file'] = $input->file('chapter_file');
        $data['file_name'] = 'file_name_' . $input['course_chapter_id']."_".date('Y_m_d_h_i_s');
        $data['destination'] = UtilityService::$FilesUploadPath['course_chapter_file'];
        $data['max'] = UtilityService::$FileSize['max'];
        $chapter_file = $this->fileUploadService->saveFiles($data);
        return $chapter_file;
    }



}
