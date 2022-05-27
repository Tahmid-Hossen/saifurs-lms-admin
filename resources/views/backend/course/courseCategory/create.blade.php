@extends('backend.layouts.master')
@section('title')
    Create/Add Course Category
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-file-text"></i>
        Course Category
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
                    <form class="horizontal-form" id="course_category_form" role="form" method="POST"
                          action="{{ route('course-categories.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('backend.course.courseCategory.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
@endsection
