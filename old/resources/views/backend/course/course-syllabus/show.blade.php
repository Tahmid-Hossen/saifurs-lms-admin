@extends('backend.layouts.master')

@section('content')
@section('content-header')
    <style>
        p {
            text-align: left !important;
        }
    </style>
    <h1>
        <i class="fa fa-th-list"></i>
        Syllabus
        <small>Control panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection
@include('backend.layouts.flash')
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Syllabus</h3>
                <div class="pull-right">
                    <a
                        href="{{route('course-syllabuses.index')}}"
                        class="btn btn-danger hidden-print">
                        <i class="glyphicon glyphicon-hand-left"></i> Back
                    </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8 profile-info">
                            <h3 class="font-green sbold uppercase"
                                style="color: rgb(115, 93, 238)">{{$course_syllabus->syllabus_title}}</h3>
                        </div>

                    </div>

                        <!-- <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Course: </th>
                                        <th style="color: #76767f">
                                        {{isset($course_syllabus->course)?$course_syllabus->course->course_title:null}}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Status: </th>
                                        <th>
                                            @if($course_syllabus->syllabus_status == 'ACTIVE')
                                                <button class="btn btn-success btn-sm">{{$course_syllabus->syllabus_status}}</button>
                                            @else
                                                <button class="btn btn-danger btn-sm">{{ str_replace("-","",$course_syllabus->syllabus_status) }}</button>
                                            @endif
                                        </th>
                                    </tr>

                                    <tr>
                                        <th>Created By: </th>
                                        <th>{{ isset($course_syllabus->createdBy)?$course_syllabus->createdBy->name:null }}</th>
                                    </tr>
                                    <tr>
                                        <th>Created Date: </th>
                                        <td>{{ isset($course_syllabus->created_at)?$course_syllabus->created_at->format('d M, Y'):null }}</td>
                                    </tr>

                                </table>
                        </div> -->
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Company:</th>
                                    <th style="color: #76767f">{{ isset($course_syllabus->company)?strtoupper($course_syllabus->company->company_name):null }}</th>
                                </tr>
                                <tr>
                                    <th>Course:</th>
                                    <th style="color: #76767f">{{ isset($course_syllabus->course)?strtoupper($course_syllabus->course->course_title):null }}</th>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <th>
                                        @if($course_syllabus->syllabus_status == 'ACTIVE')
                                            <button
                                                class="btn btn-success btn-sm">{{$course_syllabus->syllabus_status}}
                                            </button>
                                        @else
                                            <button
                                                class="btn btn-danger btn-sm">{{ str_replace("-","",$course_syllabus->syllabus_status) }}
                                            </button>
                                        @endif
                                    </th>
                                </tr>


                                <tr>
                                    <th>Created By:</th>
                                    <th>{{ isset($course_syllabus->createdBy)?$course_syllabus->createdBy->name:null }}</th>
                                </tr>
                                <tr>
                                    <th>Created Date:</th>
                                    <td>{{ isset($course_syllabus->created_at)?$course_syllabus->created_at->format('d M, Y'):null }}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Syllabus File:</th>
                                    <th>
                                        @if (isset($course_syllabus->syllabus_file))
                                            {{--<a href="{{url('backend/course-syllabuses/download-file',$course_syllabus->id)}}"><i class="fa fa-download" aria-hidden="true"></i> Download File </a>--}}
                                            <a href="{{ url('/').$course_syllabus->syllabus_file }}"><i class="fa fa-download" aria-hidden="true"></i> Download File </a>
                                        @else
                                            <p>N/A</p>
                                        @endif
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Notes:</th>
                                    <td class="text-left">{!! $course_syllabus->syllabus_details !!}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</div>

@endsection
