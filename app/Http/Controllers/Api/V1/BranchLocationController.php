<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Backend\BranchLocation\BranchLocationService;
use App\Services\Backend\User\UserService;
use App\Support\Configs\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchLocationController extends Controller
{
    /**
     * @var BranchLocationService
     */
    private $BranchLocationService;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(BranchLocationService $BranchLocationService, UserService $userService)
    {
        $this->BranchLocationService = $BranchLocationService;
        $this->userService = $userService;
    }
        public function getBranchLocation(Request $request): \Illuminate\Http\JsonResponse
        {
            try{
                DB::beginTransaction();
                $request['status'] = Constants::$branch_location_status;
                $companyWiseUser = $this->userService->user_role_display_for_api();
                $requestData = array_merge($companyWiseUser,$request->all());
                $branchlocations = $this->BranchLocationService->ShowAllBranchLocationFrontend($requestData)->get();
                if(count($branchlocations)>0):
                    $data['BranchLocations'] = $branchlocations;
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
                $jsonReturn = response()->json(['status' => false, 'message'=>'Failed to found Branch Location!'], 200);
            }
            return $jsonReturn;
        }
}
