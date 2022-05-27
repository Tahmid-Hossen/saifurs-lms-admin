@extends('backend.layouts.master')
@section('title')
    Detail/Show Country
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-flag"></i>
        Country
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
                                        $country->id,
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country_name" class="control-label">Country Name</label><br>
                                    {{isset($country) ? $country->country_name: null}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country_language" class="control-label">Country Language</label><br>
                                    {{isset($country) ? $country->country_language: null}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country_iso" class="control-label">Country ISO</label><br>
                                    {{isset($country) ? $country->country_iso: null}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country_iso3" class="control-label">Country ISO3</label><br>
                                    {{isset($country) ? $country->country_iso3: null}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country_num_code" class="control-label">Country Num Code</label><br>
                                    {{isset($country) ? $country->country_num_code: null}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country_phone_code" class="control-label">Country Phone Code</label><br>
                                    {{isset($country) ? $country->country_phone_code: null}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country_currency" class="control-label">Country Currency</label><br>
                                    {{isset($country) ? $country->country_currency: null}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="country_currency_symbol" class="control-label">Country Currency
                                        Symbol</label><br>
                                    {!!  isset($country) ? $country->country_currency_symbol: null!!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country_status"
                                                       class="control-label">@lang('common.Status')</label><br>
                                                {{isset($country) ? $country->country_status: null}}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="country_logo">Country Flag</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <img class="img-responsive img-thumbnail img-rounded"
                                            id="country_logo_show"
                                            src="{{isset($country->country_logo)?URL::to($country->country_logo):config('app.default_image')}}"
                                            width="{{\Utility::$countryFlagSize['width']/2}}"
                                            height="{{\Utility::$countryFlagSize['height']/2}}"
                                        >
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
