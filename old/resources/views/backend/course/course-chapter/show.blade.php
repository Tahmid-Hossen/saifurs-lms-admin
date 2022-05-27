@extends('backend.layouts.master')


@section('content')
@section('content-header')
    <h1>
        <i class="fa fa-file-text"></i>
        Course Chapter
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
                <h3 class="box-title">Course Chapter</h3>
                <div class="pull-right">
                    <a
                        href="{{route('course-chapters.index')}}"
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
                                style="color: rgb(115, 93, 238)">{{$course_chapter->chapter_title}}</h3>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
{{--                                <tr>
                                    <th>Company:</th>
                                    <th style="color: #00a65a">
                                        {{isset($course_chapter->company)?strtoupper($course_chapter->company->company_name):null}}
                                    </th>
                                </tr>--}}
                                <tr>
                                    <th>Course:</th>
                                    <th style="color: #76767f">
                                        {{isset($course_chapter->course)?strtoupper($course_chapter->course->course_title):null}}
                                    </th>
                                </tr>
                                <tr>
                                    <th>Status:</th>
                                    <th>
                                        @if($course_chapter->chapter_status == 'ACTIVE')
                                            <button
                                                class="btn btn-success btn-sm">{{$course_chapter->chapter_status}}</button>
                                        @else
                                            <button
                                                class="btn btn-danger btn-sm">{{ str_replace("-","",$course_chapter->chapter_status) }}</button>
                                        @endif
                                    </th>
                                </tr>

                                <tr>
                                    <th>Chapter File:</th>
                                    <th>
                                        @if (isset($course_chapter->chapter_file))
                                            {{--<a href="{{url('backend/course-chapters/download-file',$course_chapter->id)}}"><i class="fa fa-download" aria-hidden="true"></i> Download File </a>--}}
                                            <a href="{{url('/').$course_chapter->chapter_file}}"><i class="fa fa-download" aria-hidden="true"></i> Download File </a>
                                        @else
                                            <p>N/A</p>
                                        @endif
                                    </th>
                                </tr>

                                <tr>
                                    <th>Created By:</th>
                                    <th>{{ isset($course_chapter->createdBy)?$course_chapter->createdBy->name:null }}</th>
                                </tr>
                                <tr>
                                    <th>Created Date:</th>
                                    <th>{{ $course_chapter->created_at->format('d M, Y') }}</th>
                                </tr>

                                {{--                                    <tr>--}}
                                {{--                                        <th>Chapter Drip Content: </th>--}}
                                {{--                                        <td>--}}
                                {{--                                            @if($course_chapter->chapter_drip_content == 'Disable')--}}
                                {{--                                                    <button class="btn btn-danger btn-sm">{{$course_chapter->chapter_drip_content}}</button>--}}
                                {{--                                            @else--}}
                                {{--                                                    <button class="btn btn-primary btn-sm">{{$course_chapter->chapter_drip_content}}</button>--}}
                                {{--                                            @endif--}}
                                {{--                                        </td>--}}
                                {{--                                    </tr>--}}
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Image:</th>
                                    <th>
                                        @if (isset($course_chapter->chapter_image))
                                            <a href="{{$course_chapter->chapter_image}}" target="_blank"><img src="{{ asset($course_chapter->chapter_image) }}" style="width:300px; height:auto" /></a>
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
                                @if (isset($course_chapter->chapter_short_description))
                                    <div class="container-fluid" style="border: 2px solid #d2d6de; min-height: 180px">
                                        {!! $course_chapter->chapter_short_description !!}
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
                                <label class="control-label">Course Chapter Description: </label>
                                @if (isset($course_chapter->chapter_description))
                                    <div class="container-fluid" style="border: 2px solid #d2d6de; min-height: 200px">
                                        {!! $course_chapter->chapter_description !!}
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
