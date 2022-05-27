@extends('backend.layouts.master')
@section('title')
    Create/Add Answer
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-reply-all"></i>
        Answer
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
                        <h3 class="box-title">Create </h3>&nbsp;<span
                            class="text-danger"></span>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="answer_form" role="form" method="POST"
                          action="{{ route('question-answers.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('backend.course.question-answer.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection

@push('scripts')

@endpush
