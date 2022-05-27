@extends('backend.layouts.master')
@section('title')
    Detail/Show Company
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-building"></i>
        Company
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')

    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
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
                                        $company->id,
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
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_name" class="control-label">Company Name</label><br>
                                            {{ isset($company) ? $company->company_name: null }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_email" class="control-label">Company E-mail</label><br>
                                            {{ isset($company) ? $company->company_email: null }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="company_address" class="control-label">Company
                                                Address</label><br>
                                            {{ isset($company) ? $company->company_address: null }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_phone" class="control-label">Company Phone</label><br>
                                            {{ isset($company) ? $company->company_phone: null }}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="company_mobile" class="control-label">Company Mobile</label><br>
                                            {{ isset($company) ? $company->company_mobile: null }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="state_id">Division</label><br>
                                            {{ isset($company->state)?$company->state->state_name:null }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="city_id">City</label><br>
                                            {{ isset($company->city)?$company->city->city_name:null }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="company_zip_code">Post Code</label><br>
                                            {{ isset($company) ? $company->company_zip_code: null }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="company_status"
                                                   class="control-label">@lang('common.Status')</label><br>
                                            {{ isset($company) ? $company->company_status: null }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="company_logo">Created By</label><br>
                                            {{ isset($company->createdBy) ? $company->createdBy->name: null }}
                                            ({{ isset($company->created_at) ? $company->created_at->format(config('app.date_format2')): null }}
                                            )
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <img
                                    id="company_logo_show" class="img-responsive img-thumbnail"
                                    src="{{isset($company->company_logo)?URL::to($company->company_logo):config('app.default_image')}}"
                                    width="{{\Utility::$companyLogoSize['width']}}"
                                    height="{{\Utility::$companyLogoSize['height']}}"
                                >
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
@endsection
