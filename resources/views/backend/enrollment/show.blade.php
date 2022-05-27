@extends('backend.layouts.master')

@section('content')
@section('content-header')
    <h1>
        <i class="fa fa-first-order" aria-hidden="true"></i>
        Enrollment
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
                <h3 class="box-title">Enrollment</h3>
                <div class="pull-right">
                    <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{{ route(
                                'enrollments.print', $enrollment->id
                           ) }}"
                        >
                        <i class="fa fa-print" aria-hidden="true"></i> PRINT
                    </a>
                    <a
                            href="{{route('enrollments.index')}}"
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
                                <h3 class="font-green sbold uppercase" style="color: rgb(115, 93, 238)">{{$enrollment->enrollment_title}}</h3>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Company: </th>
                                        <th style="color: #76767f">
                                            @if(isset($enrollment->company->company_name))
                                                {{ strtoupper($enrollment->company->company_name) }}
                                            @else
                                                N/A
                                            @endif
                                        </th>
                                    </tr>
{{--                                    <tr>--}}
{{--                                        <th>Class: </th>--}}
{{--                                        <th style="color: #76767f">--}}
{{--                                        @if($enrollment->courseClass->class_name)--}}
{{--                                            {{ strtoupper($enrollment->courseClass->class_name) }}--}}
{{--                                        @else --}}
{{--                                            N/A--}}
{{--                                        @endif--}}
{{--                                        </th>--}}
{{--                                    </tr>--}}
                                    <tr>
                                        <th>Course: </th>
                                        <th style="color: #76767f">
                                            @if(isset($enrollment->course->course_title))
                                                {{ strtoupper($enrollment->course->course_title) }}
                                            @else
                                                N/A
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Course Batch: </th>
                                        <th style="color: #76767f">
                                            @if(isset($enrollment->courseBatch->course_batch_name))
                                                {{ strtoupper($enrollment->courseBatch->course_batch_name) }}
                                            @else
                                                N/A
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Status: </th>
                                        <th>
                                            @if($enrollment->enroll_status == 'IN-ACTIVE')
                                                    <button class="btn btn-danger btn-sm">{{ str_replace("-","",$enrollment->enroll_status) }}</button>
                                            @else
                                                    <button class="btn btn-success btn-sm">{{$enrollment->enroll_status}}</button>
                                            @endif
                                        </th>
                                    </tr>

                                    <tr>
                                        <th>Created By: </th>
                                        <th>{{ isset($enrollment->createdBy)?$enrollment->createdBy->name:null }}</th>
                                    </tr>
                                    <tr>
                                        <th>Created Date: </th>
                                        <td>
                                        {{ isset($enrollment->created_at)?$enrollment->created_at->format('d M, Y'):null }}
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
                                                @if(isset($enrollment->user->name))
                                                    {{ strtoupper($enrollment->user->name) }}
                                                @else
                                                    N/A
                                                @endif
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>User Email: </th>
                                            <th style="color: #76767f">
                                                @if(isset($enrollment->user->email))
                                                    {{ strtoupper($enrollment->user->email) }}
                                                @else
                                                    N/A
                                                @endif
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>User Mobile: </th>
                                            <th style="color: #76767f">
                                                @if(isset($enrollment->user->mobile_number))
                                                    {{ strtoupper($enrollment->user->mobile_number) }}
                                                @else
                                                    N/A
                                                @endif
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
