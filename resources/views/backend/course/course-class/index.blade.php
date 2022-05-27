@extends('backend.layouts.master')
@section('title')
    Course Lesson
@endsection
@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-laptop"></i>
        Course Lesson
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
                    <h3 class="box-title">Find Course Lesson</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'course-classes.pdf',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id'),
                                    'course_id'=>$request->get('course_id'),
                                    'chapter_id'=>$request->get('chapter_id'),
                                    'class_name'=>$request->get('class_name'),
                                    'class_status'=>$request->get('class_status'),
                                    'class_featured'=>$request->get('class_featured'),
                                    'created_at'=>$request->get('created_at'),
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'course-classes.excel',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id'),
                                    'course_id'=>$request->get('course_id'),
                                    'chapter_id'=>$request->get('chapter_id'),
                                    'class_name'=>$request->get('class_name'),
                                    'class_status'=>$request->get('class_status'),
                                    'class_featured'=>$request->get('class_featured'),
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
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('course-classes.index') }}">
                        <div class="row">
                            <div class=" @role(\Utility::SUPER_ADMIN)col-md-6 @else col-md-12 @endrole">
                                <div class="form-group">
                                    <label for="search_text" class="control-label">Search:</label>
                                    <input type="text" class="form-control" id="search_text" name="search_text"
                                           value="{{ $request->search_text }}" placeholder="Search Text">
                                </div>
                            </div>
                            @role(\Utility::SUPER_ADMIN)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="control-label">Company:</label>
                                    <select name="company_id" id="company_id" class="form-control">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}"
                                                    @if(old('company_id', isset($request) ? $request->company_id:null) == $company->id) selected @endif
                                            >{{ $company->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endrole
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="class_name" class="control-label">Course Name:</label>
                                    <input type="text" class="form-control" id="class_name" name="class_name"
                                           value="{{ $request->class_name }}" placeholder="Lesson Name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="control-label">Status:</label>
                                    <select name="class_status" id="class_status" class="form-control">
                                        <option value="">Select Status</option>
                                        @foreach(\App\Support\Configs\Constants::$class_status as $status)
                                            <option value="{{ $status }}"
                                                    @if(old('class_status', isset($request) ? $request->class_status:null) == $status) selected @endif
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
                        $caption="Course Lessons",
                        $captionIcon="icon-users",
                        $routeName="course-classes",
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
                                <th>#</th>
                                @role(\Utility::SUPER_ADMIN)
                                <th> Company</th>
                                @endrole
                                <th> @sortablelink('class_name', 'Lesson Name')</th>
                                <th> Class</th>
                                <th> Course</th>
{{--                                <th> Type</th>--}}
                                <th> Status</th>
                                <th> @sortablelink('created_at', 'Created Date')</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($course_classes as $index => $course_class)

                                <tr class="odd gradeX">
                                    <td>{{ $index+1 }}</td>
                                    @role(\Utility::SUPER_ADMIN)
                                    <td style="color: #0f13d3">{{isset($course_class->company)?strtoupper($course_class->company->company_name):null}}</td>
                                    @endrole
                                    <td>{{isset($course_class->class_name)?strtoupper($course_class->class_name):null}}</td>
                                    <td style="color: #76767f">{{isset($course_class->courseChapter)?$course_class->courseChapter->chapter_title : 'N/A'}}</td>
                                    <td style="color: #76767f">{{isset($course_class->course)?$course_class->course->course_title:null}}</td>

{{--                                    <td>
                                        {!! CHTML::flagChangeButton($course_class, 'class_type',
    ['on' => 'Online', 'off' => 'Offline'], null, ['on' => 'primary', 'off' => 'warning']) !!}
                                    </td>--}}
                                    <td>
                                        {!! CHTML::flagChangeButton($course_class,
                                                'class_status',
                                            ['on' => 'ACTIVE', 'off' => 'INACTIVE']) !!}

                                    </td>
                                    <td> {{isset($course_class->created_at)?$course_class->created_at->format('d M, Y'):null}}</td>
                                    <td class="tbl-action">
                                        {!!
                                            CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $course_class->id,
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
                {!! CHTML::customPaginate($course_classes,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection

@push('scripts')

@endpush


