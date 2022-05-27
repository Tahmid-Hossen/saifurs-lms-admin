@extends('backend.layouts.master')
@section('title')
    Quiz List
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-file-text-o" aria-hidden="true"></i>
        Quiz
        <small>Control panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <div class="row">
        @include('backend.layouts.flash')
        <div class="col-xs-12">
            <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Find Quiz</h3>
                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint" href="{!! route('quizzes.pdf', [
    'quiz_id' => $request->get('quiz_id'),
    'quiz_full_marks' => $request->get('quiz_full_marks'),
    'quiz_topic' => $request->get('quiz_topic'),
    'quiz_url' => $request->get('quiz_url'),
    'quiz_type' => $request->get('quiz_type'),
    'course_id' => $request->get('course_id'),
    'quiz_status' => $request->get('quiz_status'),
]) !!}">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint" href="{!! route('quizzes.excel', [
    'quiz_id' => $request->get('quiz_id'),
    'quiz_full_marks' => $request->get('quiz_full_marks'),
    'quiz_topic' => $request->get('quiz_topic'),
    'quiz_url' => $request->get('quiz_url'),
    'quiz_type' => $request->get('quiz_type'),
    'course_id' => $request->get('course_id'),
    'quiz_status' => $request->get('quiz_status'),
]) !!}">
                            <i class="fa fa-file-excel-o"></i> Excel
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('quizzes.index') }}">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="quiz_id" class="control-label">Quiz ID</label>
                                    <input type="text" class="form-control" id="quiz_id" name="quiz_id"
                                        value="{{ $request->quiz_id }}" placeholder="Insert an ID">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="quiz_full_marks" class="control-label">Quiz Full Marks</label>
                                    <input type="text" class="form-control" id="quiz_full_marks" name="quiz_full_marks"
                                        value="{{ $request->quiz_full_marks }}" placeholder="Insert Quiz Mark">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quiz_topic" class="control-label">Quiz Topic</label>
                                    <input type="text" class="form-control" id="quiz_topic" name="quiz_topic"
                                        value="{{ $request->quiz_topic }}" placeholder="Insert a Quiz Topic">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quiz_url" class="control-label">Quiz Question URL</label>
                                    <input type="text" class="form-control" id="quiz_url" name="quiz_url"
                                        value="{{ $request->quiz_url }}" placeholder="Paste The Quiz Question URL">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quiz_type" class="control-label">Quiz Type</label>
                                    <select name="quiz_type" id="quiz_type" class="form-control">
                                        <option value="">Click to select types</option>
                                        @foreach (\App\Services\UtilityService::$quizType as $key => $type)
                                            <option value="{{ $type }}" @if (old('quiz_type', $request->quiz_type ?? null) == $type) selected @endif>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quiz_status" class="control-label">Course Title</label>
                                    <select name="course_id" id="course_id" class="form-control">
                                        <option value="" @if (isset($request) && $request->course_id == '') selected @endif>
                                            -------- No Course Selected --------
                                        </option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}" @if (isset($request) && $request->course_id == $course->id) selected @endif>
                                                {{ $course->course_title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quiz_status" class="control-label">Quiz Status</label>
                                    <select name="quiz_status" id="quiz_status" class="form-control">
                                        <option value="" @if (old('quiz_status', isset($request) ? $request->quiz_status : null) == $request->quiz_status) selected @endif>-------- No Status Selected --------
                                        </option>
                                        @foreach (\App\Services\UtilityService::$statusText as $status)
                                            <option value="{{ $status }}" @if (old('event_status', isset($request) ? $request->quiz_status : null) == $status) selected @endif>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block"> <i
                                            class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="box">
                {!! CHTML::formTitleBox($caption = 'List of All Quiz', $captionIcon = 'null', $routeName = 'quizzes', $buttonClass = '', $buttonIcon = '') !!}

                <div class="box-body table-responsive">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1"
                        width="100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>ID | Quiz Topic</th>
                                <th>Quiz Type</th>
                                {{-- <th>Quiz Description</th> --}}
{{--                                <th>Quiz Question URL (GOOGLE DOCS)</th>--}}
                                <th class="text-center">Full Mark
                                    {{-- <br>
                                     <sup class="text-success">Pass Mark</sup> --}}
                                </th>
                                <th>Course Title</th>
{{--                                <th class="text-center">Re-Attempt</th>--}}
                                <th>Status</th>
                                <th class="tbl-action">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $data)
                                <tr class="odd gradeX">
                                    <td>{{ $datas->firstItem() + $loop->index }}</td>
                                    <td>
                                        {{ $data->id }} | <a
                                            href="{{ route('quizzes.show', $data->id) }}">{{ $data->quiz_topic }}</a>
                                    </td>
                                    <td>{{ $data->quiz_type }}</td>
                                    {{-- <td>{{ $data->quiz_description }}</td> --}}
{{--                                    <td>
                                        <a href="{{ $data->quiz_url }}">{{ $data->quiz_url }}</a>
                                    </td>--}}
                                    <td class="text-center">
                                        {{ $data->quiz_full_marks }}
                                        {{-- <br> --}}
                                        {{-- <sup class="text-success">
                                            {{ round(($data->quiz_pass_percentage / 100) * $data->quiz_full_marks, 2) }}
                                        </sup> --}}
                                    </td>
                                    <td>{{ $data->course_title }}</td>
                                    {{--<td class="text-center">
                                        {!! \CHTML::flagChangeButton($data, 'quiz_re_attempt', \Utility::$approvedStatus, null, ['on'=>'info', 'off'=>'danger']) !!}
                                    </td>--}}
                                    <td>
                                        {!! \CHTML::flagChangeButton($data, 'quiz_status', \Utility::$statusText) !!}
                                    </td>
                                    <td>
                                        {!! CHTML::actionButton($reportTitle = '..', $routeLink = '#', $data->id, $selectButton = ['showButton','editButton', 'deleteButton'], $class = 'btn-icon btn-circle', $onlyIcon = 'yes', $othersPram = []) !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! CHTML::customPaginate($datas, '') !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection
