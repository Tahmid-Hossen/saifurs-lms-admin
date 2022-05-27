@extends('backend.layouts.master')
@section('title')
    Syllabus
@endsection

@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-th-list"></i>
        Syllabus
        <small>Control panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <div class="page-content-wrapper">
        <div class="row">
            @include('backend.layouts.flash')
            <div class="col-xs-12">
                <div class="box box-default collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Find Syllabus</h3>

                        <div class="box-tools pull-right">
                            <a class="btn btn-primary hidden-print" id="payeePrint"
                               href="{!! route(
                                'course-syllabuses.pdf',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'course_id'=>$request->get('course_id'),
                                    'syllabus_title'=>$request->get('syllabus_title'),
                                    'syllabus_status'=>$request->get('syllabus_status'),
                                    'created_at'=>$request->get('created_at'),
                                ]
                           ) !!}"
                            >
                                <i class="fa fa-file-pdf-o"></i> PDF
                            </a>
                            <a class="btn btn-primary hidden-print" id="payeePrint"
                               href="{!! route(
                                'course-syllabuses.excel',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'course_id'=>$request->get('course_id'),
                                    'syllabus_title'=>$request->get('syllabus_title'),
                                    'syllabus_status'=>$request->get('syllabus_status'),
                                    'created_at'=>$request->get('created_at'),
                                ]
                           ) !!}"
                            >
                                <i class="fa fa-file-excel-o"></i> Excel
                            </a>
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form class="horizontal-form" role="form" method="GET"
                              action="{{ route('course-syllabuses.index') }}">
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
                                        <label for="name" class="control-label">Course:</label>
                                        <select name="course_id" id="course_id" class="form-control">
                                            <option value="">Select Course</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}"
                                                        @if(old('course_id', isset($request) ? $request->course_id:null) == $course->id) selected @endif
                                                >{{ $course->course_title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name" class="control-label">Status:</label>
                                        <select name="syllabus_status" id="syllabus_status" class="form-control">
                                            <option value="">Select Status</option>
                                            @foreach(\App\Support\Configs\Constants::$question_status as $status)
                                                <option value="{{ $status }}"
                                                        @if(old('syllabus_status', isset($request) ? $request->syllabus_status:null) == $status) selected @endif
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
                            $caption="Syllabuses",
                            $captionIcon="icon-users",
                            $routeName="course-syllabuses",
                            $buttonClass="",
                            $buttonIcon=""
                        )
                    !!}
                    <div class="box-body table-responsive no-padding">
                        <div class="table-responsive">
                            <table
                                class="table table-striped table-bordered table-hover table-checkable order-column"
                                id="sample_1">
                                <thead>
                                <tr>
                                    <th>SI</th>
                                    <th> @sortablelink('syllabus_title', 'Title')</th>
                                    @role(\Utility::SUPER_ADMIN)
                                    <th> Company</th>
                                    @endrole
                                    <th> Course</th>
                                    <th> Status</th>
                                    <th> @sortablelink('created_at', 'Created Date')</th>
                                    <th class="tbl-action"> Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($course_syllabuses as $course_syllabus)

                                    <tr class="odd gradeX">
                                        <td>{{ $course_syllabuses->firstItem() + $loop->index }}</td>
                                        <td>{{isset($course_syllabus->syllabus_title)?strtoupper($course_syllabus->syllabus_title):null}}</td>
                                        @role(\Utility::SUPER_ADMIN)
                                        <td style="color: #76767f">{{isset($course_syllabus->company)?$course_syllabus->company->company_name:null}}</td>
                                        @endrole

                                        <td style="color: #76767f">{{isset($course_syllabus->course)?$course_syllabus->course->course_title:null}}</td>
                                        <td>
                                            {!! CHTML::flagChangeButton($course_syllabus,
                                                    'syllabus_status',
                                                ['on' => 'ACTIVE', 'off' => 'INACTIVE']) !!}

                                        </td>
                                        <td> {{isset($course_syllabus->created_at)?$course_syllabus->created_at->format('d M, Y'):null}}</td>

                                        <td class="tbl-action">
                                            {!!
                                                CHTML::actionButton(
                                                    $reportTitle='..',
                                                    $routeLink='#',
                                                    $course_syllabus->id,
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
                    {!! CHTML::customPaginate($course_syllabuses,'') !!}
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@push('scripts')

@endpush


