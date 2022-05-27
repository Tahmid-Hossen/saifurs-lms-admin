@extends('backend.layouts.master')
@section('title')
    Edit/Update Course Batch
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
                        <h3 class="box-title">Edit/Update </h3>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="course_batch_form" role="form" method="POST"
                          action="{{ route('course-batches.update', $courseBatch->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('backend.course.course-batches.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    {{-- Hidden Atributes --}}
    <input type="hidden" id="batch_id" value="{{ $courseBatch->id }}">
@endsection

@push('scripts')

    {{-- Student IDs--}}
    @php
        $studentIds = [];

        $dummyList = $courseBatch->student;
        if(count($dummyList) > 0) {
            foreach ($dummyList as $student) {
                $studentIds[] = $student->id;
            }
        }
    @endphp
    <script>
        var existing_course_batch_student_ids = {{ json_encode($studentIds) }};
        var existing_course_batch_course_id = '{{ $courseBatch->course_id }}';
    </script>
    {{-- End Student IDs--}}

    <script>
        var selected_branch_id = '{{old("branch_id", (isset($courseBatch)?$courseBatch->branch_id:null))}}';
        var selected_course_id = '{{old("course_id", (isset($courseBatch)?$courseBatch->course_id:null))}}';
        var selected_instructor_id = '{{old("instructor_id", (isset($courseBatch)?$courseBatch->instructor_id:null))}}';
        var selected_student_id = '{{old("student_id", (isset($courseBatch)?$courseBatch->student_id:null))}}';

        $(document).ready(function () {
            getBranchList();
            getCourseList();
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
            $("#course_id").change(function () {
                getTeacherList();
                getStudentList();
                var courseid = $(this).val();


            });

            jQuery.validator.addMethod("noSpace", function (value, element) {
                return value.indexOf(" ") < 0 && value != "";
            }, "No space please and don't leave it empty");

            jQuery.validator.addMethod("alphanumeric", function (value, element) {
                return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
            }, "Letters and numbers only please");

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
                        if (res.status === 200) {
                            $("#student_id").empty();
                            $("#student_id").append('<option value="">Please Select Student</option>');
                            $.each(res.data, function (key, value) {
                                if (selected_student_id == value.user_id) {
                                    studentSelectedStatus = ' selected ';
                                } else {
                                    studentSelectedStatus = '';
                                }
                                $("#student_id").append('<option value="' + value.user_id + '" ' + studentSelectedStatus + '>' + value.first_name + ' ' + value.last_name + ' (' + value.mobile_phone + ')' + '</option>');
                                courseBaseStudentSelect(course_id);
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

        function courseBaseStudentSelect(courseid) {
            if (courseid == existing_course_batch_course_id) {
                $("#student_id").val(existing_course_batch_student_ids);
                $("#student_id").trigger('change');
            }
        }
    </script>
@endpush
