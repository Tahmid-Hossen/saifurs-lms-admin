@extends('backend.layouts.master')
@section('title')
    Vendor Meetings
@endsection
@section('page_styles')

@endsection
@section('content-header')
    <h1>
        <i class="fa fa-user-plus"></i>
        Vendor Meeting
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection
@section('content')
    <div class="row">

        @include('backend.layouts.flash')
        <div class="col-xs-12">
            <div class="box box-default collapsed-box">
                <div class="box-header with-border">
                    <h3 class="box-title">Find Vendor Meeting</h3>

                    <div class="box-tools pull-right">
                        <a class="btn btn-primary hidden-print" id="payeePrint" href="{!! route('vendor-meetings.pdf', [
                                'search_text' => $request->get('search_text'),
                                'company_id' => $request->get('company_id'),
                                'branch_id' => $request->get('branch_id'),
                                'course_id' => $request->get('course_id'),
                                'course_chapter_id' => $request->get('course_chapter_id'),
                                'instructor_id' => $request->get('instructor_id'),
                            ])
                        !!}">
                            <i class="fa fa-file-pdf-o"></i> PDF
                        </a>
                        <a class="btn btn-primary hidden-print" id="payeePrint" href="{!! route('vendor-meetings.excel', [
                                'search_text' => $request->get('search_text'),
                                'company_id' => $request->get('company_id'),
                                'branch_id' => $request->get('branch_id'),
                                'course_id' => $request->get('course_id'),
                                'course_chapter_id' => $request->get('course_chapter_id'),
                                'instructor_id' => $request->get('instructor_id'),
                            ])
                        !!}">
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
                          action="{{ route('vendor-meetings.index') }}">
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
                                    <label for="company_id" class="control-label">Company:</label>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="branch_id" class="control-label">Branch:</label>
                                    <select name="branch_id" id="branch_id" class="form-control">
                                        <option value="">Select Branch</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">Course:</label>
                                    <select name="course_id" id="course_id" class="form-control">
                                        <option value="">Select Course</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name" class="control-label">Course Chapter:</label>
                                    <select name="course_chapter_id" id="course_chapter_id" class="form-control">
                                        <option value="">Select Course Chapter</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="instructor_id" class="control-label">Instructor</label>
                                    <select name="instructor_id" id="instructor_id" class="form-control">
                                        <option value="">Select Instructor</option>
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
            <!-- /.box -->
            <div class="box">
                {!!
                    \CHTML::formTitleBox(
                        $caption="Vendor Meetings",
                        $captionIcon="icon-users",
                        $routeName="vendor-meetings.create",
                        $buttonClass="",
                        $buttonIcon=""
                    )
                !!}

                <div class="box-body table-responsive no-padding">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                        >
                            <thead>
                            <tr>
                                <th> @sortablelink('id', 'ID')</th>
                                {{--                            <th> Logo</th>--}}
                                <th> Vendor</th>
                                <th> Name</th>
                                <th> Course</th>
                                <th> Instructor</th>
                                <th> Status</th>
                                <th> @sortablelink('created_at', 'Created At')</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($vendorMeetings as $vendorMeeting)
                                <tr>
                                    <td> {{$vendorMeeting->id}}</td>
                                    {{--<td> <img src="{{isset($vendorMeeting->vendor_meeting_logo)?URL::to($vendorMeeting->vendor_meeting_logo):'http://placehold.it/32x32/007F7B/007F7B&amp;text='.config('app.name')}}" width="32" height="32"> </td>
                                    --}}
                                    <td> {!! isset($vendorMeeting->vendor->vendor_name)?$vendorMeeting->vendor->vendor_name:null !!}</td>
                                    <td>
                                        {!!
                                            \CHTML::ButtonCustom(
                                                array(
                                                    'route'=>'vendor-meetings.show',
                                                    'URL'=>isset($vendorMeeting->vendor_meeting_url)?$vendorMeeting->vendor_meeting_url:'#',
                                                    'class'=>'btn btn-xs btn-success  mx-2 btn-icon btn-circle',
                                                    'buttonName'=>'&nbsp;'.$vendorMeeting->vendor_meeting_title,
                                                    'buttonIcon'=>'fa fa-align-justify',
                                                    'buttonNameDisplay'=>'yes',
                                                    'target'=>'_blank'
                                                )
                                            )
                                        !!}
                                    </td>
                                    <td> {!! isset($vendorMeeting->course->course_title)?$vendorMeeting->course->course_title:null !!}</td>
                                    <td>
                                        {{isset($vendorMeeting->instructor->userDetails->first_name)?$vendorMeeting->instructor->userDetails->first_name:null}}
                                        &nbsp;
                                        {{isset($vendorMeeting->instructor->userDetails->last_name)?$vendorMeeting->instructor->userDetails->last_name:null}}
                                        &nbsp;
                                        {{isset($vendorMeeting->instructor->mobile_number)?'('.$vendorMeeting->instructor->mobile_number.')':null}}
                                    </td>
                                    <td> {{$vendorMeeting->vendor_meeting_status}}</td>
                                    <td> {{$vendorMeeting->created_at->format(config('app.date_format2'))}}</td>
                                   
                                    <td class="tbl-action">
                                        {!!
                                            \CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $vendorMeeting->id,
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
                {!! \CHTML::customPaginate($vendorMeetings,'') !!}
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection
@push('scripts')
    <script>
        var selected_branch_id = '{{old("branch_id", (isset($request)?$request->branch_id:null))}}';
        var selected_course_id = '{{old("course_id", (isset($request)?$request->course_id:null))}}';
        var selected_instructor_id = '{{old("instructor_id", (isset($request)?$request->instructor_id:null))}}';
        var selected_course_chapter_id = '{{old("course_chapter_id", (isset($request)?$request->course_chapter_id:null))}}';
        $(document).ready(function () {
            getBranchList();
            getCourseList();
            $("#company_id").change(function () {
                getBranchList();
                getCourseList();
                getCourseChapterList();
                getTeacherList();
            });
            $("#branch_id").change(function () {
                getCourseList();
                getCourseChapterList();
                getTeacherList();
            });
            $("#course_id").change(function () {
                getCourseChapterList();
                getTeacherList();
            });
        });

        function getBranchList() {
            var company_id = $('#company_id').val();
            var pickToken = '{{csrf_token()}}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('branches.get-branch-list')}}',
                    data: {
                        company_id: company_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#branch_id").empty();
                            $("#branch_id").append('<option value="">Please Select Branch</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_branch_id == value.id) {
                                    branchSelectedStatus = ' selected ';
                                } else {
                                    branchSelectedStatus = '';
                                }
                                $("#branch_id").append('<option value="' + value.id + '" ' + branchSelectedStatus + '>' + value.branch_name + '</option>');
                            });
                        } else {
                            $("#branch_id").empty();
                            $("#branch_id").append('<option value="">Please Select Branch</option>');
                        }
                    }
                });
            } else {
                $("#branch_id").empty();
                $("#branch_id").append('<option value="">Please Select Branch</option>');
            }
        }

        function getCourseList() {
            var company_id = $('#company_id').val();
            var branch_id = $('#branch_id').val() || '';
            var pickToken = '{{csrf_token()}}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('course.get-course-list')}}',
                    data: {
                        company_id: company_id,
                        branch_id: branch_id,
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

        function getCourseChapterList() {
            var company_id = $('#company_id').val();
            var branch_id = $('#branch_id').val() || '';
            var course_id = $('#course_id').val() || '';
            var pickToken = '{{csrf_token()}}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('course.get-course-chapter-list')}}',
                    data: {
                        company_id: company_id,
                        branch_id: branch_id,
                        course_id: course_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#course_chapter_id").empty();
                            $("#course_chapter_id").append('<option value="">Please Select Course Chapter</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_course_chapter_id == value.id) {
                                    courseChapterSelectedStatus = ' selected ';
                                } else {
                                    courseChapterSelectedStatus = '';
                                }
                                $("#course_chapter_id").append('<option value="' + value.id + '" ' + courseChapterSelectedStatus + '>' + value.chapter_title + '</option>');
                            });
                        } else {
                            $("#course_chapter_id").empty();
                            $("#course_chapter_id").append('<option value="">Please Select Course Chapter</option>');
                        }
                    }
                });
            } else {
                $("#course_chapter_id").empty();
                $("#course_chapter_id").append('<option value="">Please Select Course Chapter</option>');
            }
        }

        function getTeacherList() {
            var company_id = $('#company_id').val();
            var branch_id = $('#branch_id').val() || '';
            var course_id = $('#course_id').val() || '';
            var is_course_instructor = true;
            var pickToken = '{{csrf_token()}}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('teachers.get-teacher-list')}}',
                    data: {
                        company_id: company_id,
                        branch_id: branch_id,
                        course_id: course_id,
                        is_course_instructor: is_course_instructor,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#instructor_id").empty();
                            $("#instructor_id").append('<option value="">Please Select Instructor</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_instructor_id == value.user_id) {
                                    instructorSelectedStatus = ' selected ';
                                } else {
                                    instructorSelectedStatus = '';
                                }
                                $("#instructor_id").append('<option value="' + value.user_id + '" ' + instructorSelectedStatus + '>' + value.first_name + ' ' + value.last_name + ' (' + value.mobile_phone + ')' + '</option>');
                            });
                        } else {
                            $("#instructor_id").empty();
                            $("#instructor_id").append('<option value="">Please Select Instructor</option>');
                        }
                    }
                });
            } else {
                $("#instructor_id").empty();
                $("#instructor_id").append('<option value="">Please Select Instructor</option>');
            }
        }
    </script>
@endpush


