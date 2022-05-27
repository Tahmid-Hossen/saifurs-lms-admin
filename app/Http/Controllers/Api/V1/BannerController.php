<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Banner\BannerRequest;
use App\Services\Backend\Banner\BannerService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller {
    /**
     * @var BannerService
     */
    private $bannerService;

    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * BannerController constructor.
     * @param BannerService $bannerService
     * @param UserService $userService
     * @param CompanyService $companyService
     */
    public function __construct(
        BannerService $bannerService,
        UserService $userService,
        CompanyService $companyService
    ) {
        $this->bannerService = $bannerService;
        $this->userService = $userService;
        $this->companyService = $companyService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index( Request $request ): \Illuminate\Http\JsonResponse
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page) ? $request->display_item_per_page : UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge( $companyWiseUser, $request->all() );
            $data['companies'] = $this->companyService->showAllCompany( $companyWiseUser )->get();
            $data['events'] = $this->bannerService->showAllBanner( $requestData )->paginate( $request->display_item_per_page );
            $data['request'] = $request->all();
            $data['status'] = true;
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message'=>'Banner table not found!'], 200);
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
            $data['companies'] = $this->companyService->showAllCompany( $companyWiseUser )->get();
            $data['status'] = true;
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message'=>'Something wrong with Banner Data!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BannerRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(BannerRequest $request ): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $bannerStore = $this->bannerService->bannerCustomInsert( $request->all() );
            if ($bannerStore):
                if ( $request->hasFile( 'banner_image' ) ) {
                    $image_url = $this->bannerService->bannerImage( $request );
                    $bannerStore->banner_image = $image_url;
                    $bannerStore->save();
                }
                $data['userDetail'] = $bannerStore;
                $data['status'] = true;
                $data['message'] = 'Banner Create successfully';
            else:
                $data['status'] = false;
                $data['message'] = 'Failed to created Banner!';
            endif;
            $jsonReturn = response()->json($data, 200);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $jsonReturn = response()->json(['status' => false, 'message'=>'Failed to create Banner!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id ): \Illuminate\Http\JsonResponse
    {
        try {
            $banner = $this->bannerService->showBannerByID($id);
            $data['banner'] = $banner;
            $data['status'] = true;
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message'=>'Banner data not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit( $id ): \Illuminate\Http\JsonResponse
    {
        try {
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $data['banner'] = $this->bannerService->showBannerByID($id);
            $data['companies'] = $this->companyService->showAllCompany( $companyWiseUser )->get();
            $data['status'] = true;
            $jsonReturn = response()->json($data,200);
        } catch (\Exception $e) {
            $jsonReturn = response()->json(['status' => false, 'message'=>'Banner data not found!'], 200);
        }
        return $jsonReturn;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BannerRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function update(BannerRequest $request, $id ): \Illuminate\Http\JsonResponse
    {
        try {
            DB::beginTransaction();
            $bannerUpdate = $this->bannerService->bannerCustomUpdate($request->all(), $id);
            if ( $bannerUpdate ) {
                $request['banner_id'] = $bannerUpdate->id;
                $old_image = $request['existing_image'];
                if ( $request->hasFile( 'banner_image' ) ) {
                    $image_url = $this->bannerService->bannerImage( $request );
                    $bannerUpdate->banner_image = $image_url;
                } else {
                    $bannerUpdate->banner_image = $old_image;
                }
                $bannerUpdate->save();
                $data['banner'] = $bannerUpdate;
                $data['status'] = true;
                $data['message'] = 'Banner update successfully';
            } else {
                $data['status'] = false;
                $data['message'] = 'Failed to updated Banner!';
            }
            $data['request'] = $request->all();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $data['status'] = false;
            $data['message'] = 'Failed to update Banner!';
        }
        return response()->json($data, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id ): \Illuminate\Http\JsonResponse
    {
        try{
            DB::beginTransaction();
            $user_get = $this->userService->whoIS($_REQUEST);
            if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
                $data = $this->bannerService->showBannerByID($id);
                if ($data) {
                    $data->delete();
                    $data['message'] = 'Banner deleted successfully';
                    $data['status'] = true;
                }else{
                    $data['message'] = 'Banner not found!';
                    $data['status'] = false;
                }
            }else{
                $data['message'] = 'You Entered Wrong Password!';
                $data['status'] = false;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $data['message'] = 'Failed to deleted Banner!';
            $data['status'] = false;
        }
        return response()->json($data,200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getBannerList(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            DB::beginTransaction();
            $request['banner_status'] = Constants::$user_active_status;
            $companyWiseUser = $this->userService->user_role_display_for_api();
            $requestData = array_merge($companyWiseUser,$request->all());
            $banners = $this->bannerService->showAllBanner($requestData)->skip(0)->take(UtilityService::$displayRecordPerPage)->get();
            if(count($banners)>0):
                $data['banners'] = $banners;
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
            $jsonReturn = response()->json(['status' => false, 'message'=>'Failed to found Banner!'], 200);
        }
        return $jsonReturn;
    }

}
