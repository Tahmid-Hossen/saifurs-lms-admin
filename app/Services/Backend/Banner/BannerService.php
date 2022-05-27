<?php

namespace App\Services\Backend\Banner;

use App\Repositories\Backend\Banner\BannerRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Exception;

class BannerService
{
    /**
     * @var BannerRepository
     */
    private $bannerRepository;

    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * BannerService constructor.
     * @param BannerRepository $bannerRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(BannerRepository $bannerRepository, FileUploadService $fileUploadService)
    {
        $this->bannerRepository = $bannerRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createBanner($input)
    {
        try {
            return $this->bannerRepository->create($input);
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
    public function updateBanner($input, $id)
    {
        try {
            $userDetails = $this->bannerRepository->find($id);
            $this->bannerRepository->update($input, $id);
            return $userDetails;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function showAllBanner($input)
    {
        return $this->bannerRepository->filterData($input);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showBannerByID($id)
    {
        return $this->bannerRepository->find($id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function bannerImage($input)
    {
        $data['image'] = $input->file('banner_image');
        $data['image_name'] = 'banner_image_' . $input['banner_id'];
        $data['destination'] = UtilityService::$imageUploadPath['banner_image'];
        $data['width'] = UtilityService::$bannerImageSize['width'];
        $data['height'] = UtilityService::$bannerImageSize['height'];
        $img = $this->fileUploadService->savePhoto($data);
        return $img;
    }

    /**
     * @param $input
     * @return false|mixed
     */
    public function bannerCustomInsert($input)
    {
        $output['company_id'] = $input['company_id'];
        $output['banner_title'] = $input['banner_title'];
        $output['banner_status'] = $input['banner_status'];
        $output['created_by'] = Auth::id();
        $output['created_at'] = Carbon::now();
        return $this->createBanner($output);
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function bannerCustomUpdate($input, $id)
    {
        $output['company_id'] = $input['company_id'];
        $output['banner_title'] = $input['banner_title'];
        $output['banner_status'] = $input['banner_status'];
        $output['updated_by'] = Auth::id();
        $output['updated_at'] = Carbon::now();
        return $this->updateBanner($output, $id);
    }
}
