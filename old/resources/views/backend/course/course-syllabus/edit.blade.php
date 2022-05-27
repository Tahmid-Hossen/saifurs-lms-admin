@extends('backend.layouts.master')
@section('title')
    Update Syllabus Information
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-th-list"></i>
        Syllabus
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
                        <h3 class="box-title">Edit </h3>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="syllabus_form" role="form" method="POST"
                          action="{{ route('course-syllabuses.update',$course_syllabus->id) }}"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('backend.course.course-syllabus.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
@endsection

@push('scripts')

@endpush
