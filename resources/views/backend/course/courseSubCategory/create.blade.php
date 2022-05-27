@extends('backend.layouts.master')
@section('title')
    Create/Add Course Sub Category
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-clone"></i>
        Course Sub Category
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
                    <form class="horizontal-form" id="course_sub_category_form" role="form" method="POST"
                          action="{{ route('course-sub-categories.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('backend.course.courseSubCategory.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
@endsection
