<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\User\BranchRequest;
use App\Services\Backend\Setting\CountryService;
use App\Services\Backend\User\BranchService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
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
        $this->middleware('auth');
        $this->branchService = $branchService;
        $this->companyService = $companyService;
        $this->countryService = $countryService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $branches = $this->branchService->showAllBranch($requestData)->with(['company'])->paginate($request->display_item_per_page);
            $companies = $this->companyService->showAllCompany(array_merge($requestData, array('company_status'=>Constants::$user_active_status)))->get();
            return view('backend.user.branches.index', compact('companies', 'request', 'branches'));
        } catch (\Exception $e) {
            flash('Branch table not found!')->error();
            return Redirect::to('/backend');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $request['company_status'] = Constants::$user_active_status;
            $requestData = array_merge($companyWiseUser,$request->all());
            $companies = $this->companyService->showAllCompany($requestData)->get();
            $countries = $this->countryService->ShowAllCountry(array('id'=>18))->get();
            return view('backend.user.branches.create', compact('countries', 'companies'));
        } catch (\Exception $e) {
            flash('Something wrong with Branch Data!')->error();
            return Redirect::to('/backend/branches');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BranchRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(BranchRequest $request)
    {
        try {
            DB::beginTransaction();
            $branch = $this->branchService->createBranch($request->except('_token'));
            if ($branch) {
                flash('Branch created successfully')->success();
            } else {
                flash('Failed to create Branch')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to create Branch')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('branches.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $branch = $this->branchService->branchById($id);
            return view('backend.user.branches.show', compact('branch'));
        } catch (\Exception $e) {
            flash('Branch data not found!')->error();
            return redirect()->route('branches.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $request['company_id'] = isset($companyWiseUser['company_id'])?$companyWiseUser['company_id']:null;
            $branch = $this->branchService->branchById($id);
            $request['company_status'] = Constants::$user_active_status;
            $companies = $this->companyService->showAllCompany($request)->get();
            $countries = $this->countryService->ShowAllCountry(array('id'=>18, 'country_status'=>Constants::$user_active_status))->get();
            return view('backend.user.branches.edit', compact('countries', 'companies', 'branch'));
        } catch (\Exception $e) {
            flash('Something wrong with Branch Data!')->error();
            return Redirect::to('/backend/branches');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BranchRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(BranchRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $branch = $this->branchService->updateBranch($request->except('_token'), $id);
            if ($branch) {
                flash('Branch update successfully')->success();
            } else {
                flash('Failed to update Branch')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Branch')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('branches.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if(isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id){
            $branch = $this->branchService->branchById($id);
            if ($branch) {
                $branch->delete();
                flash('Branch deleted successfully')->success();
            }else{
                flash('Branch not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('branches.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $request['company_status'] = Constants::$user_active_status;
            $requestData = array_merge($companyWiseUser,$request->all());
            $branches = $this->branchService->showAllBranch($requestData)->orderBy('branches.id','DESC')->get();
            return view('backend.user.branches.pdf', compact('branches'));
        } catch (\Exception $e) {
            flash('Branch table not found!')->error();
            return Redirect::to('/backend/branches');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function excel(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $request['company_status'] = Constants::$user_active_status;
            $requestData = array_merge($companyWiseUser,$request->all());
            $branches = $this->branchService->showAllBranch($requestData)->orderBy('branches.id','DESC')->get();
            return view('backend.user.branches.excel', compact('branches'));
        } catch (\Exception $e) {
            flash('Branch table not found!')->error();
            return Redirect::to('/backend/branches');
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBranchList(Request $request){
        $request['company_status'] = Constants::$user_active_status;
        $request['branch_status'] = Constants::$user_active_status;
        $branches = $this->branchService->showAllBranch($request->all())->get();
        if(count($branches)>0):
            $message = response()->json(['status' => 200, 'data'=>$branches]);
        else:
            $message = response()->json(['status' => 404, 'message'=>'Unauthorised']);
        endif;
        return $message;
    }

}
