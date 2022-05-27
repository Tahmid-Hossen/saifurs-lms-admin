<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Backend\Coupon\CouponRequest;
use App\Services\Backend\Coupon\CouponService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Exception;
use http\Client\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

class CouponController
{
    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var CouponService
     */
    private $couponService;

    /**
     * CouponController constructor.
     * @param CompanyService $companyService
     * @param UserService $userService
     * @param CouponService $couponService
     */
    public function __construct(CompanyService $companyService, UserService $userService, CouponService $couponService)
    {
        $this->companyService = $companyService;
        $this->userService = $userService;
        $this->couponService = $couponService;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $datas = $this->couponService->showAllCoupon($requestData)->paginate(UtilityService::$displayRecordPerPage);
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            return View('backend.coupons.index', [
                'datas' => $datas,
                'companies' => $companies,
                'request' => $request,
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Coupons table not found!')->error();
            return redirect(route('coupons.index'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws Exception
     */
    public function create()
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            return view('backend.coupons.create', [
                'companies' => $companies,
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Coupons table not found!')->error();
            return redirect(route('coupons.index'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CouponRequest $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function store(CouponRequest $request): RedirectResponse
    {
        try {
            $this->couponService->couponCustomInsert($request->except('_token'));
            flash('A Coupon has been Successfully Managed')->success();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Failed to Manage a Coupon')->error();
            return back()->with($request->all());
        }
        return redirect(route('coupons.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $data = $this->couponService->showCouponByID($id);
            return view('backend.coupons.show', ['data' => $data]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Coupon data not found!')->error();
            return redirect(route('coupons.index'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response|Application|RedirectResponse|Redirector|void
     */
    public function edit($id)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $data = $this->couponService->showCouponByID($id);
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            return view('backend.coupons.edit', [
                'data' => $data,
                'companies' => $companies,
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Coupon table not found!')->error();
            return redirect()->route('coupons.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CouponRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CouponRequest $request, $id): RedirectResponse
    {
        try {
            $this->couponService->couponCustomUpdate($request->except('_token'), $id);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Failed to Update the Coupon')->error();
            return back()->withInput($request->all());
        }
        flash('Coupon updated successfully')->success();
        return redirect(route('coupons.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $user_get = $this->userService->whoIS($_REQUEST);
        if (isset($user_get) && isset($user_get->id) && $user_get->id == auth()->user()->id) {
            $data = $this->couponService->showCouponByID($id);
            if ($data) {
                $data->delete();
                flash('Coupon deleted successfully')->success();
            } else {
                flash('Coupon not found!')->error();
            }
        } else {
            flash('You Entered Wrong Password!')->error();
        }
        return redirect(route('coupons.index'));
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function pdf(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $datas = $this->couponService->showAllCoupon($requestData)->paginate(UtilityService::$displayRecordPerPage);
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            return View('backend.coupons.pdf', [
                'datas' => $datas,
                'companies' => $companies,
                'request' => $request,
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Coupons table not found!')->error();
            return redirect(route('coupons.index'));
        }
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse
     */
    public function excel(Request $request)
    {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge($companyWiseUser, $request->all());
            $datas = $this->couponService->showAllCoupon($requestData)->paginate(UtilityService::$displayRecordPerPage);
            $companies = $this->companyService->showAllCompany($companyWiseUser)->get();
            return View('backend.coupons.excel', [
                'datas' => $datas,
                'companies' => $companies,
                'request' => $request,
            ]);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            flash('Coupons table not found!')->error();
            return redirect(route('coupons.index'));
        }
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function check(Request $request): JsonResponse
    {
        $response = [
            'status' => false,
            'message' => '',
            'total_price' => $request->total_price ?? 0,
            'coupon' => null
        ];
        
        $coupon = $this->couponService->validateCoupon($request->except('_token'));
        if ($coupon) {
            $calculated_price = $this->couponService->totalPriceCalculation($coupon, $request->total_price ?? 0);
            if ($calculated_price < 10) {
                $response['status'] = false;
                $response['message'] = 'Insufficient price';
            } else {
                $response['status'] = true;
                $response['message'] = 'Coupon Verified';
                $response['total_price'] = $calculated_price;
                $response['coupon'] = $coupon;
            } 
        } else {
            $response['status'] = false;
            $response['message'] = 'Coupon Not Available or Expired';
        }
        return response()->json($response);
    }
}
