<?php


namespace App\Services\Backend\Setting;


use App\Repositories\Backend\Setting\CityRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class CityService
{
    /**
     * @var CityRepository
     */
    private $cityRepository;

    /**
     * CityService constructor.
     * @param CityRepository $cityRepository
     */
    public function __construct(CityRepository $cityRepository)
    {

        $this->cityRepository = $cityRepository;
    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function storeCity(array $input)
    {
        try {
            return $this->cityRepository->create($input);
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
    public function updateCity($input, $id)
    {
        try {
            $city = $this->cityRepository->find($id);
            $this->cityRepository->update($input, $id);
            return $city;
        } catch (ModelNotFoundException $e) {
           \Log::error('City not found');
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
    public function showCityByID($id)
    {
        return $this->cityRepository->find($id);
    }

    /**
     * @param $input
     * @return mixed
     */
    public function ShowAllCity($input)
    {
        return $this->cityRepository->CityFilterData($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCity($id)
    {
        return $this->cityRepository->delete($id);
    }

    /**
     * @return array
     */
    public function cityDummyText(): array
    {
        $dummyArray = array();
        $dummyArray['country_name'] = null;
        $dummyArray['country_logo'] = null;
        $dummyArray['state_name'] = null;
        $dummyArray['id'] = null;
        $dummyArray['state_id'] = null;
        $dummyArray['city_name'] = 'Select';
        $dummyArray['city_status'] = null;
        $dummyArray['created_by'] = null;
        $dummyArray['updated_by'] = null;
        $dummyArray['deleted_by'] = null;
        $dummyArray["deleted_at"] = null;
        $dummyArray["created_at"] = null;
        $dummyArray["updated_at"] = null;
        return $dummyArray;
    }
}
