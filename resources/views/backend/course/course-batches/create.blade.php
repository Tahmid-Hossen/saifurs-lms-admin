@extends('backend.layouts.master')
@section('title')
    Create/Add Course Batch
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-laptop"></i>
        Course Batch
        <small>Control Panel</small>
    </h1>
    {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
@endsection

@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">

        @include('backend.layouts.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create </h3>&nbsp;<span
                            class="text-danger"></span>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="course_batch_form" role="form" method="POST"
                          action="{{ route('course-batches.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('backend.course.course-batches.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection

@push('scripts')
    <script>
        var selected_branch_id = '{{old("branch_id", (isset($courseBatch)?$courseBatch->branch_id:null))}}';
        var selected_course_id = '{{old("course_id", (isset($courseBatch)?$courseBatch->course_id:null))}}';
        var selected_instructor_id = '{{old("instructor_id", (isset($courseBatch)?$courseBatch->instructor_id:null))}}';
        var selected_student_id = '{{old("student_id", (isset($courseBatch)?$courseBatch->student_id:null))}}';

        $(document).ready(function () {
            //getBranchList();
            //getCourseList();
            getTeacherList();
            getStudentList();

            $("#company_id").change(function () {
                getBranchList();
                getCourseList();
                getTeacherList();
                getStudentList();
            });

            $("#branch_id").change(function () {
                getCourseList();
                getTeacherList();
                getStudentList();
            });

            $("#course_batch_form").validate({
                rules: {
                    company_id: {
                        required: true
                    },
                    course_id: {
                        required: true
                    },
                    /*course_chapter_id: {
                        required: true
                    },*/
                    instructor_id: {
                        required: true
                    },
                    /*student_id: {
                        required: true
                    },*/
                    course_batch_name: {
                        required: true
                    },
                    course_batch_logo: {
                        required: true,
                        extension: "jpg|jpeg|png|ico|bmp|svg"
                    }
                }
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
                        '_token': pickToken,
                        'course_type_is_not': "Recorded",
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

        function getTeacherList() {
            var company_id = $('#company_id').val();
            var branch_id = $('#branch_id').val() || '';
            var course_id = $('#course_id').val() || '';
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

        function getStudentList() {
            var company_id = $('#company_id').val();
            var branch_id = $('#branch_id').val() || '';
            var course_id = $('#course_id').val() || '';
            var pickToken = '{{csrf_token()}}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('students.get-student-list')}}',
                    data: {
                        company_id: company_id,
                        branch_id: branch_id,
                        course_id: course_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#student_id").empty();
                            $("#student_id").append('<option value="">Please Select Student</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_student_id == value.user_id) {
                                    studentSelectedStatus = ' selected ';
                                } else {
                                    studentSelectedStatus = '';
                                }
                                $("#student_id").append('<option value="' + value.user_id + '" ' + instructorSelectedStatus + '>' + value.first_name + ' ' + value.last_name + ' (' + value.mobile_phone + ')' + '</option>');
                            });
                        } else {
                            $("#student_id").empty();
                            $("#student_id").append('<option value="">Please Select Student</option>');
                        }
                    }
                });
            } else {
                $("#student_id").empty();
                $("#student_id").append('<option value="">Please Select Student</option>');
            }
        }
    </script>
@endpush
