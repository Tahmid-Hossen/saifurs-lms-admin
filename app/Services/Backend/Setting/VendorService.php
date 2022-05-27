<?php


namespace App\Services\Backend\Setting;


use App\Repositories\Backend\Setting\VendorRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class VendorService
{
    /**
     * @var VendorRepository
     */
    private $vendorRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * VendorService constructor.
     * @param VendorRepository $vendorRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(VendorRepository $vendorRepository, FileUploadService $fileUploadService)
    {
        $this->vendorRepository = $vendorRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param array $input
     * @return false|mixed
     */
    public function storeVendor(array $input)
    {
        try {
            return $this->vendorRepository->create($input);
        } catch (\Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return false|mixed
     */
    public function updateVendor($input, $id)
    {
        try {
            $vendor = $this->vendorRepository->find($id);
            $this->vendorRepository->update($input, $id);
            return $vendor;
        } catch (ModelNotFoundException $e) {
           \Log::error('Vendor not found');
        } catch (\Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function showVendorByID($id)
    {
        return $this->vendorRepository->find($id);
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function ShowAllVendor($input): \Illuminate\Database\Eloquent\Builder
    {
        return $this->vendorRepository->VendorFilterData($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteVendor($id)
    {
        return $this->vendorRepository->delete($id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function vendorLogo($input): ?string
    {
        $data['image'] = $input->file('vendor_logo');
        $data['image_name'] = 'vendor_logo_'.$input['vendor_id'];
        $data['destination'] = UtilityService::$imageUploadPath['vendor_logo'];
        $data['width'] = UtilityService::$vendorLogoSize['width'];
        $data['height'] = UtilityService::$vendorLogoSize['height'];
        return $this->fileUploadService->savePhoto($data);
    }
}
