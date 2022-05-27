<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\User\GenerationUpdateRequest;
use App\Http\Requests\Backend\User\UserRegistrationRequest;
use App\Services\Backend\IPPurchases\IPPurchasesService;
use App\Services\Backend\IPPurchases\ParentIPPurchaseService;
use App\Services\Backend\MemberIPAllocations\MemberIPAllocationsService;
use App\Services\Backend\Packages\PackagesDetailsService;
use App\Services\Backend\Packages\PackagesService;
use App\Services\Backend\Products\ProductsService;
use App\Services\Backend\Promotion\UserPackageGenerationService;
use App\Services\Backend\Setting\DesignationHistoryService;
use App\Services\Backend\Setting\DesignationMonthlyHistoryService;
use App\Services\Backend\Setting\DesignationSalesBonusService;
use App\Services\Backend\SystemProcess\SystemProcessService;
use App\Services\Backend\Transaction\IPTransactionService;
use App\Services\Backend\User\UserDetailsService;
use App\Services\Backend\User\UserLogService;
use App\Services\Backend\User\UserPositionService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserRegisterController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var UserDetailsService
     */
    private $userDetailsService;
    /**
     * @var UtilityService
     */
    private $utilityService;

    /**
     * UserRegisterController constructor.
     * @param UserService $userService
     * @param UserDetailsService $userDetailsService
     * @param UtilityService $utilityService
     */
    public function __construct(
        UserService $userService,
        UserDetailsService $userDetailsService,
        UtilityService $utilityService
    )
    {
        $this->userService = $userService;
        $this->userDetailsService = $userDetailsService;
        $this->utilityService = $utilityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|Response
     */
    public function index()
    {
        $userRegistrations = $this->userDetailsService->userDetails(array())
            ->paginate(UtilityService::$displayRecordPerPage);
        return view('backend.user.user-register.index', compact('userRegistrations'));
    }


    /**
     * @return Factory|View
     */
    public function create()
    {
        $packages = $this->ipPurchasesService->ippurchases(
            array_merge(
                array('is_approved' => 'APPROVED'),
                $this->userService->user_role_display()
            )
        )->get();
        $data['created_by'] = Auth::user()->id;
        $data['transfer_id'] = Auth::user()->id;
        $data['transfer_by'] = Auth::user()->id;
        $data['is_used_null'] = true;
        $data['is_approved_ok'] = true;
        $order_codes = $this->parentIpPurchaseService->getOrderCodesByCreatedBy($data)->get();
        return view('backend.user.user-register.create', compact('packages', 'order_codes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRegistrationRequest $request
     * @return RedirectResponse
     */
    public function store(UserRegistrationRequest $request)
    {
        $purchases_user_id = Auth::user()->id;
        $package['package_end_date_is_null'] = true;
        $package['ip_value'] = $request['total_ip_quantity'];
        $package_detail_data = $this->packagesDetailsService->packageDetails($package)->first();
        try {
            DB::beginTransaction();
            $user = $this->user_insert($request->all());
            $ip_used_by = $user->id;
            if ($user) {
                $request['user_id'] = $user->id;

                $request['generation_id'] = $package_detail_data->generation_id;
                $request['package_id'] = $package_detail_data->package_id;
                $request['designation_id'] = 1;

                $this->user_detail_insert($request->all());

                $designation_array['user_id'] = $user->id;
                $designation_array['current_designation_id'] = $request['designation_id'];
                $designation_array['designation_date'] = Carbon::now()->format('Y-m-d H:i:s');
                $designation_array['total_ip'] = 0;

                $this->designationHistoryService->designationHistoryIPUpdate($designation_array);
                $this->designationMonthlyHistoryService->designationMonthlyHistoryIPUpdate($designation_array);

                $parent_designation_array['user_id'] = $purchases_user_id;
                $parent_designation_array['current_designation_id'] = Auth::user()->user_details->designation_id;
                $parent_designation_array['total_ip'] = $request['total_ip_quantity'];
                $parent_designation_array['designation_date'] = Carbon::now()->format('Y-m-d H:i:s');
                $this->designationHistoryService->designationHistoryIPUpdate($parent_designation_array);
                $this->designationMonthlyHistoryService->designationMonthlyHistoryIPUpdate($parent_designation_array);


                $this->ipTransactionService->storeIPTransaction(array(
                    'user_id' => $purchases_user_id,
                    'ref_user_id' => $user->id,
                    'ip_transaction_type' => 'sign_up',
                    'ip_transaction_total_ip' => $request['total_ip_quantity'],
                    'ip_transaction_date' => Carbon::now()->format('Y-m-d H:i:s'),
                    'ip_transaction_purpose' => 'Signup for ' . $user->id,
                    'ip_transaction_status' => 'UNPAID',
                    'status' => 'ACTIVE'
                ));

                $this->systemProcessService->
                paidBonusAndDesignationHistoryInsertUpdateForSponsor(
                    [
                        'user_id' => $purchases_user_id,
                        'total_ip' => $request['total_ip_quantity']
                    ]
                );

//                $request['ip_value'] = $request['product_ip'];
                $request['ip_value'] = $request['total_ip_quantity'];

                $this->userPositionByIP($request->all());

                $this->updateIPPurchase($request->all());

                $request['purchases_user_id'] = $purchases_user_id;
                $request['ip_used_by'] = $ip_used_by;
                $this->updateMemberIPAllocationsForUserSignUp($request->all());

                //$this->insertDesignationHistory($request->all());

            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            flash('Failed to create User', 'error');
            return redirect()->route('user-register.create');
        }
        flash('User created successfully');
        return redirect()->route('user-register.index');
    }

    /**
     * @param $input
     * @return mixed
     */
    public function user_insert($input)
    {
        $user['username'] = $input['username'];
        $user['email'] = $input['email'];
        $user['name'] = $input['name'];
        $user['status'] = "ACTIVE";
        $user['password'] = $input['password'];
        $user['roles'] = array(8);
        return $this->userService->createUser($user);
    }

    /**
     * @param $input
     * @return bool|mixed
     */
    public function user_detail_insert($input)
    {
        $user_detail['user_id'] = $input['user_id'];
        $user_detail['sponsor_id'] = $input['sponsor_id'];
        $user_detail['mobile_phone'] = $input['mobile_phone'];
        $user_detail['generation_id'] = $input['generation_id'];
        $user_detail['package_id'] = $input['package_id'];
        $user_detail['designation_id'] = $input['designation_id'];
        $user_detail['status'] = "ACTIVE";
        return $this->userDetailsService->createUserDetails($user_detail);
    }

    /**
     * @param $request
     * @return bool|mixed
     */
    public function userPositionByIP($request)
    {
        try {
            DB::beginTransaction();
            $input['ip_value'] = $request['ip_value'];
            $data['user_id'] = $input['user_id'] = $request['user_id'];
            $get_designation_generation = $this->packagesDetailsService->packageDetails($input)->first();
            $data['package_detail_id'] = $get_designation_generation->id;
            $data['user_pack_gen_start_date'] = Carbon::now()->format('Y-m-d H:i:s');
            $data['status'] = Constants::$user_active_status;
            $this->userPackageGenerationService->findHaveDesignation($data);
            $storeUserPackageGeneration = $this->userPackageGenerationService->storeUserPackageGeneration($data);
            DB::commit();
            return $storeUserPackageGeneration;
        } catch (Exception $e) {
            DB::rollback();
            return false;
        }
    }

    /**
     * @param $input
     */
    public function updateIPPurchase($input)
    {
        $data['order_code'] = $input['order_code'];
        $parentIPPurchaseData = $this->parentIpPurchaseService->getParentIPPurchaseByOrderCode($data)->get();
        $id = $parentIPPurchaseData[0]['id'];
        $parentIPPurchase['is_used'] = 1;
        $this->parentIpPurchaseService->
        updateParentIPPurchase($parentIPPurchase, $id);
    }

    /**
     * @param $input
     */
    public function updateMemberIPAllocationsForUserSignUp($input)
    {
//        $data['product_id'] = $input['package_id'];
        $data['purchases_user_id'] = $input['purchases_user_id'];
//        $data['ip_code'] = $input['ip_code'];
        $data['order_code'] = $input['order_code'];
        $data['ip_used_datetime'] = Carbon::now()->format('Y/m/d');
        $data['ip_used_by'] = $input['ip_used_by'];
        $this->memberIpAllocationsService->findMemberIPAllocationIdForUserSignUp($data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $userRegister = $this->userDetailsService->userDetailsById($id);
        return view('backend.user.user-register.show', compact('userRegister'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $userRegister = $this->userDetailsService->userDetailsById($id);
        return view('backend.user.user-register.edit', compact('userRegister'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRegistrationRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UserRegistrationRequest $request, $id)
    {
        $update_user = $request->all();
        $user_id = $update_user['user_id'];
        try {
            DB::beginTransaction();
            $user = $this->user_update($request->all(), $user_id);
            if ($user) {
                $this->user_details_update($request->all(), $id);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            flash('Failed to update user', 'error');
            return redirect()->route('user-register.edit', $id);
        }

        flash('User updated successfully');
        return redirect()->route('user-register.index');
    }

    /**
     * @param $input
     * @param $id
     * @return bool
     */
    public function user_update($input, $id)
    {
        $user['email'] = $input['email'];
        $user['name'] = $input['name'];
        $user['roles'] = array(1);
        return $this->userService->updateUser($user, $id);
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function user_details_update($input, $id)
    {
        $user_detail['user_id'] = $input['user_id'];
        $user_detail['mobile_phone'] = $input['mobile_phone'];
        return $this->userDetailsService->updateUserDetails($user_detail, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return bool
     */
    public function destroy($id)
    {
        $id;
        return false;
    }

    /**
     * @param $username
     * @return string
     */
    public function checkSponsor($username)
    {
        $sponsor = $this->userService->checkSponsor($username);
        if ($sponsor) {
            return 'Sponsor Id valid';
        }
        return 'Invalid Sponsor User Id';
    }

    /**
     * @param Request $request
     * @return array
     */
    public function findIpCode(Request $request)
    {
        $return = array();

        $data['product_id'] = $request['product_id'];
        $product_id = $request['product_id'];
        $data['ip_type'] = $request['ip_type'];
        $data['purchases_user_id'] = $request['purchases_user_id'];
        $data['ip_used_datetime_null'] = true;
        $data['ip_used_by_null'] = true;
        $data['ip_is_allocated_approved'] = true;
        $data['ip_valid_datetime_ok'] = true;
        $data['ip_valid_datetime_asc'] = true;
        $data['current_date'] = Carbon::now()->format('d/m/Y');
        $ip_code = $this->memberIpAllocationsService->findIPCode($data);
        $product_detail = $this->productsService->findProducts($product_id);
        $return['ip'] = $ip_code->get();
        $return['product_detail'] = $product_detail;

        return json_encode($return);
    }

    /**
     * @param Request $request
     * @return false|string
     */
    public function findTotalIP(Request $request)
    {
        $return = array();

        $data['order_code'] = $request['order_code'];
        $data['ip_type'] = $request['ip_type'];
        $product_list = $this->ipPurchasesService->getProductListByOrderCode($data)->get(); //dd($product_list);
        $parent_ip_purchase = $this->parentIpPurchaseService->getTotalIpQuantity($data)->get(); //dd($total_ip_quantity);
        $return['product_list'] = $product_list;
        $return['parent_ip_purchase'] = $parent_ip_purchase;

        return json_encode($return);
    }

    /**
     * @param $input
     */
    public function insertDesignationHistory($input)
    {
        $data['user_id'] = $input['user_id'];
        $data['current_designation_id'] = 1;
        $current_designation_id = 1;
        $data['next_designation_id'] = $this->designationSalesBonusService->findNextDesignationId($current_designation_id);
        $data['start_date'] = Carbon::now()->format('Y/m/d');
        $data['end_date'] = null;
        $data['total_ip'] = 0;
        $this->designationHistoryService->storeDesignationHistory($data);
    }

    /**
     * @param $input
     */
    public function insertDesignationMonthlyHistory($input)
    {
        $data['user_id'] = $input['user_id'];
        $data['current_designation_id'] = 1;
        $current_designation_id = 1;
        $data['next_designation_id'] = $this->designationSalesBonusService->findNextDesignationId($current_designation_id);
        $data['start_date'] = Carbon::now()->format('Y/m/d');
        $data['end_date'] = Carbon::now()->endOfMonth()->format('Y/m/d');
        $data['total_ip'] = 0;
        $this->designationMonthlyHistoryService->storeDesignationMonthlyHistory($data);
    }

    /**
     * @return Factory|View
     */
    public function generationUpdateCreate()
    {
        $packages = $this->ipPurchasesService->ippurchases(
            array_merge(
                array('is_approved' => 'APPROVED'),
                $this->userService->user_role_display()
            )
        )->get();
        $data['created_by'] = Auth::user()->id;
        $data['transfer_id'] = Auth::user()->id;
        $data['transfer_by'] = Auth::user()->id;
        $data['is_used_null'] = true;
        $data['is_approved_ok'] = true;
        $order_codes = $this->parentIpPurchaseService->getOrderCodesByCreatedBy($data)->get();
        //dd($order_codes);
        return view('backend.user.generation-update.create', compact('packages', 'order_codes'));
    }


    /**
     * @param GenerationUpdateRequest $request
     * @return RedirectResponse
     */
    public function generationUpdateStore(GenerationUpdateRequest $request)
    {
        $purchases_user_id = Auth::user()->id;
        $package['ip_value'] = $request['total_ip_quantity'];
        $package_data = $this->packagesDetailsService->packageDetails($package)->first();
        $previous_generation = $request['generation_id'];
        $present_generation = $package_data['generation_id'];

        try {
            DB::beginTransaction();
            $this->ipTransactionService->storeIPTransaction(array(
                'user_id' => $purchases_user_id,
                'ref_user_id' => $purchases_user_id,
                'ip_transaction_type' => 'generation_update',
                'ip_transaction_total_ip' => $request['total_ip_quantity'],
                'ip_transaction_date' => Carbon::now()->format('Y-m-d H:i:s'),
                'ip_transaction_purpose' => 'generationupdate for ' . $purchases_user_id,
                'ip_transaction_status' => 'UNPAID',
                'status' => 'ACTIVE'
            ));
            $this->updateIPPurchase($request->all());
            $request['purchases_user_id'] = $purchases_user_id;
            $request['ip_used_by'] = $purchases_user_id;
            $this->updateMemberIPAllocationsForUserSignUp($request->all());
            $user_log['user_id'] = $purchases_user_id;
            $user_log['field_type'] = "generation_update";
            $user_log['present_value'] = $this->utilityService->str_ordinal($present_generation) . " Generation";
            $user_log['previous_value'] = $this->utilityService->str_ordinal($previous_generation) . " Generation";
            $user_log['created_by'] = $purchases_user_id;
            $this->userLogService->createUserLog($user_log);
            $user_detail['user_id'] = $purchases_user_id;
            $user_detail_id = $this->userDetailsService->findUserDetailIdByUserId($user_detail);
            $user_detail_data['generation_id'] = $present_generation;
            $user_detail_data['generation_hand_count'] = $present_generation - 1;
            $this->userDetailsService->updateUserDetails($user_detail_data, $user_detail_id->id);
            $this->userPositionService->spUserPositionGenerationBonus();
            DB::commit();

        } catch (Exception $e) {
            DB::rollback();
            flash('Generation update failed', 'error');
            return redirect()->route('generation-update.create');
        }
        flash('Generation updated successfully');
        return redirect()->route('generation-update.create');
    }
}
