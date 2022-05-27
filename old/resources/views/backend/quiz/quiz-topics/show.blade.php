@extends('backend.layouts.master')
@section('title')
    Detail/Show User Detail
@endsection

@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
    @section('content-header')
        <h1>
            <i class="fa fa-building"></i>
            Quiz
            <small>Control panel</small>
        </h1>
        {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
    @endsection
    @include('backend.layouts.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            {!! CHTML::actionButton($reportTitle = '..', $routeLink = '#', $quiz->id, $selectButton = ['backButton', 'editButton'], $class = ' btn-icon btn-circle ', $onlyIcon = 'no', $othersPram = []) !!}
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Course Name</label><br>
                                {{ isset($quiz->course) ? $quiz->course->course_title : null }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Quiz Duration</label><br>
                                {{ isset($quiz) ? $quiz->quiz_duration : 'N/A' }}
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Quiz Topic</label><br>
                                {{ isset($quiz) ? $quiz->quiz_topic : null }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Quiz Type</label><br>
                                {{ isset($quiz) ? $quiz->quiz_type : null }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Quiz Re-Attempt</label><br>
                                {{ isset($quiz) ? $quiz->quiz_re_attempt : null }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Quiz Full Mark</label><br>
                                {{ isset($quiz) ? $quiz->quiz_full_marks : null }}
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Quiz Pass Percentage</label><br>
                                {{ isset($quiz) ? $quiz->quiz_pass_percentage : null }}%
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Quiz Pass Mark</label><br>
                                {{ round(($quiz->quiz_pass_percentage / 100) * $quiz->quiz_full_marks, 2) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Quiz Question URL</label><br>
                                <a
                                    href="{{ isset($quiz) ? $quiz->quiz_url : null }}">{{ isset($quiz) ? $quiz->quiz_url : null }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Quiz Details</label><br>
                                {{ isset($quiz) ? $quiz->quiz_description : null }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT -->
@endsection
