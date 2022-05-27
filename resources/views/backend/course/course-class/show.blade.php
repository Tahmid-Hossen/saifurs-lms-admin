@extends('backend.layouts.master')

@section('content')
@section('content-header')
    <h1>
        <i class="fa fa-file-text"></i>
        Course Lesson
        <small>Control panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection
@include('backend.layouts.flash')
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Course Lesson</h3>
                <div class="pull-right">
                    <a
                        href="{{route('course-classes.index')}}"
                        class="btn btn-danger hidden-print">
                        <i class="glyphicon glyphicon-hand-left"></i> Back
                    </a>
                </div>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="portlet-body">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-8 profile-info">
                            <h3 class="font-green sbold uppercase"
                                style="color: rgb(115, 93, 238)">{{$course_class->class_name}}</h3>
                        </div>

                    </div>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
{{--                                    <tr>
                                        <th>Company: </th>
                                        <th style="color: #00a65a">
                                            {{isset($course_class->company)?strtoupper($course_class->company->company_name):null}}
                                        </th>
                                    </tr>--}}


                                    <tr>
                                        <th>Course: </th>
                                        <th style="color: #76767f">
                                        {{isset($course_class->course)?strtoupper($course_class->course->course_title):null}}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Chapter: </th>
                                        <th style="color: #76767f">
                                        {{isset($course_class->courseChapter)?strtoupper($course_class->courseChapter->chapter_title):null}}
                                        </th>
                                    </tr>
                                    {{-- <tr>
                                        <th>Lesson Type: </th>
                                        <th>
                                            @if($course_class->class_type == \App\Support\Configs\Constants::$class_types[0])
                                                <p style="font-weight:600; color: rgb(13, 138, 40)">{{ strtoupper($course_class->class_type)}}</p>
                                            @else
                                                <p style="font-weight:600; color: rgb(219, 16, 16)">{{ strtoupper($course_class->class_type)}}</p>
                                            @endif
                                        </th>
                                    </tr> --}}
                                    <tr>
                                        <th>Status: </th>
                                        <th>
                                            @if($course_class->class_status == 'ACTIVE')
                                                <button class="btn btn-success btn-sm">{{$course_class->class_status}}</button>
                                            @else
                                                <button class="btn btn-danger btn-sm">{{ str_replace("-","",$course_class->class_status) }}</button>
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Featured: </th>
                                        <th>
                                            @if($course_class->class_featured == 'NO')
                                                    <button class="btn btn-danger btn-sm">{{$course_class->class_featured}}</button>
                                            @else
                                                    <button class="btn btn-info btn-sm">{{$course_class->class_featured}}</button>
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Lesson File: </th>
                                        <th>
                                            @if (isset($course_class->class_file))
                                                {{--<a href="{{url('backend/course-classes/download-file',$course_class->id)}}"><i class="fa fa-download" aria-hidden="true"></i> Download File </a>--}}
                                                <a href="{{url('/').$course_class->class_file}}" target="_blank"><i class="fa fa-download" aria-hidden="true"></i> Download File </a>
                                            @else
                                                <p>N/A</p>
                                            @endif
                                        </th>
                                    </tr>

                                    <tr>
                                        <th>Created By: </th>
                                        <th>{{ isset($course_class->createdBy)?$course_class->createdBy->name:null }}</th>
                                    </tr>
                                    <tr>
                                        <th>Created Date: </th>
                                        <td>{{ isset($course_class->created_at)?$course_class->created_at->format('d M, Y'):null }}</td>
                                    </tr>

                                    {{-- <tr>
                                        <th>Lesson Drip Content: </th>
                                        <td>
                                            @if($course_class->class_drip_content == 'Enable')
                                                <button class="btn btn-primary btn-sm">{{$course_class->class_drip_content}}</button>
                                            @elseif($course_class->class_drip_content == 'Disable')
                                                <button class="btn btn-danger btn-sm">{{$course_class->class_drip_content}}</button>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr> --}}
                                </table>
                            </div>

                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Image:</th>
                                    <td>
                                        @if (isset($course_class->class_image))
                                                {{-- <img src="{{ asset($course_class->class_image) }}" style="width:300px; height:auto" /> --}}
                                                <a href="{{$course_class->class_image}}" target="_blank"><img src="{{ asset($course_class->class_image) }}" style="width:300px; height:auto" /></a>
                                        @else
                                            <p>N/A</p>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Lesson Video:</th>
                                    <th>
                                        @if (isset($course_class->class_video))
                                            <div id="video-player">
                                                <video width="100%" height="300px" controls>
                                                    <source src="{{ url('/').$course_class->class_video }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        @else
                                            <p>N/A</p>
                                        @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Lesson Video URL: </th>
                                        <th>
                                            @if (isset($course_class->class_video_url))
                                                <a href="{{ $course_class->class_video_url }}" target="_blank" style=" margin-top: 8px; width:50px; height:auto">{{ $course_class->class_video_url }}</a>
                                            @else
                                                <p>N/A</p>
                                            @endif
                                        </th>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Short Description: </label>
                                @if (isset($course_class->class_short_description))
                                    <div class="container-fluid" style="border: 2px solid #d2d6de; min-height: 180px">
                                        {!! $course_class->class_short_description !!}
                                    </div>
                                @else
                                    <p>N/A</p>
                                @endif
                            </div>
                        </div>
                    </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Description: </label>
                                    @if (isset($course_class->class_description))
                                        <div class="container-fluid" style="border: 2px solid #d2d6de; min-height: 200px">
                                            {!! $course_class->class_description !!}
                                        </div>
                                    @else
                                        <p>N/A</p>
                                    @endif
                                </div>
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
