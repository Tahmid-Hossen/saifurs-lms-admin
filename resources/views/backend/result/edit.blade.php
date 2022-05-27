@extends('backend.layouts.master')
@section('title')
    Update Result Information
@endsection


@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @section('content-header')
            <h1>
                <i class="fa fa-star" aria-hidden="true"></i>
                Result
                <small>Control panel</small>
            </h1>
            {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
        @endsection
        @include('backend.layouts.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit </h3>&nbsp;<sub class="text-danger text-sm-right"><i></i></sub>
                    </div>
                </div>
                <!-- form start -->
                <form class="horizontal-form" id="result_form" role="form" method="POST" action="{{ route('results.update',$result->id) }}" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PUT')}}
                    @include('backend.result.form')
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script>
        var selected_course_id = '{{old("course_id", (isset($result)?$result->course_id:null))}}';
        var selected_batch_id = '{{old("batch_id", (isset($result)?$result->batch_id:null))}}';
        var selected_quiz_id = '{{old("quiz_id", (isset($result)?$result->quiz_id:null))}}';
        var selected_user_id = '{{old("user_id", (isset($result)?$result->user_id:null))}}';

                $(document).ready(function() {
                    getCourseList();
                    $("#company_id").change(function() {
                        getCourseList();
                    });

                    getQuizList();
                    $("#course_id").change(function() {
                        getQuizList();
                    });

                    getStudentList();
                    $("#company_id").change(function() {
                        getStudentList();
                    });


                    jQuery.validator.addMethod("noSpace", function(value, element) {
                        return value.indexOf(" ") < 0 && value != "";
                    }, "No space please and don't leave it empty");

                    jQuery.validator.addMethod("alphanumeric", function(value, element) {
                        return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
                    }, "Letters and numbers only please");

                    $("#result_form").validate({
                        rules: {
                            result_title: {
                                // required: true,
                                noSpace: false,
                            },
                            company_id: {
                                required: true,
                            },
                            course_id: {
                                required: true,
                            },
                            user_id: {
                                required: true,
                            }
                        }
                    });
                });


                function getCourseList(){
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

                function getQuizList(){
                    var course_id = $('#course_id').val();
                    var pickToken = '{{csrf_token()}}';
                    if(course_id){
                        $.ajax({
                            type:"POST",
                            dataType:'json',
                            url:'{{route('quizzes.get-quiz-list')}}',
                            data:{
                                course_id : course_id,
                                '_token':pickToken
                            },
                            success:function(res){
                                if(res.status == 200){
                                    $("#quiz_id").empty();
                                    $("#quiz_id").append('<option value="">Please Select Quiz</option>');
                                    $.each(res.data,function(key,value){
                                        if(selected_quiz_id == value.id){
                                            quizSelectedStatus = ' selected ';
                                        }else{
                                            quizSelectedStatus = '';
                                        }
                                        $("#quiz_id").append('<option value="'+value.id+'" '+quizSelectedStatus+'>'+value.quiz_topic+'</option>');
                                    });
                                }else{
                                    $("#quiz_id").empty();
                                    $("#quiz_id").append('<option value="">Please Select Quiz</option>');
                                }
                            }
                        });
                    }else{
                        $("#quiz_id").empty();
                        $("#quiz_id").append('<option value="">Please Select Quiz</option>');
                    }
                }

                function getStudentList(){
                    var company_id = $('#company_id').val();
                    var pickToken = '{{csrf_token()}}';
                    if(company_id){
                        $.ajax({
                            type:"POST",
                            dataType:'json',
                            url:'{{route('students.get-student-list')}}',
                            data:{
                                company_id : company_id,
                                '_token':pickToken
                            },
                            success:function(res){
                                if(res.status == 200){
                                    $("#user_id").empty();
                                    $("#user_id").append('<option value="">Please Select Student</option>');
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
                                    $("#user_id").append('<option value="">Please Select Student</option>');
                                }
                            }
                        });
                    }else{
                        $("#user_id").empty();
                        $("#user_id").append('<option value="">Please Select Student</option>');
                    }
                }
    </script>
@endsection

@section('scripts')

@endsection
