@extends('backend.layouts.master')

@section('content')
@section('content-header')
    <h1>
        <i class="fa fa-question-circle"></i>
        Question
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
                <h3 class="box-title">Question</h3>
                <div class="pull-right">
                    <a
                        href="{{route('course-questions.index')}}"
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
                                style="color: rgb(115, 93, 238)">{{$course_question->question}}</h3>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Company:</th>
                                    <th style="color: #00a65a">{{ isset($course_question->company)?strtoupper($course_question->company->company_name):null }}</th>
                                </tr>
                                <tr>
                                    <th>Branch:</th>
                                    <th style="color: #22dd89">{{ isset($course_question->branch)?strtoupper($course_question->branch->branch_name):null }}</th>
                                </tr>
                                {{--<tr>
                                    <th>Course Category:</th>
                                    <th style="color: #76767f">{{ isset($course_question->courseCategory)?strtoupper($course_question->courseCategory->course_category_title):null }}</th>
                                </tr>
                                <tr>
                                    <th>Course Sub Category:</th>
                                    <th style="color: #76767f">{{ isset($course_question->courseSubCategory)?strtoupper($course_question->courseSubCategory->course_sub_category_title):null }}</th>
                                </tr>
                                <tr>
                                    <th>Course Child Category:</th>
                                    <th style="color: #76767f">{{ isset($course_question->courseChildCategory)?strtoupper($course_question->courseChildCategory->course_child_category_title):null }}</th>
                                </tr>--}}
                                <tr>
                                    <th>Course:</th>
                                    <th style="color: #76767f">{{ isset($course_question->course)?strtoupper($course_question->course->course_title):null }}</th>
                                </tr>
                                <tr>
                                    <th>Class:</th>
                                    <th style="color: #76767f">{{ isset($course_question->courseClass)?strtoupper($course_question->courseClass->class_name):null }}</th>
                                </tr>
                                <tr>
                                    <th>Chapter:</th>
                                    <th style="color: #76767f">{{ isset($course_question->courseChapter)?strtoupper($course_question->courseChapter->chapter_title):null }}</th>
                                </tr>
                                {{-- <tr>
                                    <th>Class Type: </th>
                                    <th>
                                        @if($course_class->class_type == \App\Support\Configs\Constants::$class_types[0])
                                            <p style="font-weight:600; color: rgb(13, 138, 40)">{{ strtoupper($course_class->class_type)}}</p>
                                        @else
                                            <p style="font-weight:600; color: rgb(219, 16, 16)">{{ strtoupper($course_class->class_type)}}</p>
                                        @endif
                                    </th>
                                </tr> --}}
                                <tr>
                                    <th>Status:</th>
                                    <th>
                                        @if($course_question->question_status == 'IN-ACTIVE')
                                            <button
                                                class="btn btn-danger btn-sm">{{ str_replace("-","",$course_question->question_status) }}</button>
                                        @else
                                            <button
                                                class="btn btn-success btn-sm">{{$course_question->question_status}}</button>
                                        @endif
                                    </th>
                                </tr>
{{--
                                <tr>
                                    <th>Featured:</th>
                                    <th>
                                        @if($course_question->question_featured == 'NO')
                                            <button
                                                class="btn btn-danger btn-sm">{{$course_question->question_featured}}</button>
                                        @else
                                            <button
                                                class="btn btn-info btn-sm">{{$course_question->question_featured}}</button>
                                        @endif
                                    </th>
                                </tr>
--}}

                                <tr>
                                    <th>Created By:</th>
                                    <th>{{ isset($course_question->createdBy)?$course_question->createdBy->name:null }}</th>
                                </tr>
                                <tr>
                                    <th>Created Date:</th>
                                    <td>{{ $course_question->created_at->format('d M, Y') ?? $course_question->created_at }}</td>
                                </tr>
                                {{--<tr>
                                    <th>Position:</th>
                                    <td>{{ $course_question->question_position }}</td>
                                </tr>--}}

                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Image:</th>
                                    <td>
                                        @if (isset($course_question->question_image))
                                            <img src="{{ asset($course_question->question_image) }}"
                                                 style="width:200px; height:auto"/>
                                        @else
                                            <p>N/A</p>
                                        @endif
                                    </td>
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
