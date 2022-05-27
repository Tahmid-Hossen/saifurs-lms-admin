@extends('backend.layouts.master')
@section('title')
    Update Enrollment Information
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
                <form class="horizontal-form" id="enrollment_form" role="form" method="POST" action="{{ route('enrollments.update',$enrollment->id) }}" enctype="multipart/form-data">
                   @csrf
                    @method('PUT')
                    @include('backend.enrollment.form')
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>


    <script>
        var selected_course_id = '{{old("course_id", (isset($enrollment)?$enrollment->course_id:null))}}';
        var selected_batch_id = '{{old("batch_id", (isset($enrollment)?$enrollment->batch_id:null))}}';
        var selected_user_id = '{{old("user_id", (isset($enrollment)?$enrollment->user_id:null))}}';

        $(document).ready(function() {
            getCourseCategoryList();
            $("#company_id").change(function() {
                getCourseCategoryList();
            });

            getCourseBatchList();
            $("#course_id").change(function() {
                getCourseBatchList();
            });

            getUserList();
            $("#batch_id").change(function() {
                getUserList();
            });

            // jQuery.validator.addMethod("noSpace", function(value, element) {
            //     return value.indexOf(" ") < 0 && value != "";
            // }, "No space please and don't leave it empty");

            // jQuery.validator.addMethod("alphanumeric", function(value, element) {
            //     return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
            // }, "Letters and numbers only please");

            $("#enrollment_form").validate({
                rules: {
                    enroll_title: {
                        required: true,
                    },
                    company_id: {
                        required: true,
                    },

                    course_id: {
                        required: true,
                    },

                    user_id: {
                        required: true,
                    },
                }
            });
        });


        function getCourseCategoryList(){
            var company_id = $('#company_id').val();
            var pickToken = '{{csrf_token()}}';
            if(company_id){
                $.ajax({
                    type:"POST",
                    dataType:'json',
                    url:'{{route('course.get-course-list')}}',
                    data:{
                        company_id : company_id,
                        '_token':pickToken
                    },
                    success:function(res){
                        if(res.status == 200){
                            $("#course_id").empty();
                            $("#course_id").append('<option value="">Please Select Course</option>');
                            $.each(res.data,function(key,value){
                                if(selected_course_id == value.id){
                                    courseSelectedStatus = ' selected ';
                                }else{
                                    courseSelectedStatus = '';
                                }
                                $("#course_id").append('<option value="'+value.id+'" '+courseSelectedStatus+'>'+value.course_title+'</option>');
                            });
                        }else{
                            $("#course_id").empty();
                            $("#course_id").append('<option value="">Please Select Course</option>');
                        }
                    }
                });
            }else{
                $("#course_id").empty();
                $("#course_id").append('<option value="">Please Select Course</option>');
            }
        }

        function getCourseBatchList(){
            var course_id = $('#course_id').val();
            var pickToken = '{{csrf_token()}}';
            if(course_id){
                $.ajax({
                    type:"POST",
                    dataType:'json',
                    url:'{{route('course-batches.get-course-batch-list')}}',
                    data:{
                        course_id : course_id,
                        '_token':pickToken
                    },
                    success:function(res){
                        if(res.status == 200){
                            $("#batch_id").empty();
                            $("#batch_id").append('<option value="">Please Select Course Batch</option>');
                            $.each(res.data,function(key,value){
                                if(selected_batch_id == value.id){
                                    courseBatchSelectedStatus = ' selected ';
                                }else{
                                    courseBatchSelectedStatus = '';
                                }
                                $("#batch_id").append('<option value="'+value.id+'" '+courseBatchSelectedStatus+'>'+value.course_batch_name+'</option>');
                            });
                        }else{
                            $("#batch_id").empty();
                            $("#batch_id").append('<option value="">Please Select Course Batch</option>');
                        }
                    }
                });
            }else{
                $("#batch_id").empty();
                $("#batch_id").append('<option value="">Please Select Course Batch</option>');
            }
        }

        function getUserList(){
            var batch_id = $('#course_id').val();
            var pickToken = '{{csrf_token()}}';
            if(batch_id){
                $.ajax({
                    type:"POST",
                    dataType:'json',
                    url:'{{route('user-details.get-user-detail-list')}}',
                    data:{
                        batch_id : batch_id,
                        '_token':pickToken
                    },
                    success:function(res){
                        if(res.status == 200){
                            $("#user_id").empty();
                            $("#user_id").append('<option value="">Please Select User</option>');
                            $.each(res.data,function(key,value){
                                if(selected_user_id == value.id){
                                    userSelectedStatus = ' selected ';
                                }else{
                                    userSelectedStatus = '';
                                }
                                $("#user_id").append('<option value="'+value.id+'" '+userSelectedStatus+'>'+value.name+'</option>');
                            });
                        }else{
                            $("#user_id").empty();
                            $("#user_id").append('<option value="">Please Select User</option>');
                        }
                    }
                });
            }else{
                $("#user_id").empty();
                $("#user_id").append('<option value="">Please Select User</option>');
            }
        }
    </script> -->

@endsection

// @push('scripts')

// @endpush
