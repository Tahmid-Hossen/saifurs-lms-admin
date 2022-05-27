@extends('backend.layouts.master')
@section('title')
    Detail/Show Vendor
@endsection


@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @section('content-header')
            <h1>
                <i class="fa fa-building"></i>
                Vendor
                <small>Control Panel</small>
            </h1>
            {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
        @endsection
        @include('backend.layouts.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail</h3>
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                {!!
                                    \CHTML::actionButton(
                                        $reportTitle='..',
                                        $routeLink='#',
                                        $vendor->id,
                                        $selectButton=['backButton','editButton'],
                                        $class = ' btn-icon btn-circle ',
                                        $onlyIcon='no',
                                        $othersPram=array()
                                    )
                                !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="vendor_name" class="control-label">Vendor Name</label><br>
                                                {{isset($vendor) ? $vendor->vendor_name: null}}
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="vendor_status" class="control-label">@lang('common.Status')</label><br>
                                                {{isset($vendor) ? $vendor->vendor_status: null}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="vendor_logo">Vendor Logo</label><br>
                                        <img
                                            id="vendor_logo_show"
                                            src="{{isset($vendor->vendor_logo)?URL::to($vendor->vendor_logo):config('app.default_image')}}"
                                            width="{{\Utility::$vendorLogoSize['width']}}"
                                            height="{{\Utility::$vendorLogoSize['height']}}"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection
