@extends('backend.layouts.master')
@section('title')
    Answer
@endsection
@section('page_styles')

@endsection
@section('content-header')
    <h1>
        <i class="fa fa-reply-all"></i>
        Answer
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
                    <h3 class="box-title">Find Answer</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'question-answers.pdf',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'question_id'=>$request->get('question_id'),
                                    'answer'=>$request->get('answer'),
                                    'answer_status'=>$request->get('answer_status'),
                                    'created_at'=>$request->get('created_at'),
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'question-answers.excel',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'question_id'=>$request->get('question_id'),
                                    'answer'=>$request->get('answer'),
                                    'answer_status'=>$request->get('answer_status'),
                                    'created_at'=>$request->get('created_at'),
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-excel-o"></i> Excel
                        </a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET"
                          action="{{ route('question-answers.index') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search_text" class="control-label">Search:</label>
                                    <input type="text" class="form-control" id="search_text" name="search_text"
                                           value="{{ $request->search_text }}" placeholder="Search Text">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">Status:</label>
                                    <select name="answer_status" id="answer_status" class="form-control">
                                        <option value="">Select Status</option>
                                        @foreach(\App\Support\Configs\Constants::$answer_status as $status)
                                            <option value="{{ $status }}"
                                                    @if(old('answer_status', isset($request) ? $request->answer_status:null) == $status) selected @endif
                                            >{{ str_replace("-","",$status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block"><i
                                            class="fa fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <div class="box">
                {!!
                    CHTML::formTitleBox(
                        $caption="Answers",
                        $captionIcon="icon-users",
                        $routeName="question-answers",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}
                <div class="box-body table-responsive no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="sample_1">
                            <thead>
                            <tr>
                                <!-- <th> Company</th> -->
                                <th> Course</th>
                                <th> @sortablelink('courseQuestion', 'Question')</th>
{{--
                                <th> Answer</th>
--}}
                                <th> Status</th>
                               <th> @sortablelink('created_at', 'Created Date')</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($question_answers as $question_answer)

                                <tr class="odd gradeX">
{{--                                    <!-- <td style="color: #0f13d3">{{isset($question_answer->company)?strtoupper($question_answer->company->company_name):null}}</td> -->--}}
                                    <td style="color: #0f13d3">{{isset($question_answer->course)?strtoupper($question_answer->course->course_title):null}}</td>
                                    <td style="color: #0f13d3">{{isset($question_answer->courseQuestion)?strtoupper($question_answer->courseQuestion->question):null}}</td>
                    {{--                <td style="color: #76767f">
                                        {{isset($question_answer->answer)?strtoupper($question_answer->answer):null}}
                                    </td>--}}

                                    <td>
                                        {!! CHTML::flagChangeButton($question_answer,
                                                'answer_status',
                                            ['on' => 'ACTIVE', 'off' => 'INACTIVE']) !!}

                                    </td>
                                    <td> {{isset($question_answer->created_at)?$question_answer->created_at->format('d M, Y'):null}}</td>
                                   <td class="tbl-action">
                                        {!!
                                            CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $question_answer->id,
                                                $selectButton=['showButton','editButton','deleteButton'],
                                                $class = ' btn-icon btn-circle ',
                                                $onlyIcon='yes',
                                                $othersPram=array()
                                            )
                                        !!}

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
                {!! CHTML::customPaginate($question_answers,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection
@push('scripts')

@endpush


