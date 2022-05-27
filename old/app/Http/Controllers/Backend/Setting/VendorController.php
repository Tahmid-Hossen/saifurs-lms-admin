<?php

namespace App\Http\Controllers\Backend\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Setting\VendorRequest;
use App\Services\Backend\Setting\VendorService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class VendorController extends Controller
{
    /**
     * @var VendorService
     */
    private $vendorService;
    /**
     * @var UserService
     */
    private $userService;

    /**
     * VendorController constructor.
     * @param VendorService $vendorService
     * @param UserService $userService
     */
    public function __construct(VendorService $vendorService, UserService $userService)
    {
        $this->vendorService = $vendorService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:UtilityService::$displayRecordPerPage;
            $vendors = $this->vendorService->ShowAllVendor($request)->paginate($request->display_item_per_page);
            return view('backend.setting.vendors.index', compact('vendors', 'request'));
        } catch (\Exception $e) {
            flash('Vendor table not found!')->error();
            return Redirect::to('/backend');
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
            return view('backend.setting.vendors.create');
        } catch (\Exception $e) {
            flash('Something wrong with Vendor Data!')->error();
            return Redirect::to('/vendors');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  VendorRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function store(VendorRequest $request)
    {
        try {
            DB::beginTransaction();
            $vendor = $this->vendorService->storeVendor($request->all());
            if ($vendor) {
                // Vendor Logo
                $request['vendor_id'] = $vendor->id;
                if ($request->hasFile('vendor_logo')) {
                    $image_url = $this->vendorService->vendorLogo($request);
                    $vendor->vendor_logo = $image_url;
                    $vendor->save();
                }
                flash('Vendor created successfully')->success();
            } else {
                flash('Failed to create Vendor')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to create Vendor')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('vendors.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $vendor = $this->vendorService->showVendorByID($id);
            return view('backend.setting.vendors.show', compact('vendor'));
        } catch (\Exception $e) {
            flash('Vendor data not found!')->error();
            return redirect()->route('vendors.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $vendor = $this->vendorService->showVendorByID($id);
            return view('backend.setting.vendors.edit', compact('vendor'));
        } catch (\Exception $e) {
            flash('Vendor data not found!')->error();
            return redirect()->route('vendors.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  VendorRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function update(VendorRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $vendor = $this->vendorService->updateVendor($request->all(), $id);
            if ($vendor) {
                // Vendor Logo
                $request['vendor_id'] = $id;
                if ($request->hasFile('vendor_logo')) {
                    $image_url = $this->vendorService->vendorLogo($request);
                    $vendor->vendor_logo = $image_url;
                    $vendor->save();
                }
                flash('Vendor update successfully')->success();
            } else {
                flash('Failed to update Vendor')->error();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            flash('Failed to update Vendor')->error();
            return redirect()->back()->withInput($request->all());
        }
        return redirect()->route('vendors.index');
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
            $vendor = $this->vendorService->showVendorByID($id);
            if ($vendor) {
                $vendor->delete();
                flash('Vendor deleted successfully')->success();
            }else{
                flash('Vendor not found!')->error();
            }
        }else{
            flash('You Entered Wrong Password!')->error();
        }
        return redirect()->route('vendors.index');
    }
}
