<?php


namespace App\Services\Backend\User;


use App\Repositories\Backend\User\BranchRepository;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class BranchService
{
    /**
     * @var BranchRepository
     */
    private $branchRepository;

    /**
     * BranchService constructor.
     * @param BranchRepository $branchRepository
     */
    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createBranch($input)
    {
        try {
            return $this->branchRepository->firstOrCreate($input);
        } catch (ModelNotFoundException $e) {
           \Log::error('Branch not found');
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
    public function updateBranch($input, $id)
    {
        try {
            $branch = $this->branchRepository->find($id);
            $this->branchRepository->update($input, $id);
            return $branch;
        } catch (ModelNotFoundException $e) {
           \Log::error('Branch not found');
        } catch (Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteBranch($id)
    {
        return $this->branchRepository->delete($id);
    }

    /**
     * @param $input
     * @return Builder
     */
    public function showAllBranch($input)
    {
        return $this->branchRepository->branchFilterData($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function branchById($id)
    {
        return $this->branchRepository->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function showBranchesByCompanyId($id)
    {
        return $this->branchRepository->findByAll('company_id', $id);
    }

    /**
     * @return array
     */
    public function branchDummyText(): array
    {
        $dummyArray = array();
        $dummyArray['city_name'] = null;
        $dummyArray['state_name'] = null;
        $dummyArray['country_name'] = null;
        $dummyArray['id'] = null;
        $dummyArray['company_name'] = null;
        $dummyArray['company_email'] = null;
        $dummyArray['company_address'] = null;
        $dummyArray['city_id'] = null;
        $dummyArray['state_id'] = null;
        $dummyArray['country_id'] = null;
        $dummyArray['company_zip_code'] = null;
        $dummyArray['company_phone'] = null;
        $dummyArray['company_mobile'] = null;
        $dummyArray['company_logo'] = null;
        $dummyArray['company_status'] = null;
        $dummyArray['created_by'] = null;
        $dummyArray['updated_by'] = null;
        $dummyArray['deleted_by'] = null;
        $dummyArray["deleted_at"] = null;
        $dummyArray["created_at"] = null;
        $dummyArray["updated_at"] = null;
        $dummyArray["company_id"] = null;
        $dummyArray["branch_name"] = 'Select';
        $dummyArray["branch_phone"] = null;
        $dummyArray["branch_mobile"] = null;
        $dummyArray["branch_address"] = null;
        $dummyArray["branch_zip_code"] = null;
        $dummyArray["branch_latitude"] = null;
        $dummyArray["branch_longitude"] = null;
        $dummyArray["branch_status"] = null;
        return $dummyArray;
    }
}
