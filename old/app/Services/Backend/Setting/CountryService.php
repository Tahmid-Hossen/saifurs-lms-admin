<?php


namespace App\Services\Backend\Setting;


use App\Repositories\Backend\Setting\CountryRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class CountryService
{
    /**
     * @var CountryRepository
     */
    private $countryRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * CountryService constructor.
     * @param CountryRepository $countryRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(CountryRepository $countryRepository, FileUploadService $fileUploadService)
    {

        $this->countryRepository = $countryRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function storeCountry(array $input)
    {
        try {
            return $this->countryRepository->create($input);
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
    public function updateCountry($input, $id)
    {
        try {
            $country = $this->countryRepository->find($id);
            $this->countryRepository->update($input, $id);
            return $country;
        } catch (ModelNotFoundException $e) {
           \Log::error('Country not found');
        } catch (\Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showCountryByID($id)
    {
        return $this->countryRepository->find($id);
    }

    /**
     * @param $input
     * @return mixed
     */
    public function ShowAllCountry($input)
    {
        return $this->countryRepository->CountryFilterData($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCountry( $id )
    {
        return $this->countryRepository->delete($id);
    }

    /**
     * @param $input
     * @return null|string
     */
    public function countryFlag($input)
    {
        $data['image'] = $input->file('country_logo');
        $data['image_name'] = 'country_logo_'.$input['country_id'];
        $data['destination'] = UtilityService::$imageUploadPath['country_logo'];
        $data['width'] = UtilityService::$countryFlagSize['width'];
        $data['height'] = UtilityService::$countryFlagSize['height'];
        $img = $this->fileUploadService->savePhoto($data);
        return $img;
    }

}
