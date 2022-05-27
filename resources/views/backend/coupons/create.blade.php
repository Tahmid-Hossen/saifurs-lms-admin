@extends('backend.layouts.master')
@section('title')
    Manage Coupon
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-scissors"></i>
        Coupon
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
                        <h3 class="box-title">Create</h3>&nbsp;<sub class="text-danger text-sm-right"><i></i></sub>
                    </div>
                <!-- form start -->
                <form class="horizontal-form" id="coupon_form" role="form" method="POST"
                    action="{{ route('coupons.store') }}">
                    @csrf
                    @include('backend.coupons.form')
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection
