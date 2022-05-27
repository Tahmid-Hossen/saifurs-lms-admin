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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class TeacherController extends Controller
{
    /**
     * @var UserDetailsService
     */
    private $userDetailsService;
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var CountryService
     */
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
     * TeacherController constructor.
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
    ){
        $this->userDetailsService = $userDetailsService;
        $this->userService = $userService;
        $this->countryService = $countryService;
        $this->companyService = $companyService;
        $this->branchService = $branchService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $request['user_detail_start_date'] = isset($request['user_detail_start_date'])?$request['user_detail_start_date'].' 00:00:01':Carbon::now()->subDay(29)->format('Y-m-d').' 00:00:01';
            $request['user_detail_end_date'] = isset($request['user_detail_end_date'])?($request['user_detail_end_date'].' 23:59:59'):(Carbon::now()->format('Y-m-d').' 23:59:59');
            $request['date_range'] = Carbon::now()->subDay(29)->format('F d, Y').' - '.Carbon::now()->format('F d, Y');
            $companyWiseUser = $this->userService->user_role_display();
            $request['role_id_in'] = array(6,8);
            $request['company_status'] = Constants::$user_active_status;
            $requestData = array_merge($companyWiseUser,$request->all());
            $teachers = $this->userDetailsService->userDetails($requestData)->paginate(UtilityService::$displayRecordPerPage);
            $companies = $this->companyService->showAllCompany($requestData)->get();
            $branches = $this->branchService->showAllBranch($requestData)->get();
            return View('backend.user.teachers.index', compact('teachers', 'request', 'companies', 'branches'));
        } catch (\Exception $e) {
            flash('Teachers table not found!')->error();
            return Redirect::to('/backend/teachers');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $request['company_status'] = Constants::$user_active_status;
            $requestData = array_merge($companyWiseUser, $request);
            $countries = $this->countryService->ShowAllCountry(array('id'=>18))->get();
            $companies = $this->companyService->showAllCompany($requestData)->get();
            $roles = $this->userService->getAllRoleByFilter(array('role_id_in'=>array(6,8)))->get();
            return view('backend.user.teachers.create', compact('countries', 'roles', 'companies'));
        } catch (\Exception $e) {
            flash('Teacher table not found!')->error();
            return Redirect::to('/backend/teachers');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserDetailsRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
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
            flash('Failed to create Teacher', 'error');
            return redirect()->route('teachers.create')->with($request->all());
        }

        flash('Teacher created successfully');
        return redirect()->route('teachers.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $teacher = $this->userDetailsService->userDetailsById($id);
        return view(
            'backend.user.teachers.show',
            compact(
                'teacher'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $companyWiseUser = $this->userService->user_role_display();
            $request['company_status'] = Constants::$user_active_status;
            $requestData = array_merge($companyWiseUser, $request);
            $countries = $this->countryService->ShowAllCountry(array('id'=>18))->get();
            $teacher = $this->userDetailsService->userDetailsById($id);
            $companies = $this->companyService->showAllCompany($requestData)->get();
            $roles = $this->userService->getAllRoleByFilter(array('role_id_in'=>array(6,8)))->get();
            return view('backend.user.teachers.edit', compact( 'teacher', 'countries', 'roles', 'companies'));
        } catch (\Exception $e) {
            flash('Teacher table not found!')->error();
            return Redirect::to('/backend/user-details');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserDetailsRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserDetailsRequest $request, $id)
    {
        $user_id = $request['user_id'];
        try{
            DB::beginTransaction();
            if(!$request->has('name')):
                $request['name'] = $request->first_name.' '.$request->last_name;
            endif;
            $user = $this->userService->user_custom_update($request->all(), $user_id);
            if($user){
                $userDetail = $this->userDetailsService->user_details_custom_update($request->all(), $id);
                $request['user_detail_id'] = $userDetail->id;
                if ($request->hasFile('user_detail_photo')) {
                    $image_url = $this->userDetailsService->userDetailPhoto($request);
                    $userDetail->user_detail_photo = $image_url;
                    $userDetail->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Teacher', 'error');
            return redirect()->route('teachers.edit', $id)->with($request->all());
        }

        flash('Teacher updated successfully');
        return redirect()->route('teachers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $userDetails = $this->userDetailsService->userDetailsById($id);
        if($userDetails){
            $userDetails->delete();
            DB::commit();
            flash('Teacher deleted successfully');
            return redirect()->route('teachers.index');
        } else {
            DB::rollBack();
            flash('Teacher not updated successfully');
            return redirect()->route('teachers.index');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $request['user_detail_start_date'] = isset($request['user_detail_start_date'])?$request['user_detail_start_date'].' 00:00:01':Carbon::now()->subDay(29)->format('Y-m-d').' 00:00:01';
            $request['user_detail_end_date'] = isset($request['user_detail_end_date'])?($request['user_detail_end_date'].' 23:59:59'):(Carbon::now()->format('Y-m-d').' 23:59:59');
            $request['date_range'] = Carbon::now()->subDay(29)->format('F d, Y').' - '.Carbon::now()->format('F d, Y');
            $companyWiseUser = $this->userService->user_role_display();
            $request['role_id_in'] = array(6,8);
            $request['company_status'] = Constants::$user_active_status;
            $requestData = array_merge($companyWiseUser,$request->all());
            $userDetails = $this->userDetailsService->userDetails($requestData)->with(['user','user.roles'])->get();
            return View('backend.user.teachers.pdf', compact('userDetails', 'request'));
        } catch (\Exception $e) {
            flash('Teacher table not found!')->error();
            return Redirect::to('/backend/teachers');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function excel(Request $request)
    {
        try {
            $request['user_detail_start_date'] = isset($request['user_detail_start_date'])?$request['user_detail_start_date'].' 00:00:01':Carbon::now()->subDay(29)->format('Y-m-d').' 00:00:01';
            $request['user_detail_end_date'] = isset($request['user_detail_end_date'])?($request['user_detail_end_date'].' 23:59:59'):(Carbon::now()->format('Y-m-d').' 23:59:59');
            $request['date_range'] = Carbon::now()->subDay(29)->format('F d, Y').' - '.Carbon::now()->format('F d, Y');
            $companyWiseUser = $this->userService->user_role_display();
            $request['role_id_in'] = array(6,8);
            $request['company_status'] = Constants::$user_active_status;
            $requestData = array_merge($companyWiseUser,$request->all());
            $userDetails = $this->userDetailsService->userDetails($requestData)->with(['user','user.roles'])->get();
            return View('backend.user.teachers.excel', compact('userDetails', 'request'));
        } catch (\Exception $e) {
            flash('Teacher table not found!')->error();
            return Redirect::to('/backend/teachers');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserDetailList(Request $request){
        $companyWiseUser = $this->userService->user_role_display();
        $request['role_id_in'] = array(6,8);
        $request['company_status'] = Constants::$user_active_status;
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
