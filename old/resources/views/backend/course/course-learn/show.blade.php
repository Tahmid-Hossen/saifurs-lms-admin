@extends('backend.layouts.master')

@section('content')
@section('content-header')
    <h1>
        <i class="fa fa-leanpub"></i>
        Course Learn
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
                <h3 class="box-title">Course Learn</h3>
                <div class="pull-right">
                    <a
                        href="{{route('course-learns.index')}}"
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
                                style="color: rgb(115, 93, 238)">{{$course_learn->learn_title}}</h3>
                        </div>

                    </div>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
{{--                                    <tr>
                                        <th>Company: </th>
                                        <th style="color: #76767f">{{isset($course_learn->company)?$course_learn->company->company_name:null}}</th>
                                    </tr>--}}
                                    <tr>
                                        <th>Course: </th>
                                        <th style="color: #76767f">{{isset($course_learn->course)?$course_learn->course->course_title:null}}</th>
                                    </tr>
                                    <tr>
                                        <th>Status: </th>
                                        <th>
                                            @if($course_learn->learn_status == 'ACTIVE')
                                                <button class="btn btn-success btn-sm">{{$course_learn->learn_status}}</button>
                                            @else
                                                <button class="btn btn-danger btn-sm">{{ str_replace("-","",$course_learn->learn_status) }}</button>
                                            @endif
                                        </th>
                                    </tr>
                                    <!-- <tr>
                                        <th>Featured: </th>
                                        <th>
                                            @if($course_learn->learn_featured == 'NO')
                                                    <button class="btn btn-danger btn-sm">{{$course_learn->learn_featured}}</button>
                                            @else
                                                    <button class="btn btn-info btn-sm">{{$course_learn->learn_featured}}</button>
                                            @endif
                                        </th>
                                    </tr> -->

                                    <tr>
                                        <th>Created By: </th>
                                        <th>{{ isset($course_learn->createdBy)?$course_learn->createdBy->name:null }}</th>
                                    </tr>
                                    <tr>
                                        <th>Created Date: </th>
                                        <th>{{ isset($course_learn->created_at)?$course_learn->created_at->format('d M, Y'):null }}</th>
                                    </tr>

                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Description: </label>
                                    @if (isset($course_learn->learn_details))
                                        <div class="container-fluid" style="border: 2px solid #d2d6de; min-height: 200px">
                                            {!! $course_learn->learn_details !!}
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
