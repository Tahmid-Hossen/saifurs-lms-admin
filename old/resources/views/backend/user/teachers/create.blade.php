@extends('backend.layouts.master')
@section('title')
    Create/Add Teacher
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-user-secret"></i>
        Teacher
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
                        <h3 class="box-title">Create </h3>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="teacher_form" role="form" method="POST"
                          action="{{ route('teachers.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('backend.user.teachers.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
@endsection
