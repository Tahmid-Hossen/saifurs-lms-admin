<?php
/**
 * Created by PhpStorm.
 * User: MN
 * Date: 11/25/2018
 * Time: 4:12 PM
 */

namespace App\Services\Backend\User;


use App\Repositories\Backend\User\UserDetailsRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Illuminate\Support\Facades\Log;

class UserDetailsService
{
    /**
     * @var UserDetailsRepository
     */
    private $userDetailsRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * UserDetailsService constructor.
     * @param UserDetailsRepository $userDetailsRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(UserDetailsRepository $userDetailsRepository, FileUploadService $fileUploadService)
    {
        $this->userDetailsRepository = $userDetailsRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function createUserDetails($input)
    {
        try {
            $user = $this->userDetailsRepository->firstOrCreate($input);
            return $user;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateUserDetails($input, $id)
    {
        try{
            $userDetails = $this->userDetailsRepository->find($id);
            $this->userDetailsRepository->update($input, $id);
            return $userDetails;

        } catch (\Exception $e){
            Log::error($e->getMessage());
        }

        return false;
    }

    /**
     * @param $id
     */
    public function deleteUserDetails($id)
    {
        $this->userDetailsRepository->delete($id);
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function userDetails($input)
    {

        return $this->userDetailsRepository->userDetails($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function userDetailsById($id)
    {
        return $this->userDetailsRepository->find($id);
    }

    /**
     * @param $input
     * @return mixed
     */
    public function findUserDetailIdByUserId($input)
    {
        return $this->userDetailsRepository->userDetails($input)->first();
    }

    /**
     * @param $inputInsert
     * @return bool|mixed
     */
    public function user_detail_custom_insert($inputInsert)
    {
		//\Log::info('user details datas ' . $inputInsert);
        $user_detail_insert['user_id'] = $inputInsert['user_id'];
        $user_detail_insert['student_id'] = date('y-m-').str_pad($inputInsert['user_id'],6,'0',STR_PAD_LEFT);
        $user_detail_insert['sponsor_id'] = isset($inputInsert['sponsor_id'])?$inputInsert['sponsor_id']:null;
        $user_detail_insert['company_id'] = isset($inputInsert['company_id'])?$inputInsert['company_id']:null;
        $user_detail_insert['branch_id'] = isset($inputInsert['branch_id'])?$inputInsert['branch_id']:1;
        $user_detail_insert['first_name'] = $inputInsert['first_name'];
        $user_detail_insert['last_name'] = $inputInsert['last_name'];
        $user_detail_insert['national_id'] = ($inputInsert['national_id']??null);
       // $user_detail_insert['identity_card'] = $inputInsert['identity_card'];
        //$user_detail_insert['date_of_birth'] = $inputInsert['date_of_birth'];
        //$user_detail_insert['date_of_enrollment'] = $inputInsert['date_of_enrollment'];
        $user_detail_insert['gender'] = isset($inputInsert['gender'])?$inputInsert['gender']:'male';
        $user_detail_insert['married_status'] = isset($inputInsert['married_status'])?$inputInsert['married_status']:'single';
        $user_detail_insert['mobile_phone'] = $inputInsert['mobile_phone'];
        $user_detail_insert['home_phone'] = isset($inputInsert['home_phone']) ? $inputInsert['home_phone'] : $inputInsert['mobile_phone'] ;
        //$user_detail_insert['mailing_address'] = $inputInsert['mailing_address'];
        $user_detail_insert['state_id'] = isset($inputInsert['state_id'])?$inputInsert['state_id']:null;
        $user_detail_insert['city_id'] = isset($inputInsert['city_id'])?$inputInsert['city_id']:null;
       // $user_detail_insert['post_code'] = $inputInsert['post_code'];
        $user_detail_insert['country_id'] = isset($inputInsert['country_id'])?$inputInsert['country_id']:null;
        $user_detail_insert['shipping_address'] = isset($inputInsert['shipping_address'])?$inputInsert['shipping_address']:null;
        $user_detail_insert['shipping_state_id'] = isset($inputInsert['shipping_state_id'])?$inputInsert['shipping_state_id']:null;
        $user_detail_insert['shipping_city_id'] = isset($inputInsert['shipping_city_id'])?$inputInsert['shipping_city_id']:null;
        $user_detail_insert['shipping_post_code'] = isset($inputInsert['shipping_post_code'])?$inputInsert['shipping_post_code']:null;
        $user_detail_insert['police_station'] = ($inputInsert['police_station']??null);
        //$user_detail_insert['user_details_verified'] = $inputInsert['user_details_verified'];
        //$user_detail_insert['user_details_status'] = $inputInsert['status'];
        return $this->createUserDetails($user_detail_insert);
    }

    /**
     * @param $inputUpdate
     * @param $id
     * @return bool|mixed
     */
    public function user_details_custom_update($inputUpdate, $id)
    {
        $user_detail_update['user_id'] = $inputUpdate['user_id'];
        $user_detail_update['sponsor_id'] = isset($inputUpdate['sponsor_id'])?$inputUpdate['sponsor_id']:null;
        $user_detail_update['company_id'] = isset($inputUpdate['company_id'])?$inputUpdate['company_id']:null;
        $user_detail_update['branch_id'] = isset($inputUpdate['branch_id'])?$inputUpdate['branch_id']:null;
        $user_detail_update['first_name'] = $inputUpdate['first_name'];
        $user_detail_update['last_name'] = $inputUpdate['last_name'];
        $user_detail_update['national_id'] = ($inputUpdate['national_id']??null);
        $user_detail_update['identity_card'] = $inputUpdate['identity_card'];
        $user_detail_update['date_of_birth'] = $inputUpdate['date_of_birth'];
        $user_detail_update['date_of_enrollment'] = $inputUpdate['date_of_enrollment'];
        $user_detail_update['gender'] = isset($inputUpdate['gender'])?$inputUpdate['gender']:'male';
        $user_detail_update['married_status'] = isset($inputUpdate['married_status'])?$inputUpdate['married_status']:'single';
        $user_detail_update['mobile_phone'] = $inputUpdate['mobile_phone'];
        $user_detail_update['home_phone'] = $inputUpdate['home_phone'];
        $user_detail_update['mailing_address'] = $inputUpdate['mailing_address'];
        $user_detail_update['state_id'] = isset($inputUpdate['state_id'])?$inputUpdate['state_id']:null;
        $user_detail_update['city_id'] = isset($inputUpdate['city_id'])?$inputUpdate['city_id']:null;
        $user_detail_update['country_id'] = isset($inputUpdate['country_id'])?$inputUpdate['country_id']:null;
        $user_detail_update['post_code'] = $inputUpdate['post_code'];
        $user_detail_update['shipping_address'] = $inputUpdate['shipping_address'];
        $user_detail_update['shipping_state_id'] = isset($inputUpdate['shipping_state_id'])?$inputUpdate['shipping_state_id']:null;
        $user_detail_update['shipping_city_id'] = isset($inputUpdate['shipping_city_id'])?$inputUpdate['shipping_city_id']:null;
        $user_detail_update['shipping_post_code'] = $inputUpdate['shipping_post_code'];
        $user_detail_update['police_station'] = ($inputUpdate['police_station']??null);
        $user_detail_update['user_details_verified'] = $inputUpdate['user_details_verified'];
        $user_detail_update['user_details_status'] = $inputUpdate['status'];
        return $this->updateUserDetails($user_detail_update, $id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function userDetailPhoto($input)
    {
        if(isset($input['user_detail_photo_old'])):
            $this->fileUploadService->removeFile($input['user_detail_photo_old'], public_path(UtilityService::$fileUploadPath));
        endif;
        $data['image'] = $input->file('user_detail_photo');
        $data['image_name'] = 'user_detail_photo_'.$input['user_detail_id']."_".date('Y_m_d_h_i_s');
        $data['destination'] = UtilityService::$imageUploadPath['user_detail_photo'];
        $data['width'] = UtilityService::$userPhotoSize['width'];
        $data['height'] = UtilityService::$userPhotoSize['height'];
        $img = $this->fileUploadService->savePhoto($data);
        return $img;
    }
}
