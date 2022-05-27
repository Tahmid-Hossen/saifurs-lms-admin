@extends('backend.layouts.master')
@section('title')
    Create/Add Course Chapter
@endsection


@section('content-header')
    <h1>
        <i class="fa fa-file-text"></i>
        Course Chapter
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
                        <h3 class="box-title">Create </h3>&nbsp;<span
                            class="text-danger"></span>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="chapter_form" role="form" method="POST"
                          action="{{ route('course-chapters.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('backend.course.course-chapter.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
@endsection
