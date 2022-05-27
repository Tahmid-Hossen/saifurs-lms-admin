@extends('backend.layouts.master')
@section('title')
    Enrollment
@endsection
@section('page_styles')

@endsection

@section('content-header')
    <h1>
        <i class="fa fa-first-order" aria-hidden="true"></i>
        Enrollment
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
                    <h3 class="box-title">Find Enrollment</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'enrollments.pdf',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id'),
                                    'batch_id'=>$request->get('batch_id'),
                                    'class_id'=>$request->get('class_id'),
                                    'course_id'=>$request->get('course_id'),
                                    'user_id'=>$request->get('user_id'),
                                    'enroll_status'=>$request->get('enroll_status'),
                                    'created_at'=>$request->get('created_at'),
                                ]
                           ) !!}"
                        >
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint"
                           href="{!! route(
                                'enrollments.excel',
                                [
                                    'search_text'=>$request->get('search_text'),
                                    'company_id'=>$request->get('company_id'),
                                    'batch_id'=>$request->get('batch_id'),
                                    'class_id'=>$request->get('class_id'),
                                    'course_id'=>$request->get('course_id'),
                                    'user_id'=>$request->get('user_id'),
                                    'enroll_status'=>$request->get('enroll_status'),
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
                    <form class="horizontal-form" role="form" method="GET" action="{{ route('enrollments.index') }}">
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
                                    <label for="name" class="control-label">Company:</label>
                                    <select name="company_id" id="company_id" class="form-control auto_search">
                                        <option value="">Select Company</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}"
                                                    @if(old('company_id', isset($request) ? $request->company_id:null) == $company->id) selected @endif
                                            >{{ $company->company_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">Course:</label>
                                    <select name="course_id" id="course_id" class="form-control auto_search">
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
                                    <label for="class_id" class="control-label">Batch:</label>
                                    <select name="batch_id" id="batch_id" class="form-control auto_search">
                                        <option value="">Select Batch</option>
                                        @foreach($course_batches as $course_batch)
                                            <option value="{{ $course_batch->id }}"
                                                    @if(old('batch_id', isset($request) ? $request->batch_id:null) == $course_batch->id) selected @endif
                                            >{{ $course_batch->course_batch_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- <div class="col-md-4">
                                <div class="form-group">
                                    <label for="user_id" class="control-label">Student/User:</label>
                                    <select name="user_id" id="user_id" class="form-control auto_search">
                                        <option value="">Select User</option>
                                        @foreach($course_classes as $course_class)
                                            <option value="{{ $course_class->id }}"
                                                    @if(old('user_id', isset($request) ? $request->user_id:null) == $course_class->id) selected @endif
                                            >{{ $course_class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">Status:</label>
                                    <select name="enroll_status" id="enroll_status" class="form-control">
                                        <option value="">Select Status</option>
                                        @foreach(\App\Support\Configs\Constants::$question_status as $status)
                                            <option value="{{ $status }}"
                                                    @if(old('enroll_status', isset($request) ? $request->enroll_status:null) == $status) selected @endif
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
            <div class="box with-border box-primary">
                <div class="box-header">
                    <i class="fa fa-first-order font-dark"></i>
                    <h3 class="box-title">Enrollments</h3>
                    <div class="box-tools">
                        <div class="input-group input-group-sm">
                            <a href="{{ route('students.create') }}" class="btn mx-2 btn-success">
                                Register Student <i class="fa fa-user-plus"></i>
                            </a>
                            <a href="{{ route('enrollments.create') }}" class="btn  mx-2 btn-primary">
                                Add New <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="sample_1">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th> Company</th>
                                <th> Course</th>
                                <th> Batch</th>
                                <th> User</th>
                                <th> Status</th>
                               <th class="tbl-date"> @sortablelink('created_at', 'Created At')</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($enrollments as $index => $enrollment)

                                <tr class="odd gradeX">
                                    <td>{{ $index+1 }}</td>
                                    <td>{{isset($enrollment->company)?$enrollment->company->company_name:null}}</td>
                                    <td>{{isset($enrollment->course)?$enrollment->course->course_title:null}}</td>
                                    <td>{{isset($enrollment->courseBatch)?$enrollment->courseBatch->course_batch_name:null}}</td>
                                    <td>{{isset($enrollment->user)?$enrollment->user->name:null}}</td>
                                    <td>
                                        {!! \CHTML::flagChangeButton($enrollment, 'enroll_status', ['ACTIVE','INACTIVE']) !!}
                                    </td>
                                    <td> {{isset($enrollment->created_at)?$enrollment->created_at->format('d M, Y'):null}}</td>
                                   <td class="tbl-action">
                                        {!!
                                            \CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $enrollment->id,
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
                {!! \CHTML::customPaginate($enrollments,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection
@push('scripts')
    <script>
        var selected_course_id = '{{old("course_id", (isset($request)?$request->course_id:null))}}';
        var selected_batch_id = '{{old("batch_id", (isset($request)?$request->batch_id:null))}}';
        var selected_user_id = '{{old("user_id", (isset($request)?$request->user_id:null))}}';

        $(document).ready(function () {
            getCourseList();
            $("#company_id").change(function () {
                getCourseList();
                getUserList();
            });

            getCourseBatchList();
            $("#course_id").change(function () {
                getCourseBatchList();
            });

            getUserList();
            $("#batch_id").change(function () {
                getUserList();
            });
        });


        function getCourseList() {
            var company_id = $('#company_id').val();
            var pickToken = '{{csrf_token()}}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('course.get-course-list')}}',
                    data: {
                        company_id: company_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#course_id").empty();
                            $("#course_id").append('<option value="">Please Select Course</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_course_id == value.id) {
                                    courseSelectedStatus = ' selected ';
                                } else {
                                    courseSelectedStatus = '';
                                }
                                $("#course_id").append('<option value="' + value.id + '" ' + courseSelectedStatus + '>' + value.course_title + '</option>');
                            });
                        } else {
                            $("#course_id").empty();
                            $("#course_id").append('<option value="">Please Select Course</option>');
                        }
                    }
                });
            } else {
                $("#course_id").empty();
                $("#course_id").append('<option value="">Please Select Course</option>');
            }
        }

        function getCourseBatchList() {
            var course_id = $('#course_id').val();
            var pickToken = '{{csrf_token()}}';
            if (course_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('course-batches.get-course-batch-list')}}',
                    data: {
                        course_id: course_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#batch_id").empty();
                            $("#batch_id").append('<option value="">Please Select Course Batch</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_batch_id == value.id) {
                                    courseBatchSelectedStatus = ' selected ';
                                } else {
                                    courseBatchSelectedStatus = '';
                                }
                                $("#batch_id").append('<option value="' + value.id + '" ' + courseBatchSelectedStatus + '>' + value.course_batch_name + '</option>');
                            });
                        } else {
                            $("#batch_id").empty();
                            $("#batch_id").append('<option value="">Please Select Course Batch</option>');
                        }
                    }
                });
            } else {
                $("#batch_id").empty();
                $("#batch_id").append('<option value="">Please Select Course Batch</option>');
            }
        }

        function getUserList() {
            var company_id = $('#company_id').val();
            var pickToken = '{{csrf_token()}}';
            if (batch_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('user-details.get-user-detail-list')}}',
                    data: {
                        company_id: company_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#user_id").empty();
                            $("#user_id").append('<option value="">Please Select User</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_user_id == value.id) {
                                    userSelectedStatus = ' selected ';
                                } else {
                                    userSelectedStatus = '';
                                }
                                $("#user_id").append('<option value="' + value.id + '" ' + userSelectedStatus + '>' + value.name + '</option>');
                            });
                        } else {
                            $("#user_id").empty();
                            $("#user_id").append('<option value="">Please Select User</option>');
                        }
                    }
                });
            } else {
                $("#user_id").empty();
                $("#user_id").append('<option value="">Please Select User</option>');
            }
        }
    </script>
@endpush


