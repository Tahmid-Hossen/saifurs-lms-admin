@extends('backend.layouts.master')
@section('title')
    Update Answer Information
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
        @section('content-header')
            <h1>
                <i class="fa fa-reply-all"></i>
                Answer
                <small>Control panel</small>
            </h1>
            {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
        @endsection
        @include('backend.layouts.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit </h3>
                    </div>
                </div>
                <!-- form start -->
                <form class="horizontal-form" id="answer_form" role="form" method="POST"
                      action="{{ route('question-answers.update',$question_answer->id) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('backend.course.question-answer.form')
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
    <!-- END CONTENT -->

@endsection
