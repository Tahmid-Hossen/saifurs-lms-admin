@extends('backend.layouts.master')
@section('title')
    Question
@endsection
@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-question-circle"></i>
        Question
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
                    <h3 class="box-title">Find Question</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'questions.pdf',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id'),
                                    'course_id'=>$request->get('course_id'),
                                    'question'=>$request->get('question'),
                                    'question_status'=>$request->get('question_status'),
                                    'created_at'=>$request->get('created_at'),
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'questions.excel',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id'),
                                    'course_id'=>$request->get('course_id'),
                                    'question'=>$request->get('question'),
                                    'question_status'=>$request->get('question_status'),
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
                          action="{{ route('questions.index') }}">
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
                                    <select name="question_status" id="question_status" class="form-control">
                                        <option value="">Select Status</option>
                                        @foreach(\App\Support\Configs\Constants::$question_status as $status)
                                            <option value="{{ $status }}"
                                                    @if(old('question_status', isset($request) ? $request->question_status:null) == $status) selected @endif
                                            >{{ str_replace("-","",$status) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="form-group">
                                <button type="reset" class="btn btn-danger text-bold" style="margin-right: 1rem"><i
                                        class="fa fa-eraser"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary text-bold"><i
                                        class="fa fa-search"></i> Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <div class="box">
                {!!
                    CHTML::formTitleBox(
                        $caption="Questions",
                        $captionIcon="icon-users",
                        $routeName="questions",
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
                                <th>SI</th>
                                <th> @sortablelink('question', 'Question')</th>
                                @role(\Utility::SUPER_ADMIN)
                                <th> Company</th>
                                @endrole
                                <th> Quiz</th>
                                <th> Status</th>
                                <th> @sortablelink('created_at', 'Created Date')</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($course_questions as $course_question)

                                <tr class="odd gradeX">
                                    <td>{{$course_question->id}}</td>
                                    <td>{{$course_question->question}}</td>
                                    @role(\Utility::SUPER_ADMIN)
                                    <td style="color: #0f13d3">{{isset($course_question->company)?strtoupper($course_question->company->company_name):null}}</td>
                                    @endrole
                                    <td>{{$course_question->quiz_topic}}</td>
                                    <td>
                                        {!! CHTML::flagChangeButton($course_question,
                                                'question_status',
                                            ['on' => 'ACTIVE', 'off' => 'INACTIVE']) !!}

                                    </td>
                                    <td>{{isset($course_question->created_at)?$course_question->created_at->format('d M, Y'):null}}</td>
                                    <td class="tbl-action">
                                        {!!
                                            CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $course_question->id,
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
                {!! CHTML::customPaginate($course_questions,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection
@push('scripts')

@endpush


