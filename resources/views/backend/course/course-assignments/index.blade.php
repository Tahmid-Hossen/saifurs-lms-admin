@extends('backend.layouts.master')
@section('title')
    Course Assignments
@endsection
@section('page_styles')

@endsection
@section('content-header')
    <h1>
        <i class="fa fa-file-text"></i>
        Submitted Assignments
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
                    <h3 class="box-title">Find Course Assignments</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <form class="horizontal-form" role="form" method="GET"
                          action="{{ route('course-assignments.index') }}">
                        <div class="row">
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
                                <div class="form-group">
                                    <label for="barcode" class="control-label">Search:</label>
                                    <input type="text" class="form-control" id="search_text" name="search_text"
                                           value="{{ $request->search_text }}" placeholder="Search Text">
                                </div>
                            </div>
                            @role(\Utility::SUPER_ADMIN)
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
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
                            @endrole
                            <div class="@role(\Utility::SUPER_ADMIN) col-md-4 @else col-md-6 @endrole">
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
                                    <label for="course_assignment_review" class="control-label">Review:</label>
                                    <select name="course_assignment_review" id="course_assignment_review"
                                            class="form-control">
                                        <option value="">Select IS Review</option>
                                        <option value="Unchecked">Unchecked</option>
                                        <option value="Checked">Checked</option>
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
                        $caption="Course Assignments",
                        $captionIcon="icon-users",
                        $routeName="course-assignments",
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
                                <th>#</th>
                                <th> @sortablelink('student', 'Students')</th>
                                <th> @sortablelink('course', 'Courses')</th>
                                {{-- <th> Course Chapters</th> --}}
                                <th> @sortablelink('courseAnnouncement', 'Announcement')</th>
                                <th> @sortablelink('courseAssignment', 'Assignment')</th>
                                {{--                                <th> IS Reviewed</th>--}}
                                <th> Review</th>
                                <th> @sortablelink('created_at', 'Created Date')</th>
                                <th class="tbl-action"> Actions</th>
                            </tr>
                            </thead>
                            <tbody>

                            {{--{{dd($courseAssignments)}}--}}
                            @foreach($courseAssignments as $index => $courseAssignment)

                                <tr>
                                    <td>{{ $index+1 }}</td>
                                    <td>{{isset($courseAssignment->student)?strtoupper($courseAssignment->student->name):null}}</td>
                                    <td>{{isset($courseAssignment->course)?strtoupper($courseAssignment->course->course_title):null}}</td>
                                    {{-- <td>{{isset($courseAssignment->courseChapter)?strtoupper($courseAssignment->courseChapter->chapter_title):null}}</td> --}}
                                    <td>{{isset($courseAssignment->courseAnnouncement)?strtoupper($courseAssignment->courseAnnouncement->announcement_title):null}}</td>
                                    <td>{{isset($courseAssignment)?strtoupper($courseAssignment->course_assignment_name):null}}</td>
                                    {{--
                                                                        <td>{{isset($courseAssignment)?strtoupper($courseAssignment->course_assignment_review):null}}</td>
                                    --}}
                                    {{--                                    <td>
                                                                            <a href="{{asset(isset($courseAssignment->course_assignment_document)?($courseAssignment->course_assignment_document):null)}}"
                                                                               class="fa fa-download">&nbsp;Download</a>
                                                                        </td>--}}

                                    <td> {{$courseAssignment->created_at->format(config('app.date_format2'))}}</td>

                                    <td>
                                        {!!
                                            CHTML::ButtonCustom(
                                                array(
                                                    'route'=>'course-assignments.assignment-review',
                                                    'URL'=>route('course-assignments.assignment-review', $courseAssignment->id),
                                                    'class'=>'btn btn-xs btn-success  mx-2 btn-icon btn-circle',
                                                    'buttonName'=>'Review',
                                                    'buttonIcon'=>'fa fa-align-justify'
                                                )
                                            )
                                        !!}
                                    </td>
                                    <td class="tbl-action">
                                        {!!
                                            CHTML::actionButton(
                                                $reportTitle='..',
                                                $routeLink='#',
                                                $courseAssignment->id,
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
                {!! CHTML::customPaginate($courseAssignments,'') !!}
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
        $(document).ready(function () {
            getBranchList();
            getCourseList();
            $("#company_id").change(function () {
                getBranchList();
            });
            $("#branch_id").change(function () {
                getCourseList();
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
    </script>
@endpush


