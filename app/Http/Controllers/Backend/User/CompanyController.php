<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\User\CompanyRequest;
use App\Services\Backend\Setting\CountryService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CompanyController extends Controller
{
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
     * CompanyController constructor.
     * @param CompanyService $companyService
     * @param CountryService $countryService
     * @param UserService $userService
     */
    public function __construct(CompanyService $companyService, CountryService $countryService, UserService $userService)
    {
        $this->middleware('auth');
        $this->companyService = $companyService;
        $this->countryService = $countryService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $companies = $this->companyService->showAllCompany($requestData)->paginate($request->display_item_per_page);
            return view('backend.user.companies.index', compact('companies', 'request'));
        } catch (\Exception $e) {
            flash('Company table not found!')->error();
            return Redirect::to('/backend');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $countries = $this->countryService->ShowAllCountry(array('id'=>18))->get();
            return view('backend.user.companies.create', compact('countries'));
        } catch (\Exception $e) {
            flash('Something wrong with Company Data!')->error();
            return Redirect::to('/backend/companies');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CompanyRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
        try {
            DB::beginTransaction();
            $checkCompanyData['company_email'] = $request['company_email'];
            $checkCompanyData['company_phone'] = $request['company_phone'];
            $checkCompanyData['company_mobile'] = $request['company_mobile'];
            $checkCompany = $this->companyService->showAllCompany($checkCompanyData)->count();
            if($checkCompany > 0):
                flash('This Company already exists')->error();
                return redirect()->back()->withInput($request->all());
            else:
                $company = $this->companyService->createCompany($request->except('company_logo', '_token'));
                if ($company) {
                    // Company Logo
                    $request['company_id'] = $company->id;
                    if ($request->hasFile('company_logo')) {
                        $image_url = $this->companyService->companyLogo($request);
                        $company->company_logo = $image_url;
                        $company->save();
                        flash('Company created successfully')->success();
                    }
                } else {
                    flash('Failed to create Company')->error();
                }
            endif;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to create Company')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('companies.index');
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
            $company = $this->companyService->companyById($id);
            return view('backend.user.companies.show', compact('company'));
        } catch (\Exception $e) {
            flash('Company data not found!')->error();
            return redirect()->route('companies.index');
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
            $company = $this->companyService->companyById($id);
            $countries = $this->countryService->ShowAllCountry(array('id'=>18))->get();
            return view('backend.user.companies.edit', compact('company', 'countries'));
        } catch (\Exception $e) {
            flash('Company data not found!')->error();
            return redirect()->route('companies.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CompanyRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $checkCompanyData['company_email'] = $request['company_email'];
            $checkCompanyData['company_phone'] = $request['company_phone'];
            $checkCompanyData['company_mobile'] = $request['company_mobile'];
            $checkCompanyData['company_id_not'] = $id;
            $checkCompany = $this->companyService->showAllCompany($checkCompanyData)->count();
            if($checkCompany > 0):
                flash('This Company already exists')->error();
                return redirect()->back()->withInput($request->all());
            else:
                $company = $this->companyService->updateCompany($request->except('company_logo', '_token'), $id);
                if ($company) {
                    // Company Logo
                    $request['company_id'] = $company->id;
                    if ($request->hasFile('company_logo')) {
                        $image_url = $this->companyService->companyLogo($request);
                        $company->company_logo = $image_url;
                        $company->save();
                    }

                    flash('Company update successfully')->success();
                } else {
                    flash('Failed to update Company')->error();
                }
            endif;
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Company')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('companies.index');
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
            $company = $this->companyService->companyById($id);
            if ($company) {
                $company->delete();
                flash('Company deleted successfully')->success();
            }else{
                flash('Company not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('companies.index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser,$request->all());
            $companies = $this->companyService->showAllCompany($requestData)->get();
            return view('backend.user.companies.pdf', compact('companies'));
        } catch (\Exception $e) {
            flash('Company table not found!')->error();
            return Redirect::to('/backend/companies');
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
            $requestData = array_merge($companyWiseUser,$request->all());
            $companies = $this->companyService->showAllCompany($requestData)->get();
            return view('backend.user.companies.excel', compact('companies'));
        } catch (\Exception $e) {
            flash('Company table not found!')->error();
            return Redirect::to('/backend/companies');
        }
    }
}
