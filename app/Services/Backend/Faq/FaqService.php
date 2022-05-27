<?php

namespace App\Services\Backend\Faq;

use App\Repositories\Backend\Faq\FaqRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Class KeywordService
 * @package App\Services\Backend\Common
 */
class FaqService
{
    /**
     * @var FaqRepository
     */
    private $FaqRepository;

    /**
     * FaqService constructor.
     * @param FaqRepository $FaqRepository
     */
    public function __construct(FaqRepository $FaqRepository)
    {

        $this->FaqRepository = $FaqRepository;
    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function storeFaq(array $input)
    {
        try {
            return $this->FaqRepository->create($input);
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateFaq($input, $id)
    {
        try {
            $Faq = $this->FaqRepository->find($id);
            $this->FaqRepository->update($input, $id);
            return $Faq;
        } catch (ModelNotFoundException $e) {
            Log::error('Faq not found');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showFaqByID($id)
    {
        return $this->FaqRepository->find($id);
    }

    /**
     * @param $input
     * @return mixed
     */
    public function ShowAllFaq($input)
    {
        return $this->FaqRepository->allFaqList($input);
    }

    public function ShowAllFaqFrontnd($input)
    {
        return $this->FaqRepository->allFaqFrontndList($input);
    }
    /**
     * @param $id
     * @return mixed
     */
    public function deleteFaq($id)
    {
        return $this->FaqRepository->delete($id);
    }

    /*public function getAllFaqId(array $inputs): array
    {
        $exitsFaqs = [];

        foreach ($inputs as $input) {
            if (is_numeric($input))
                $exitsFaqs[] = (int)$input;
            else {
                if ($Faq = $this->storeFaq([
                        'Faq_name' => $input,
                        'Faq_status' => UtilityService::$statusText[1]]
                )) {
                    $exitsFaqs[] = $Faq->id;
                }
            }
        }

        return array_unique($exitsFaqs);
    }*/

    /**
     * @param $input
     * @return false|mixed
     */
    public function faqCustomInsert($input)
    {
        $output['question'] = $input['question'];
        $output['answer'] = $input['answer'];
        $output['status'] = $input['status'];
        $output['created_by'] = Auth::id();
        $output['created_at'] = Carbon::now();
        return $this->storeFaq($output);
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function faqCustomUpdate($input, $id)
    {
        $output['question'] = $input['question'];
        $output['answer'] = $input['answer'];
        $output['status'] = $input['status'];
        $output['updated_by'] = Auth::id();
        $output['updated_at'] = Carbon::now();
        return $this->updateFaq($output, $id);
    }
}
