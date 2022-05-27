@extends('backend.layouts.master')
@section('title')
    Detail/Show Coupon
@endsection


@section('content-header')
    <h1>
        <i class="fa fa-building"></i>
        Coupon
        <small>Control panel</small>
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
                                {!! CHTML::actionButton($reportTitle = '..', $routeLink = '#', $data->id, $selectButton = ['backButton', 'editButton'], $class = ' btn-icon btn-circle ', $onlyIcon = 'no', $othersPram = []) !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-footer with-border">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Coupon Title</label><br>
                                    {{ isset($data) ? $data->coupon_title : null }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Coupon Code</label><br>
                                    {{ isset($data) ? $data->coupon_code : null }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Coupon Status</label><br>
                                    {{ isset($data) ? $data->coupon_status : null }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Coupon Starts</label><br>
                                    {{ \Carbon\Carbon::parse($data->coupon_start)->format('d F, Y h:i A') }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Coupon Ends</label><br>
                                    {{ \Carbon\Carbon::parse($data->coupon_end)->format('d F, Y h:i A') }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Coupon Validity</label><br>
                                    @if (\Carbon\Carbon::now()->lte($data->coupon_end))
                                        <b class="text-green">Valid</b>
                                    @else
                                        <b class="text-orange">Expired</b>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Discount Type</label><br>
                                    @if(isset($data->discount_type))
                                        {{ \Utility::$discount_types[$data->discount_type] }}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Discount Amount</label><br>
                                    {{ \CHTML::numberFormat($data->discount_amount ?? 0) }}
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label">Effect On</label><br>
                                    <b class="text-bold text-green">Sub-Total</b>
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
