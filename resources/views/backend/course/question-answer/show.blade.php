@extends('backend.layouts.master')

@section('content')
@section('content-header')
    <h1>
        <i class="fa fa-reply-all"></i>
        Answer
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
                <h3 class="box-title">Answer</h3>
                <div class="pull-right">
                    <a
                        href="{{route('question-answers.index')}}"
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
                            <h3 class="font-green sbold uppercase" style="color: rgb(115, 93, 238)">
                                #00{{$question_answer->id}}</h3>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Question:</th>
                                    <th style="color: #00a65a">{{ isset($question_answer->courseQuestion)?strtoupper($question_answer->courseQuestion->question):null }}</th>
                                </tr>
                                <tr>
                                    <th>Answer:</th>
                                    <th style="color: #76767f">{{ strtoupper($question_answer->answer) }}</th>
                                </tr>

                                <tr>
                                    <th>Status:</th>
                                    <th>
                                        @if($question_answer->answer_status == 'IN-ACTIVE')
                                            <button
                                                class="btn btn-danger btn-sm">{{ str_replace("-","",$question_answer->answer_status) }}</button>
                                        @else
                                            <button
                                                class="btn btn-success btn-sm">{{$question_answer->answer_status}}</button>
                                        @endif
                                    </th>
                                </tr>
                                {{--<tr>
                                    <th>Featured:</th>
                                    <th>
                                        @if($question_answer->answer_featured == 'NO')
                                            <button
                                                class="btn btn-danger btn-sm">{{$question_answer->answer_featured}}</button>
                                        @else
                                            <button
                                                class="btn btn-info btn-sm">{{$question_answer->answer_featured}}</button>
                                        @endif
                                    </th>
                                </tr>--}}

                                <tr>
                                    <th>Created By:</th>
                                    <th>{{ isset($question_answer->createdBy)?$question_answer->createdBy->name:null }}</th>
                                </tr>
                                <tr>
                                    <th>Created Date:</th>
                                    <td>{{ $question_answer->created_at->format('d M, Y') }}</td>
                                </tr>
                                {{--<tr>
                                    <th>Position:</th>
                                    <td>{{ $question_answer->answer_position }}</td>
                                </tr>--}}

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
