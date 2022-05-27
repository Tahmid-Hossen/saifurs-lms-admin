<?php

namespace App\Services\Backend\CourseManage;

use App\Repositories\Backend\CourseManage\CourseSyllabusRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;


class CourseSyllabusService
{
    /**
     * @var CourseSyllabusRepository
     */
    private $courseSyllabusRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * CourseSyllabusService constructor.
     * @param CourseSyllabusRepository $courseSyllabusRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(CourseSyllabusRepository $courseSyllabusRepository, FileUploadService $fileUploadService)
    {
        $this->courseSyllabusRepository = $courseSyllabusRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createCourseSyllabus($input)
    {
        // dd($input);
        try {
            return $this->courseSyllabusRepository->firstOrCreate($input);
        } catch (ModelNotFoundException $e) {
           \Log::error('Syllabus not found');
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
    public function updateCourseSyllabus($input, $id)
    {
        try{
            $course_syllabus = $this->courseSyllabusRepository->find($id);
            // dd($course_syllabus);
            $this->courseSyllabusRepository->update($input, $id);
            return $course_syllabus;
        } catch (ModelNotFoundException $e) {
           \Log::error('Syllabus not found');
        } catch (\Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCourseSyllabus($id)
    {
        return $this->courseSyllabusRepository->delete($id);
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function showAllCourseSyllabus($input)
    {
        return $this->courseSyllabusRepository->courseSyllabus($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function courseSyllabusById($id)
    {
        return $this->courseSyllabusRepository->find($id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function courseSyllabusFile($input)
    {
        // dd($input);
        $data['file'] = $input->file('syllabus_file');
        $data['file_name'] = 'file_name_' . $input['course_syllabus_id'];
        $data['destination'] = UtilityService::$FilesUploadPath['course_syllabus_file'];
        // $data['max'] = UtilityService::$FileSize['max'];
        $syllabus_file = $this->fileUploadService->saveFiles($data);
        return $syllabus_file;
    }

}
