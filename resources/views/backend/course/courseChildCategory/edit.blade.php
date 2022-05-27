@extends('backend.layouts.master')
@section('title')
    Update Course Child Category Information
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-list-alt"></i>
        Course Child Category
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
                        <h3 class="box-title">Edit </h3>&nbsp;<sub class="text-danger text-sm-right"><i>(All "*" fields
                                are required)</i></sub>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="course_child_category_form" role="form" method="POST"
                          action="{{ route('course-child-categories.update',$course_child_category->id) }}"
                          enctype="multipart/form-data">
                        @csrf
                        {{method_field('PUT')}}
                        @include('backend.course.courseChildCategory.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
@endsection

@push('scripts')
    <!-- <script>
            var selected_course_category_id = '{{old("course_category_id", (isset($course_child_category)?$course_child_category->course_category_id:null))}}';
            var selected_course_sub_category_id = '{{old("course_sub_category_id", (isset($course_child_category)?$course_child_category->course_sub_category_id:null))}}';

            $(document).ready(function () {
                getCourseCategoryList();
                $("#company_id").change(function () {
                    getCourseCategoryList();
                });

                getCourseSubCategoryList();
                $("#course_category_id").change(function () {
                    getCourseSubCategoryList();
                });
                jQuery.validator.addMethod("noSpace", function (value, element) {
                    return value.indexOf(" ") < 0 && value != "";
                }, "No space please and don't leave it empty");

                jQuery.validator.addMethod("alphanumeric", function (value, element) {
                    return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
                }, "Letters and numbers only please");

                jQuery.validator.addMethod("alphanumericSpace", function (value, element) {
                    return this.optional(element) || /^[A-Za-z0-9 ]+$/i.test(value);
                }, "Letters, numbers and space only please");

                $("#course_child_category_form").validate({
                    rules: {
                        course_child_category_title: {
                            required: true,
                            alphanumericSpace: true
                        },
                        company_id: {
                            required: true,
                        },

                        course_category_id: {
                            required: true
                        },
                        course_sub_category_id: {
                            required: true
                        },

                        course_child_category_image: {
                            // required: true,
                            extension: "jpg|jpeg|png|ico|bmp|svg"
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
        </script> -->
@endpush
