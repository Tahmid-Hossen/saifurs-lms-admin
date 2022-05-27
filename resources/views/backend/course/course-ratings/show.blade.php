@extends('backend.layouts.master')
@section('title')
    Detail/Show Course Rating
@endsection

@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @section('content-header')
            <h1>
                <i class="fa fa-building"></i>
                Course rating
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
                                {!! CHTML::actionButton($reportTitle = '..', $routeLink = '#', $data->id, $selectButton = ['backButton', 'editButton'], $class = ' btn-icon btn-circle ', $onlyIcon = 'no', $othersPram = []) !!}
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Course Name</label><br>
                                    {{$data->course->course_title}}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Stars Given By {{ $data->user->name }}</label><br>
                                    {!! \App\Services\CustomHtmlService::startRating($data->course_rating_stars) !!}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label">Review</label><br>
                                    {!! $data->course_rating_feedback !!}
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="control-label">Course Rating Status</label><br>
                                @if ($data->course_rating_status == 'ACTIVE')
                                    <b class="text-success">{{ $data->course_rating_status }}</b>
                                @else <b class="text-danger">{{ $data->course_rating_status }}</b>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection
