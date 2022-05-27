<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Backend\GoogleApiKey\GoogleApiKeyService;
use App\Services\Backend\User\UserService;
use App\Support\Configs\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GoogleApiKeyController extends Controller
{
    /**
     * @var Service
     */
    private $googleApiKeyService;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(GoogleApiKeyService $googleApiKeyService, UserService $userService) {
        $this->googleApiKeyService = $googleApiKeyService;
        $this->userService = $userService;
    }

    public function getgoogleApiKey(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            DB::beginTransaction();
            $request['status'] = Constants::$googleApiKey_status;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser,$request->all());
            $googleApiKeys = $this->googleApiKeyService->ShowAllGoogleApiKeyFrontnd($requestData)->get();
            if(count($googleApiKeys)>0):
                $data['GoogleApiKeys'] = $googleApiKeys;
                $data['status'] = true;
            else:
                $data['status'] = false;
                $data['message'] = 'Data Not Found';
            endif;
            $data['request'] = $request->all();
            DB::commit();
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message'=>'Failed to found GoogleApiKey!'], 200);
        }
        return $jsonReturn;
    }
}
