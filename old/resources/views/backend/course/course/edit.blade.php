@extends('backend.layouts.master')
@section('title')
    Update Course Information
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-paragraph" aria-hidden="true"></i>
        Course
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
                        <h3 class="box-title">Edit </h3>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="course_form" role="form" method="POST"
                          action="{{ route('course.update',$course->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('backend.course.course.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
        @endsection


        @push('old-scripts')
            <script>
                var selected_course_category_id = '{{old("course_category_id", (isset($course_sub_category)?$course_sub_category->course_category_id:null))}}';
                var selected_course_sub_category_id = '{{old("course_sub_category_id", (isset($course_child_category)?$course_child_category->course_sub_category_id:null))}}';
                var selected_course_child_category_id = '{{old("course_child_category_id", (isset($course)?$course->course_child_category_id:null))}}';

                $(document).ready(function () {
                    getCourseCategoryList();
                    $("#company_id").change(function () {
                        getCourseCategoryList();
                    });

                    getCourseSubCategoryList();
                    $("#course_category_id").change(function () {
                        getCourseSubCategoryList();
                    });

                    getCourseChildCategoryList();
                    $("#course_sub_category_id").change(function () {
                        getCourseChildCategoryList();
                    });

                    jQuery.validator.addMethod("noSpace", function (value, element) {
                        return value.indexOf(" ") < 0 && value != "";
                    }, "No space please and don't leave it empty");

                    jQuery.validator.addMethod("alphanumeric", function (value, element) {
                        return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
                    }, "Letters and numbers only please");

        $("#course_form").validate({
                                rules: {
                                    course_title: {
                                        required: true,
                                        noSpace: false,
                                    },
                                    company_id: {
                                         required: true,
                                    },
                                    course_category_id: {
                                         required: true,
                                    },
                                    course_sub_category_id: {
                                         required: true,
                                    },
                                    course_child_category_id: {
                                         required: true,
                                    },
                                    course_title: {
                                         required: true,
                                         alphanumeric: true,
                                    },
                                    course_duration_expire: {
                                        digits: true,
                                        step:1,
                                        max: 5,
                                        min: 1,
                                    },
                                    course_position: {
                                        digits: true,
                                        step:1,
                                        max: 2,
                                        min: 1,
                                    },
                                    course_image: {
                                        extension: "jpg|jpeg|png|webp"
                                    },
                                    course_file: {
                                        extension: "doc|docx|pdf"
                                    },
                                    course_video: {
                                        extension: "mp4,mov,ogg|max:10240"
                                    }
                                }
                    });
    });


                function getCourseCategoryList() {
                    var company_id = $('#company_id').val();
                    var pickToken = '{{csrf_token()}}';
                    if (company_id) {
                        $.ajax({
                            type: "POST",
                            dataType: 'json',
                            url: '{{route('course-categories.get-course-category-list')}}',
                            data: {
                                company_id: company_id,
                                '_token': pickToken
                            },
                            success: function (res) {
                                if (res.status == 200) {
                                    $("#course_category_id").empty();
                                    $("#course_category_id").append('<option value="">Please Select Course Category</option>');
                                    $.each(res.data, function (key, value) {
                                        if (selected_course_category_id == value.id) {
                                            courseCategorySelectedStatus = ' selected ';
                                        } else {
                                            courseCategorySelectedStatus = '';
                                        }
                                        $("#course_category_id").append('<option value="' + value.id + '" ' + courseCategorySelectedStatus + '>' + value.course_category_title + '</option>');
                                    });
                                } else {
                                    $("#course_category_id").empty();
                                    $("#course_category_id").append('<option value="">Please Select Course Category</option>');
                                }
                            }
                        });
                    } else {
                        $("#course_category_id").empty();
                        $("#course_category_id").append('<option value="">Please Select Course Category</option>');
                    }
                }

                function getCourseSubCategoryList() {
                    var course_category_id = $('#course_category_id').val();
                    var pickToken = '{{csrf_token()}}';
                    if (course_category_id) {
                        $.ajax({
                            type: "POST",
                            dataType: 'json',
                            url: '{{route('course-sub-categories.get-course-sub-category-list')}}',
                            data: {
                                course_category_id: course_category_id,
                                '_token': pickToken
                            },
                            success: function (res) {
                                if (res.status == 200) {
                                    $("#course_sub_category_id").empty();
                                    $("#course_sub_category_id").append('<option value="">Please Select Course Sub Category</option>');
                                    $.each(res.data, function (key, value) {
                                        if (selected_course_sub_category_id == value.id) {
                                            courseSubCategorySelectedStatus = ' selected ';
                                        } else {
                                            courseSubCategorySelectedStatus = '';
                                        }
                                        $("#course_sub_category_id").append('<option value="' + value.id + '" ' + courseSubCategorySelectedStatus + '>' + value.course_sub_category_title + '</option>');
                                    });
                                } else {
                                    $("#course_sub_category_id").empty();
                                    $("#course_sub_category_id").append('<option value="">Please Select Course Sub Category</option>');
                                }
                            }
                        });
                    } else {
                        $("#course_sub_category_id").empty();
                        $("#course_sub_category_id").append('<option value="">Please Select Course Sub Category</option>');
                    }
                }

                function getCourseChildCategoryList() {
                    var course_sub_category_id = $('#course_sub_category_id').val();
                    var pickToken = '{{csrf_token()}}';
                    if (course_sub_category_id) {
                        $.ajax({
                            type: "POST",
                            dataType: 'json',
                            url: '{{route('course-child-categories.get-course-child-category-list')}}',
                            data: {
                                course_sub_category_id: course_sub_category_id,
                                '_token': pickToken
                            },
                            success: function (res) {
                                if (res.status == 200) {
                                    $("#course_child_category_id").empty();
                                    $("#course_child_category_id").append('<option value="">Please Select Course Child Category</option>');
                                    $.each(res.data, function (key, value) {
                                        if (selected_course_child_category_id == value.id) {
                                            courseChildCategorySelectedStatus = ' selected ';
                                        } else {
                                            courseChildCategorySelectedStatus = '';
                                        }
                                        $("#course_child_category_id").append('<option value="' + value.id + '" ' + courseChildCategorySelectedStatus + '>' + value.course_child_category_title + '</option>');
                                    });
                                } else {
                                    $("#course_child_category_id").empty();
                                    $("#course_child_category_id").append('<option value="">Please Select Course Child Category</option>');
                                }
                            }
                        });
                    } else {
                        $("#course_child_category_id").empty();
                        $("#course_child_category_id").append('<option value="">Please Select Course Child Category</option>');
                    }
                }
            </script>
            <script>
                $("#course_video_id").change(function () {
                    var val = $("#course_video_id").val();
                    $("#video_file").html('');
                    if (val == "upload") {
                        $("#video_file").append('<input type="file" class="form-control" id="course_video" name="course_video" value="{{ old('course_video', isset($course) ? $course->course_video : null) }}" style="width: auto;" placeholder="Upload"><a href="" style=" margin-top: 8px; width:50px; height:auto" data-toggle="modal" data-target="#exampleModalCenter">Preview Existing Video</a>');

                    }

                    if (val == "url") {
                        $("#video_file").append('<input type="text" class="form-control" id="course_video_url" name="course_video_url" value="{{ old('course_video_url', isset($course) ? $course->course_video_url : null) }}" placeholder="Enter Course URL: https://www.youtube.com/">');
                    }
                });
            </script>
            <script>
                $("#course_content_type").change(function () {
                    var val = $("#course_content_type").val();
                    $("#content_type").html('');
                    if (val == "paid") {
                        $("#content_type").append('<input type="text" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" style="margin-bottom:10px" class="form-control float_number" id="course_regular_price" name="course_regular_price" value="{{ old('course_regular_price', isset($course) ? $course->course_regular_price : null) }}"  placeholder="Enter Course Regular Price">' + '<input type="text" onkeypress="if ( isNaN(this.value + String.fromCharCode(event.keyCode) )) return false;" class="form-control float_number" id="course_discount" name="course_discount" value="{{ old('course_discount', isset($course) ? $course->course_discount : null) }}"  placeholder="Enter Course Discount Price">');

                    }
                });
            </script>
    @endpush

