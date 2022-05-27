@extends('backend.layouts.master')
@section('title')
    Detail/Show Branch
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-building"></i>
        Branch
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
                                        $branch->id,
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name" class="control-label">Company Name</label><br>
                                    {{isset($branch->company)?$branch->company->company_name:null}}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_name" class="control-label">Branch Name</label><br>
                                    {{isset($branch)?$branch->branch_name:null}}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_name" class="control-label">Manager Name</label><br>
                                    {{isset($branch)?$branch->manager_name:null}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_address" class="control-label">Branch Address(English)</label><br>
                                    {{isset($branch)?$branch->branch_address:null}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="branch_address" class="control-label">Branch Address(Bangla)</label><br>
                                    {{isset($branch)?$branch->address_bn:null}}
                                </div>
                            </div>
                        </div>
                       {{-- <div class="row">

                        </div>--}}
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_phone" class="control-label">Branch Phone</label><br>
                                    {{isset($branch)?$branch->branch_phone:null}}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_mobile" class="control-label">Branch Mobile</label><br>
                                    {{isset($branch)?$branch->branch_mobile:null}}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_mobile" class="control-label">Email</label><br>
                                    {{isset($branch)?$branch->branch_email:null}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="hidden" name="country_id" id="country_id" value="18">
                                <div class="form-group">
                                    <label for="state_id">Division</label><br>
                                    {{isset($branch->state)?$branch->state->state_name:null}}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="city_id">City</label><br>
                                    {{isset($branch->city)?$branch->city->city_name:null}}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_zip_code">Post Code</label><br>
                                    {{isset($branch)?$branch->branch_zip_code:null}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_latitude" class="control-label">Branch Latitude</label><br>
                                    {{isset($branch)?$branch->branch_latitude:null}}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_longitude" class="control-label">Branch Longitude</label><br>
                                    {{isset($branch)?$branch->branch_longitude:null}}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_status" class="control-label">@lang('common.Status')</label><br>
                                    {{isset($branch)?$branch->branch_status:null}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
@endsection
