<?php

namespace App\Services\Backend\Result;

use App\Repositories\Backend\Result\ResultRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;


class ResultService
{
    /**
     * @var ResultRepository
     */
    private $resultRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * CourseLearnService constructor.
     * @param ResultRepository $resultRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(ResultRepository $resultRepository, FileUploadService $fileUploadService)
    {
        $this->resultRepository = $resultRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createResult($input)
    {
       try {
            return $this->resultRepository->firstOrCreate($input);
       } catch (ModelNotFoundException $e) {
          \Log::error('Result not found');
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
    public function updateResult($input, $id)
    {
        try{
            $result = $this->resultRepository->find($id);
            // dd($result);
            $this->resultRepository->update($input, $id);
            return $result;
        } catch (ModelNotFoundException $e) {
           \Log::error('Result not found');
        } catch (\Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteResult($id)
    {
        return $this->resultRepository->delete($id);
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function showAllResult($input)
    {
        return $this->resultRepository->result($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function resultById($id)
    {
        return $this->resultRepository->find($id);
    }

    /**
     * @param $input
     * @return bool
     */
    public function customResultStore($input): bool
    {
        $resultStore['company_id'] = $input['company_id'];
        $resultStore['course_id'] = $input['course_id'];
        $resultStore['class_id'] = $input['class_id']??null;
        $resultStore['batch_id'] = $input['batch_id'];
        $resultStore['quiz_id'] = $input['quiz_id'];
        $resultStore['result_status'] = $input['result_status']??Constants::$user_active_status;
        for($i = 1; $i<=$input['totalRow']; $i++)
        {
            $resultStore['user_id'] = $input['user_id_'.$i];
            $resultStore['total_score'] = $input['total_score_'.$i];
            $this->createResult($resultStore);
        }
        return true;
    }

}
