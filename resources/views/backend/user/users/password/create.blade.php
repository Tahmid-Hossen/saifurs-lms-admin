@extends('backend.layouts.master')
@section('title')
    Change Password
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-key"></i>
        Change Password
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
@include('backend.layouts.flash')
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Change Password </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="portlet-body">
                <form class="form-group" role="form" method="POST" action="{{ route('changePasswordPost',['id'=> auth()->user()->id]) }}" id="changePassword">
                   @csrf
                    @include('backend.user.users.password.form')
                    <div class="box-footer">
                    </div>
                </form>
                <div>
                    <!-- /.box -->
                </div>
            </div>

        </div>
    @endsection

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    @section('page_scripts')

    @endsection
    <!-- END PAGE LEVEL PLUGINS -->
