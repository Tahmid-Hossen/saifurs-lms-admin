@extends('backend.layouts.master')
@section('title')
    Create/Add Course Lesson
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-laptop"></i>
        Course Lesson
        <small>Control panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <style>
        .form-group.view-duration {
            margin-top: 25px;
            margin-left: -31px;
        }
    </style>
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @include('backend.layouts.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create </h3>&nbsp;<sub class="text-danger text-sm-right"><i>(All "*"
                                fields are required)</i></sub>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="class_form" role="form" method="POST"
                          action="{{ route('course-classes.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('backend.course.course-class.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
@endsection
