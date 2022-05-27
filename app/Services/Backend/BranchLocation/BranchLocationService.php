<?php

namespace App\Services\Backend\BranchLocation;

use App\Repositories\Backend\BranchLocation\BranchLocationRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Class KeywordService
 * @package App\Services\Backend\Common
 */
class BranchLocationService
{
    /**
     * @var BranchLocationRepository
     */
    private $BranchLocationRepository;

    /**
     * FaqService constructor.
     * @param BranchLocationRepository $BranchLocationRepository
     */
    public function __construct(BranchLocationRepository $BranchLocationRepository)
    {

        $this->BranchLocationRepository = $BranchLocationRepository;
    }

    public function getAllBranchLocation(array $filters): LengthAwarePaginator
    {
        $with = ['category', 'keywords'];

        return $this->BranchLocationRepository
            ->getBookPriceListWith($with, $filters)
            ->paginate(\Utility::$displayRecordPerPage);
    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function storeBranchLocation(array $input)
    {
        try {
            return $this->BranchLocationRepository->create($input);
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
    public function updateBranchLocation($input, $id)
    {
        try {
            $BranchLocation = $this->BranchLocationRepository->find($id);
            $this->BranchLocationRepository->update($input, $id);
            return $BranchLocation;
        } catch (ModelNotFoundException $e) {
            Log::error('BranchLocation not found');
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
    public function showBranchLocationByID($id)
    {
        return $this->BranchLocationRepository->find($id);
    }

    /**
     * @param $input
     * @return mixed
     */
    public function ShowAllBranchLocation()
    {
        return $this->BranchLocationRepository->allBranchLocationList();
    }

    public function ShowAllBranchLocationFrontend($input)
    {
        return $this->BranchLocationRepository->allBranchLocationFrontendList($input);
    }
    /**
     * @param $id
     * @return mixed
     */
    public function deleteBranchLocation($id)
    {
        return $this->BranchLocationRepository->delete($id);
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
    public function branchlocationCustomInsert($input)
    {
        $output['branch_name'] = $input['branch_name'];
        if(isset($input['manager_name'])){
            $output['manager_name'] = $input['manager_name'];
        }
        if(isset($input['address_en'])){
            $output['address_en'] = $input['address_en'];
        }
        if(isset($input['address_bn'])){
            $output['address_bn'] = $input['address_bn'];
        }
        $output['email'] = $input['email'];
       /* if(isset($input['email'])){
            $output['email'] = $input['email'];
        }*/
        if(isset($input['phone'])){
            $output['phone'] = $input['phone'];
        }
        /*$output['manager_name'] = $input['manager_name'];
        $output['address_en'] = $input['address_en'];
        $output['address_bn'] = $input['address_bn'];
        $output['email'] = $input['email'];
        $output['phone'] = $input['phone'];*/
        $output['status'] = $input['status'];
        $output['created_by'] = Auth::id();
        $output['created_at'] = Carbon::now();
        return $this->storeBranchLocation($output);
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function branchlocationCustomUpdate($input, $id)
    {
        $output['branch_name'] = $input['branch_name'];
        $output['manager_name'] = $input['manager_name'];
        $output['address_en'] = $input['address_en'];
        $output['address_bn'] = $input['address_bn'];
        $output['email'] = $input['email'];
        $output['phone'] = $input['phone'];
        $output['status'] = $input['status'];
        $output['updated_by'] = Auth::id();
        $output['updated_at'] = Carbon::now();
        return $this->updateBranchLocation($output, $id);
    }
}
