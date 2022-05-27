<?php


namespace App\Services\Backend\User;


use App\Repositories\Backend\User\CompanyRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class CompanyService
{
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * CompanyService constructor.
     * @param CompanyRepository $companyRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(CompanyRepository $companyRepository, FileUploadService $fileUploadService)
    {
        $this->companyRepository = $companyRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createCompany($input)
    {
        try {
            return $this->companyRepository->firstOrCreate($input);
        } catch (ModelNotFoundException $e) {
            Log::error('Company not found');
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
    public function updateCompany($input, $id)
    {
        try {
            $company = $this->companyRepository->find($id);
            $this->companyRepository->update($input, $id);
            return $company;
        } catch (ModelNotFoundException $e) {
            Log::error('Company not found');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteCompany($id)
    {
        return $this->companyRepository->delete($id);
    }

    /**
     * @param $input
     * @return Builder
     */
    public function showAllCompany($input)
    {
        return $this->companyRepository->companyFilterData($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function companyById($id)
    {
        return $this->companyRepository->find($id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function companyLogo($input)
    {
        $data['image'] = $input->file('company_logo');
        $data['image_name'] = 'company_logo_' . $input['company_id']."_".date('Y_m_d_h_i_s');
        $data['destination'] = UtilityService::$imageUploadPath['company_logo'];
        $data['width'] = UtilityService::$companyLogoSize['width'];
        $data['height'] = UtilityService::$companyLogoSize['height'];
        $img = $this->fileUploadService->savePhoto($data);
        return $img;
    }

    /**
     * @return array
     */
    public function getCompanyDropDown(array $input = []): array
    {
        $companies = [];




        foreach ($this->companyRepository->companyFilterData($input)->get() as $company) {
            $companies[$company->id] = $company->company_name;
        }
        return $companies;
    }
}
