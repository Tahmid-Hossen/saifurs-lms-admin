@extends('backend.layouts.master')
@section('title')
    Create/Add Course Assignment
@endsection


@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @section('content-header')
            <h1>
                <i class="fa fa-building"></i>
                Course Assignment
                <small>Control Panel</small>
            </h1>
            {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
        @endsection
        @include('backend.layouts.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create </h3>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="course_assignment_form" role="form" method="POST"
                          action="{{ route('course-assignments.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('backend.course.course-assignments.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script>
        var selected_branch_id = '{{old("branch_id", (isset($courseAssignment)?$courseAssignment->branch_id:null))}}';
        var selected_course_id = '{{old("course_id", (isset($courseAssignment)?$courseAssignment->course_id:null))}}';
        var selected_course_chapter_id = '{{old("course_chapter_id", (isset($courseAssignment)?$courseAssignment->course_chapter_id:null))}}';
        var selected_announcement_id = '{{old("announcement_id", (isset($courseAssignment)?$courseAssignment->announcement_id:null))}}';
        var selected_instructor_id = '{{old("instructor_id", (isset($courseAssignment)?$courseAssignment->instructor_id:null))}}';
        var selected_student_id = '{{old("student_id", (isset($courseAssignment)?$courseAssignment->student_id:null))}}';
        $(document).ready(function () {
            getBranchList();
            getCourseList();
            getCourseChapterList();
            getCourseAnnouncementList();
            getTeacherList();
            getStudentList();
            $("#company_id").change(function () {
                getBranchList();
                getCourseList();
                getCourseChapterList();
                getTeacherList();
                getStudentList();
            });
            $("#branch_id").change(function () {
                getCourseList();
                getCourseChapterList();
                getTeacherList();
                getStudentList();
            });
            $("#course_id").change(function () {
                getCourseChapterList();
                getCourseAnnouncementList();
                getTeacherList();
                getStudentList();
            });
            jQuery.validator.addMethod("noSpace", function (value, element) {
                return value.indexOf(" ") < 0 && value != "";
            }, "No space please and don't leave it empty");

            jQuery.validator.addMethod("alphanumeric", function (value, element) {
                return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
            }, "Letters and numbers only please");

            $("#course_assignment_form").validate({
                rules: {
                    company_id: {
                        required: true
                    },
                    course_id: {
                        required: true
                    },
                    instructor_id: {
                        required: true
                    },
                    student_id: {
                        required: true
                    },
                    course_assignment_name: {
                        required: true
                    },
                    course_assignment_detail: {
                        required: true
                    },
                    course_assignment_url: {
                        url: true
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
                            var branchSelectedStatus = '';
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
                        // 'course_option_is_not': "Offline",
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#course_id").empty();
                            $("#course_id").append('<option value="">Please Select Course</option>');
                            var courseSelectedStatus = '';
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
                            var courseChapterSelectedStatus = '';
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

        function getCourseAnnouncementList() {
            var company_id = $('#company_id').val();
            var branch_id = $('#branch_id').val() || '';
            var course_id = $('#course_id').val() || '';
            var pickToken = '{{csrf_token()}}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: '{{route('course-announcements.get-course-announcement-list')}}',
                    data: {
                        company_id: company_id,
                        branch_id: branch_id,
                        course_id: course_id,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#announcement_id").empty();
                            $("#announcement_id").append('<option value="">Please Select Announcement</option>');
                            var courseAnnouncementSelectedStatus = '';
                            $.each(res.data, function (key, value) {
                                if (selected_announcement_id == value.id) {
                                    courseAnnouncementSelectedStatus = ' selected ';
                                } else {
                                    courseAnnouncementSelectedStatus = '';
                                }
                                $("#announcement_id").append('<option value="' + value.id + '" ' + courseAnnouncementSelectedStatus + '>' + value.announcement_title + '</option>');
                            });
                        } else {
                            $("#announcement_id").empty();
                            $("#announcement_id").append('<option value="">Please Select Announcement</option>');
                        }
                    }
                });
            } else {
                $("#announcement_id").empty();
                $("#announcement_id").append('<option value="">Please Select Announcement</option>');
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
                            var instructorSelectedStatus = '';
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
            var is_course_student = true;
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
                        is_course_student: is_course_student,
                        '_token': pickToken
                    },
                    success: function (res) {
                        if (res.status == 200) {
                            $("#student_id").empty();
                            $("#student_id").append('<option value="">Please Select Student</option>');
                            var studentSelectedStatus = '';
                            $.each(res.data, function (key, value) {
                                if (selected_student_id == value.user_id) {
                                    studentSelectedStatus = ' selected ';
                                } else {
                                    studentSelectedStatus = '';
                                }
                                $("#student_id").append('<option value="' + value.user_id + '" ' + studentSelectedStatus + '>' + value.first_name + ' ' + value.last_name + ' (' + value.mobile_phone + ')' + '</option>');
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
@endsection
