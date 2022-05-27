<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\User\BranchRequest;
use App\Services\Backend\Setting\CountryService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class BranchController extends Controller
{
    /**
     * @var BranchService
     */
    private $branchService;
    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var CountryService
     */
    private $countryService;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * BranchController constructor.
     * @param BranchService $branchService
     * @param CompanyService $companyService
     * @param CountryService $countryService
     * @param UserService $userService
     */
    public function __construct(BranchService $branchService, CompanyService $companyService, CountryService $countryService, UserService $userService)
    {
        $this->branchService = $branchService;
        $this->companyService = $companyService;
        $this->countryService = $countryService;
        $this->userService = $userService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser,$request->all());
            $data['branches'] = $this->branchService->showAllBranch($requestData)->paginate($request->display_item_per_page);
            $data['companies'] = $this->companyService->showAllCompany($requestData)->get();
            $data['companies'] = $this->companyService->showAllCompany($requestData)->get();
            $data['request'] = $request->all();
            $data['status'] = true;
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message'=>'Branch table not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(): \Illuminate\Http\JsonResponse
    {
        try {
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $request['company_id'] = isset($companyWiseUser['company_id'])?$companyWiseUser['company_id']:null;
            $data['companies'] = $this->companyService->showAllCompany($request)->get();
            $data['countries'] = $this->countryService->ShowAllCountry(array('id'=>18))->get();
            $data['status'] = true;
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message'=>'Something wrong with Branch Data!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BranchRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(BranchRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $branch = $this->branchService->createBranch($request->except('_token'));
            if ($branch) {
                $data['branch'] = $branch;
                $data['status'] = true;
                $data['message'] = 'Branch created successfully';
            } else {
                $data['branch'] = null;
                $data['status'] = false;
                $data['message'] = 'Failed to create Branch';
            }
            $jsonReturn = response()->json($data,200);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message'=>'Failed to create Branch'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): \Illuminate\Http\JsonResponse
    {
        try {
            $data['branch'] = $this->branchService->branchById($id);
            $data['status'] = true;
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message'=>'Branch data not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id): \Illuminate\Http\JsonResponse
    {
        try {
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $request['company_id'] = isset($companyWiseUser['company_id'])?$companyWiseUser['company_id']:null;
            $data['branch'] = $this->branchService->branchById($id);
            $data['companies'] = $this->companyService->showAllCompany($request)->get();
            $data['countries'] = $this->countryService->ShowAllCountry(array('id'=>18))->get();
            $data['status'] = true;
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message'=>'Something wrong with Branch Data!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BranchRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(BranchRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $branch = $this->branchService->updateBranch($request->except('_token'), $id);
            if ($branch) {
                $data['branch'] = $branch;
                $data['status'] = true;
                $data['message'] = 'Branch update successfully';
            } else {
                $data['branch'] = null;
                $data['status'] = false;
                $data['message'] = 'Failed to update Branch';
            }
            $jsonReturn = response()->json($data,200);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message'=>'Failed to update Branch'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            $user_get = $this->userService->whoIS($_REQUEST);
            if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
                $branch = $this->branchService->branchById($id);
                if ($branch) {
                    $branch->delete();
                    $data['status'] = true;
                    $data['message'] = 'Branch deleted successfully';
                }else{
                    $data['status'] = false;
                    $data['message'] = 'Branch not found!';
                }
                $jsonReturn = response()->json($data,200);
            }else{
                $jsonReturn = response()->json(['status' => false, 'message'=>'You Entered Wrong Password!'], 200);
            }
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message'=>'Failed to deleted Branch'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBranchList(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            $branchArray = array();
            $branches = $this->branchService->showAllBranch($request->all())->get();
			//dd(count($branches));
            if(count($branches)>0):
                $branchArray[] = $this->branchService->branchDummyText();
                foreach($branches as $branch):
                    $branchArray[] = $branch;
                endforeach;

                $jsonReturn = response()->json(['status' =>true, 'data'=>$branchArray]);

            else:
                $jsonReturn = response()->json(['status' =>false, 'message'=>'Data Not Found']);
            endif;
        }catch (\Exception $e){
            $jsonReturn = response()->json(['status' => false, 'message'=>'Branch table not found!'], 200);
        }
        return $jsonReturn;
    }


    public function getFrontendBranchList(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            $branchArray = array();
            $branches = $this->branchService->showAllBranch($request->all())->get();
            if(count($branches)>0):
                foreach($branches as $branch):
                    $branchArray[] = $branch;
                endforeach;
                $jsonReturn = response()->json(['status' =>true, 'data'=>$branchArray]);
            else:
                $jsonReturn = response()->json(['status' =>false, 'message'=>'Data Not Found']);
            endif;
        }catch (\Exception $e){
            $jsonReturn = response()->json(['status' => false, 'message'=>'Branch table not found!'], 200);
        }
        return $jsonReturn;
    }


}
