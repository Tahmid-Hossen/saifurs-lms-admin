<?php

namespace App\Services\Backend\CourseManage;

use App\Repositories\Backend\CourseManage\CourseQuestionAnswerRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;


class CourseQuestionAnswerService
{
    /**
     * @var CourseQuestionAnswerRepository
     */
    private $courseQuestionAnswerRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * CourseQuestionAnswerService constructor.
     * @param CourseQuestionAnswerRepository $courseQuestionRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(CourseQuestionAnswerRepository $courseQuestionAnswerRepository, FileUploadService $fileUploadService)
    {
        $this->courseQuestionAnswerRepository = $courseQuestionAnswerRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createCourseQuestionAnswer($input)
    {
        // dd($input);
        try {
            return $this->courseQuestionAnswerRepository->firstOrCreate($input);
        } catch (ModelNotFoundException $e) {
           \Log::error('Answer not found');
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
    public function updateCourseQuestionAnswer($input, $id)
    {
        try{
            $question_answer = $this->courseQuestionAnswerRepository->find($id);
            // dd($question_answer);
            $this->courseQuestionAnswerRepository->update($input, $id);
            return $question_answer;
        } catch (ModelNotFoundException $e) {
           \Log::error('Answer not found');
        } catch (\Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCourseQuestionAnswer($id)
    {
        return $this->courseQuestionAnswerRepository->delete($id);
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function showAllCourseQuestionAnswer($input)
    {
        return $this->courseQuestionAnswerRepository->courseQuestionAnswer($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function courseQuestionAnswerById($id)
    {
        return $this->courseQuestionAnswerRepository->find($id);
    }

}
