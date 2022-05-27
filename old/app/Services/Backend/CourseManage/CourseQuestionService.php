<?php

namespace App\Services\Backend\CourseManage;

use App\Repositories\Backend\CourseManage\CourseQuestionRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;


class CourseQuestionService
{
    /**
     * @var CourseQuestionRepository
     */
    private $courseQuestionRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * CourseQuestionService constructor.
     * @param CourseQuestionRepository $courseQuestionRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(CourseQuestionRepository $courseQuestionRepository, FileUploadService $fileUploadService)
    {
        $this->courseQuestionRepository = $courseQuestionRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createCourseQuestion($input)
    {
        try {
            return $this->courseQuestionRepository->firstOrCreate($input);
        } catch (ModelNotFoundException $e) {
           \Log::error('Question not found');
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
    public function updateCourseQuestion($input, $id)
    {
        try{
            $course_question = $this->courseQuestionRepository->find($id);
            // dd($course_question);
            $this->courseQuestionRepository->update($input, $id);
            return $course_question;
        } catch (ModelNotFoundException $e) {
           \Log::error('Question not found');
        } catch (\Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCourseQuestion($id)
    {
        return $this->courseQuestionRepository->delete($id);
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function showAllCourseQuestion($input)
    {
        return $this->courseQuestionRepository->courseQuestion($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function courseQuestionById($id)
    {
        return $this->courseQuestionRepository->find($id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function courseQuestionImage($input)
    {
        // dd($input);
        $data['image'] = $input->file('question_image');
        $data['image_name'] = 'course_question_image_'.$input['question_id']."_".date('Y_m_d_h_i_s');
        $data['destination'] = UtilityService::$imageUploadPath['course_question_image'];
        $img = $this->fileUploadService->savePhoto($data);
        return $img;
    }

}
