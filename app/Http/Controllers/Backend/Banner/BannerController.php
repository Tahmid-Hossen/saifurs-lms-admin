<?php

namespace App\Http\Controllers\Backend\Banner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Banner\BannerRequest;
use App\Services\Backend\Banner\BannerService;
use App\Services\Backend\User\CompanyService;
use App\Services\Backend\User\UserService;
use App\Services\UtilityService;
use Exception;
use Illuminate\Http\Request;

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
        $this->middleware( 'auth' );
        $this->bannerService = $bannerService;
        $this->userService = $userService;
        $this->companyService = $companyService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index( Request $request ) {
        try {
            $request->display_item_per_page = isset($request->display_item_per_page)?$request->display_item_per_page:\Utility::$displayRecordPerPage;
            $companyWiseUser = $this->userService->user_role_display();
            $requestData = array_merge( $companyWiseUser, $request->all() );
            $datas = $this->bannerService->showAllBanner( $requestData )->paginate( $request->display_item_per_page );
            $companies = $this->companyService->showAllCompany( $companyWiseUser )->get();
            return View( 'backend.banners.index', [
                'datas'     => $datas,
                'companies' => $companies,
                'request'   => $request,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Banners table not found!' )->error();
            return redirect( route( 'banners.index' ) );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function create() {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $companies = $this->companyService->showAllCompany( $companyWiseUser )->get();
            return view( 'backend.banners.create', [
                'companies' => $companies,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Banners table not found!' )->error();
            return redirect( route( 'banners.index' ) );
        }
    }

    /**
     * @param BannerRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store( BannerRequest $request ) {
        try {
            $banner = $this->bannerService->bannerCustomInsert( $request->except( 'banner_image', '_token' ) );
            if ( $banner ) {
                $request['banner_id'] = $banner->id;
                if ( $request->hasFile( 'banner_image' ) ) {
                    $image_url = $this->bannerService->bannerImage( $request );
                    $banner->banner_image = $image_url;
                    $banner->save();

                    flash( 'A Banner has been Successfully Created' )->success();
                }
            } else {
                flash( 'Failed to Create a Banner' )->error();
            }
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Failed to Create a Banner' )->error();
            return back()->withInput( $request->all() );
        }
        return redirect( route( 'banners.index' ) );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show( $id ) {
        try {
            $data = $this->bannerService->showBannerByID( $id );
            return view( 'backend.banners.show', [
                'data' => $data,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( "Banner's data not found!" )->error();
            return redirect( route( 'banners.index' ) );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function edit( $id ) {
        try {
            $companyWiseUser = $this->userService->user_role_display();
            $banner = $this->bannerService->showBannerByID( $id );
            $companies = $this->companyService->showAllCompany( $companyWiseUser )->get();
            return view( 'backend.banners.edit', [
                'banner'    => $banner,
                'companies' => $companies,
            ] );
        } catch ( \Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( "Banner's data not found!" )->error();
            return redirect( route( 'banners.index' ) );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BannerRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update( BannerRequest $request, $id ) {
        try {
            $banner = $this->bannerService->bannerCustomUpdate( $request->except( 'banner_image', '_token' ), $id );
            if ( $banner ) {
                $request['banner_id'] = $banner->id;
                $old_image = $request['existing_image'];
                if ( $request->hasFile( 'banner_image' ) ) {
                    $image_url = $this->bannerService->bannerImage( $request );
                    $banner->banner_image = $image_url;
                    $banner->save();
                } else {
                    $banner->banner_image = $old_image;
                    $banner->save();
                }
                flash( 'A Banner has been updated Successfully' )->success();
                return redirect( route( 'banners.index' ) );
            }
        } catch ( Exception $e ) {
            \Log::error( $e->getMessage() );
            flash( 'Failed to update Banner' )->error();
            return back()->withInput( $request->all() );
        }
        return redirect( route( 'banners.index' ) );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function destroy( $id ) {
        $user_get = $this->userService->whoIS( $_REQUEST );
        if ( isset( $user_get ) && isset( $user_get->id ) && $user_get->id == auth()->user()->id ) {
            $data = $this->bannerService->showBannerByID( $id );
            if ( $data ) {
                $data->delete();
                flash( 'Banner deleted successfully' )->success();
            } else {
                flash( 'Banner not found!' )->error();
            }
        } else {
            flash( 'You Entered Wrong Password!' )->error();
        }
        return redirect( route( 'banners.index' ) );
    }
}
