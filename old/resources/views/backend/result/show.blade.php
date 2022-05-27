@extends('backend.layouts.master')

@section('content')
@section('content-header')
    <h1>
        <i class="fa fa-star" aria-hidden="true"></i>
        Result
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
                <h3 class="box-title">Result</h3>
                <div class="pull-right">
                    <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{{ route(
                                'results.print', $result->id
                           ) }}"
                        >
                        <i class="fa fa-print" aria-hidden="true"></i> PRINT
                    </a>
                    <a
                            href="{{route('results.index')}}"
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
                                <h3 class="font-green sbold uppercase" style="color: rgb(115, 93, 238)">{{$result->result_title}}</h3>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Company: </th>
                                        <th style="color: #76767f">
                                        {{ isset($result->company)?$result->company->company_name:null }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Class: </th>
                                        <th style="color: #76767f">
                                        {{ isset($result->courseClass)?$result->courseClass->class_name:null }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Course: </th>
                                        <th style="color: #76767f">
                                        {{ isset($result->course)?$result->course->course_title:null }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Course Batch: </th>
                                        <th style="color: #76767f">
                                        {{ isset($result->courseBatch)?$result->courseBatch->course_batch_name:null }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Quiz: </th>
                                        <th style="color: #76767f">
                                        {{ isset($result->quiz)?$result->quiz->quiz_topic:null }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Quiz Type: </th>
                                        <th style="color: #76767f">
                                        {{ isset($result->quiz)?$result->quiz->quiz_type:null }}
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Quiz URL: </th>
                                        <th style="color: #76767f">
                                            @if ($result->quiz)
                                                <a href="{{$result->quiz->quiz_url}}">{{ strtoupper($result->quiz->quiz_url) }}</a>
                                            @else
                                                N/A
                                            @endif


                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Result Title: </th>
                                        <th style="color: #76767f">
                                        @if($result->result_title)
                                            {{ $result->result_title }}
                                        @else
                                            N/A
                                        @endif
                                        </th>
                                    <!-- </tr>
                                    <tr>
                                        <th>Result Slug: </th>
                                        <th style="color: #76767f">
                                        @if($result->result_slug)
                                            {{ $result->result_slug }}
                                        @else
                                            N/A
                                        @endif
                                        </th>
                                    </tr> -->
                                    <tr>
                                        <th>Score: </th>
                                        <th style="color: #76767f">
                                        @if($result->total_score)
                                            {{ strtoupper($result->total_score) }}
                                        @else
                                            N/A
                                        @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Pass Mark: </th>
                                        <th style="color: #76767f">
                                        @if($result->pass_score)
                                            {{ strtoupper($result->pass_score) }}
                                        @else
                                            N/A
                                        @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Status: </th>
                                        <th>
                                            @if($result->result_status == 'ACTIVE')
                                                    <button class="btn btn-success btn-sm">{{ $result->result_status }}</button>
                                            @else
                                                    <button class="btn btn-danger btn-sm">{{str_replace("-","",$result->result_status)}}</button>
                                            @endif
                                        </th>
                                    </tr>

                                    <tr>
                                        <th>Created By: </th>
                                        <th>{{ isset($result->createdBy)?$result->createdBy->name:null }}</th>
                                    </tr>
                                    <tr>
                                        <th>Created Date: </th>
                                        <td>
                                        {{ isset($result->created_at)?$result->created_at->format('d M, Y'):null }}
                                        </td>
                                    </tr>

                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                          <th colspan="2">USER DETAILS </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <tr>
                                            <th colspan="2" class="table-info">USER DETAILS </th>
                                        </tr> --}}
                                        <tr>
                                            <th>User Name: </th>
                                            <th style="color: #76767f">
                                            {{ isset($result->user)?$result->user->name:null }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>User Email: </th>
                                            <th style="color: #76767f">
                                            {{ isset($result->user)?$result->user->email:null }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>User Mobile: </th>
                                            <th style="color: #76767f">
                                            {{ isset($result->user)?$result->user->mobile_number:null }}
                                            </th>
                                        </tr>
                                    </tbody>
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
