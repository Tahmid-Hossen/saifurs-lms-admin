<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\User\UserDetailsRequest;
use App\Services\Backend\Setting\CountryService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserDetailsService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Backend\User\UserDetail;

class UserDetailController extends Controller
{
    /**
     * @var UserDetailsService
     */
    private $userDetailsService;
    /**
     * @var UserService
     */
    private $userService;

    private $countryService;
    /**
     * @var CompanyService
     */
    private $companyService;
    /**
     * @var BranchService
     */
    private $branchService;

    /**
     * UserDetailController constructor.
     * @param UserDetailsService $userDetailsService
     * @param UserService $userService
     * @param CountryService $countryService
     * @param CompanyService $companyService
     * @param BranchService $branchService
     */
    public function __construct(
        UserDetailsService $userDetailsService,
        UserService $userService,
        CountryService $countryService,
        CompanyService $companyService,
        BranchService $branchService
    )
    {

        $this->userDetailsService = $userDetailsService;
        $this->userService = $userService;
        $this->countryService = $countryService;
        $this->companyService = $companyService;
        $this->branchService = $branchService;
    }


    /**
     * @param Request $request
     * @return Factory|RedirectResponse|View
     */
    public function index(Request $request)
    {
        try {
            $request['user_detail_start_date'] = isset($request['user_detail_start_date'])?$request['user_detail_start_date'].' 00:00:01':Carbon::now()->subDay(29)->format('Y-m-d').' 00:00:01';
            $request['user_detail_end_date'] = isset($request['user_detail_end_date'])?($request['user_detail_end_date'].' 23:59:59'):(Carbon::now()->format('Y-m-d').' 23:59:59');
            $request['date_range'] = Carbon::now()->subDay(29)->format('F d, Y').' - '.Carbon::now()->format('F d, Y');
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $userDetails = $this->userDetailsService->userDetails($requestData)
                ->with('user', 'user.roles')
                ->paginate(UtilityService::$displayRecordPerPage);
            $roles = $this->userService->getAllRoles();
            $companies = $this->companyService->showAllCompany($requestData)->get();
            $branches = $this->branchService->showAllBranch($requestData)->get();
            return View('backend.user.user-details.index', compact('userDetails', 'request', 'companies', 'branches', 'roles'));
        } catch (\Exception $e) {
            flash('User Details table not found!')->error();
            return Redirect::to('/backend/user-details');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Contracts\View\View|RedirectResponse|\Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $countries = $this->countryService->ShowAllCountry(array('id'=>18))->get();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $roles = $this->userService->getAllRoles();
            return view('backend.user.user-details.create', compact('countries', 'roles', 'companies'));
        } catch (\Exception $e) {
            flash('User Details table not found!')->error();
            return Redirect::to('/backend/user-details');
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param UserDetailsRequest $request
     * @return RedirectResponse
     * @throws \Throwable
     */
    public function store(UserDetailsRequest $request)
    {
        try {
            DB::beginTransaction();
            if(!$request->has('name')):
                $request['name'] = $request->first_name.' '.$request->last_name;
            endif;
            $user = $this->userService->user_custom_insert($request->all());
            if($user){
                $request['user_id'] = $user->id;
                $userDetail = $this->userDetailsService->user_detail_custom_insert($request->all());
                $request['user_detail_id'] = $userDetail->id;
                if ($request->hasFile('user_detail_photo')) {
                    $image_url = $this->userDetailsService->userDetailPhoto($request);
                    $userDetail->user_detail_photo = $image_url;
                    $userDetail->save();
                }
            }
            DB::commit();
        }catch (\Exception $e) {
            DB::rollback();
            flash('Failed to create User details', 'error');
            return redirect()->route('user-details.create')->with($request->all());
        }

        flash('User details created successfully');
        return redirect()->route('user-details.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $get_id = UserDetail::where('user_id',$id)->select('id')->first();
        $userDetails = $this->userDetailsService->userDetailsById($get_id->id);

        return view(
            'backend.user.user-details.show',
            compact(
                'userDetails'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Contracts\View\View|RedirectResponse|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $companyWiseUser = $this->userService->user_role_display();
            $countries = $this->countryService->ShowAllCountry(array('id'=>18))->get();
            $userDetails = $this->userDetailsService->userDetailsById($id);
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            $roles = $this->userService->getAllRoles();
            $userRoles = $userDetails->user->roles()->pluck('id')->toArray();
            return view('backend.user.user-details.edit', compact( 'userDetails', 'countries', 'roles', 'companies', 'userRoles'));
        } catch (\Exception $e) {
            flash('User details table not found!')->error();
            return Redirect::to('/backend/user-details');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserDetailsRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $user_id = $request['user_id'];
        try{
            DB::beginTransaction();
            if(!$request->has('name')):
                $request['name'] = $request->first_name.' '.$request->last_name;
            endif;
            $user = $this->userService->user_custom_update($request->all(), $user_id);
            if($user){
                $userDetail = $this->userDetailsService->user_details_custom_update($request->all(), $id);
                // dd($userDetail);
                $request['user_detail_id'] = $userDetail->id;
                $request['user_detail_photo_old'] = $userDetail->user_detail_photo;
                if ($request->hasFile('user_detail_photo')) {
                    $image_url = $this->userDetailsService->userDetailPhoto($request);
                    $userDetail->user_detail_photo = $image_url;
                    $userDetail->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            DB::rollback();
            flash('Failed to update user details', 'error');
            return redirect()->route('user-details.edit', $id)->with($request->all());
        }

        flash('User details updated successfully');
        return redirect()->route('user-details.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $userDetails = $this->userDetailsService->userDetailsById($id);
        $userDetails->user()->delete();
        $userDetails->delete();
        if($userDetails){
            $userDetails->user()->update(['status'=>Constants::$user_default_status]);
            DB::commit();
            flash('User details deleted successfully');
            return redirect()->route('user-details.index');
        } else {
            DB::rollBack();
            flash('User details not updated successfully');
            return redirect()->route('user-details.index');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $request['user_detail_start_date'] = isset($request['user_detail_start_date'])?$request['user_detail_start_date'].' 00:00:01':Carbon::now()->subDay(29)->format('Y-m-d').' 00:00:01';
            $request['user_detail_end_date'] = isset($request['user_detail_end_date'])?($request['user_detail_end_date'].' 23:59:59'):(Carbon::now()->format('Y-m-d').' 23:59:59');
            $request['date_range'] = Carbon::now()->subDay(29)->format('F d, Y').' - '.Carbon::now()->format('F d, Y');
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $userDetails = $this->userDetailsService->userDetails($requestData)->with(['user','user.roles'])->get();
            return View('backend.user.user-details.pdf', compact('userDetails', 'request'));
        } catch (\Exception $e) {
            flash('User Details table not found!')->error();
            return Redirect::to('/backend/user-details');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|Factory|\Illuminate\Contracts\View\View|RedirectResponse
     */
    public function excel(Request $request)
    {
        try {
            $request['user_detail_start_date'] = isset($request['user_detail_start_date'])?$request['user_detail_start_date'].' 00:00:01':Carbon::now()->subDay(29)->format('Y-m-d').' 00:00:01';
            $request['user_detail_end_date'] = isset($request['user_detail_end_date'])?($request['user_detail_end_date'].' 23:59:59'):(Carbon::now()->format('Y-m-d').' 23:59:59');
            $request['date_range'] = Carbon::now()->subDay(29)->format('F d, Y').' - '.Carbon::now()->format('F d, Y');
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $userDetails = $this->userDetailsService->userDetails($requestData)->with(['user','user.roles'])->get();
            return View('backend.user.user-details.excel', compact('userDetails', 'request'));
        } catch (\Exception $e) {
            flash('User Details table not found!')->error();
            return Redirect::to('/backend/user-details');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserDetailList(Request $request){
        $companyWiseUser = $this->userService->user_role_display();
        $requestData = array_merge($companyWiseUser,$request->all());
        $userDetails = $this->userDetailsService->userDetails($requestData)->get();
        if(count($userDetails)>0):
            $message = response()->json(['status' => 200, 'data'=>$userDetails]);
        else:
            $message = response()->json(['status' => 404, 'message'=>'Unauthorised']);
        endif;
        return $message;
    }
}
