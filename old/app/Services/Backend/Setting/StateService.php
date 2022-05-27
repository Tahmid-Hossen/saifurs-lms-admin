<?php


namespace App\Services\Backend\Setting;


use App\Repositories\Backend\Setting\StateRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class StateService
{
    /**
     * @var StateRepository
     */
    private $StateRepository;

    /**
     * StateService constructor.
     * @param StateRepository $StateRepository
     */
    public function __construct(StateRepository $StateRepository)
    {

        $this->StateRepository = $StateRepository;
    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function storeState(array $input)
    {
        try {
            return $this->StateRepository->create($input);
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
    public function updateState($input, $id)
    {
        try {
            $State = $this->StateRepository->find($id);
            $this->StateRepository->update($input, $id);
            return $State;
        } catch (ModelNotFoundException $e) {
           \Log::error('State not found');
        } catch (Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showStateByID($id)
    {
        return $this->StateRepository->find($id);
    }

    /**
     * @param $input
     * @return mixed
     */
    public function ShowAllState($input)
    {
        return $this->StateRepository->StateFilterData($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteState($id)
    {
        return $this->StateRepository->delete($id);
    }

    /**
     * @return array
     */
    public function stateDummyText(): array
    {
        $dummyArray = array();
        $dummyArray['country_name'] = null;
        $dummyArray['country_logo'] = null;
        $dummyArray['id'] = null;
        $dummyArray['country_id'] = null;
        $dummyArray['state_name'] = 'Select State';
        $dummyArray['state_status'] = null;
        $dummyArray['created_by'] = null;
        $dummyArray['updated_by'] = null;
        $dummyArray['deleted_by'] = null;
        $dummyArray["deleted_at"] = null;
        $dummyArray["created_at"] = null;
        $dummyArray["updated_at"] = null;
        return $dummyArray;
    }
}
