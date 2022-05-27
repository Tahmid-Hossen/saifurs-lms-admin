@extends('backend.layouts.master')

@section('title')
    Create/Add Course
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-paragraph" aria-hidden="true"></i>
        Course
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
                        <h3 class="box-title">Create </h3>&nbsp;<span
                            class="text-danger"></span>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="course_form" role="form" method="POST"
                          action="{{ route('course.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('backend.course.course.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
@endsection


