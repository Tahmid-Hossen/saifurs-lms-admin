<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Services\Backend\Faq\FaqService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqController extends Controller {
    /**
     * @var FaqService
     */
    private $FaqService;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * FaqController constructor.
     * @param FaqService $FaqService
     * @param UserService $userService
     */
    public function __construct(FaqService $FaqService, UserService $userService) {
        $this->FaqService = $FaqService;
        $this->userService = $userService;
    }

    public function getFaqList(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            DB::beginTransaction();
            $request['status'] = Constants::$faq_status;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser,$request->all());
//            $Faqs = $this->FaqService->ShowAllFaqFrontnd($requestData)->skip(0)->take(UtilityService::$displayRecordPerPage)->get();
            $Faqs = $this->FaqService->ShowAllFaqFrontnd($requestData)->get();
            if(count($Faqs)>0):
                $data['Faqs'] = $Faqs;
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
            $jsonReturn = response()->json(['status' => false, 'message'=>'Failed to found Faq!'], 200);
        }
        return $jsonReturn;
    }

}
