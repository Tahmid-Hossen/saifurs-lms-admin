@extends('backend.layouts.master')
@section('title')
    Edit/Update User details
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-user-secret"></i>
        User Details
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
                        <h3 class="box-title">Update </h3>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="user_details_form" role="form" method="POST"
                          action="{{ route('user-details.update',$userDetails->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="user_id" value="{{$userDetails->user_id}}">
                        @include('backend.user.user-details.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection

