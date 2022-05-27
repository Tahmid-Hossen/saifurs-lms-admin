@extends('backend.layouts.master')
@section('title')
    Create/Add Result
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
                        <h3 class="box-title">Create </h3>&nbsp;<sub class="text-danger text-sm-right"><i></i></sub>
                    </div>
                </div>
                <!-- form start -->
                <form class="horizontal-form" id="result_form" role="form" method="POST" action="{{ route('results.store') }}" enctype="multipart/form-data">
                    @csrf
                @include('backend.result.form')
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
    <!-- END CONTENT -->

@endsection

@section('scripts')
    <script>
        var selected_course_id = '{{old("course_id", (isset($result)?$result->course_id:null))}}';
        var selected_batch_id = '{{old("batch_id", (isset($result)?$result->batch_id:null))}}';
        var selected_quiz_id = '{{old("quiz_id", (isset($result)?$result->quiz_id:null))}}';
        var selected_batch_id = '{{old("quiz_id", (isset($result)?$result->batch_id:null))}}';

        $(document).ready(function() {
            $("#company_id").change(function() {
                getCourseList();
            });
            $("#course_id").change(function() {
                getBatchList();
                getQuizList();
            });
            $("#batch_id").change(function() {
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
                    company_id: {
                        required: true,
                    },
                    course_id: {
                        required: true,
                    },
                    batch_id: {
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

        function getBatchList(){
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
                            $("#batch_id").append('<option value="">Please Select Batch</option>');
                            $.each(res.data,function(key,value){
                                if(selected_batch_id == value.id){
                                    batchSelectedStatus = ' selected ';
                                }else{
                                    batchSelectedStatus = '';
                                }
                                $("#batch_id").append('<option value="'+value.id+'" '+batchSelectedStatus+'>'+value.course_batch_name+'</option>');
                            });
                        }else{
                            $("#batch_id").empty();
                            $("#batch_id").append('<option value="">Please Select Batch</option>');
                        }
                    }
                });
            }else{
                $("#batch_id").empty();
                $("#batch_id").append('<option value="">Please Select Batch</option>');
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
            var batch_id = $('#batch_id').val();
            var room = 0;
            var pickToken = '{{csrf_token()}}';
            if(company_id){
                $.ajax({
                    type:"POST",
                    dataType:'json',
                    url:'{{route('students.get-student-list')}}',
                    data:{
                        company_id : company_id,
                        batch_id : batch_id,
                        is_course_student : true,
                        '_token':pickToken
                    },
                    success:function(res){
                        if(res.status == 200){
                            $("#student_list").empty();
                            $("#student_list").html('' +
                                '<div class="col-lg-12" id="batch'+room+'">' +
                                    '<div class="row" id="batch_row'+room+'">' +
                                        '<div class="col-lg-6">' +
                                            '<div class="form-group">' +
                                                '<label for="user_id"> Student <label>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="col-lg-6">' +
                                            '<div class="form-group">' +
                                                '<label for="total_score"> Score <label>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                                '');
                            $.each(res.data,function(key,value){
                                room = key+1;
                                $("#student_list").append('' +
                                    '<div class="col-lg-12" id="batch'+room+'">' +
                                        '<div class="row" id="batch_row'+room+'">' +
                                            '<div class="col-lg-6">' +
                                                '<div class="form-group">' +
                                                    '<label for="user_id"> '+value.name+' <label>' +
                                                    '<input type="hidden" id="user_id_'+room+'" class="form-control"' +
                                                    'name="user_id_'+room+'" placeholder="Please Enter Student ID"' +
                                                    'required autofocus autocomplete="off" value="'+value.id+'" >' +
                                                '</div>' +
                                            '</div>' +
                                            '<div class="col-lg-6">' +
                                                '<div class="form-group">' +
                                                    '<input type="text" id="total_score_'+room+'" class="form-control"' +
                                                    'name="total_score_'+room+'" placeholder="Please Enter '+value.name+' Score"' +
                                                    'required autofocus autocomplete="off" value="" >' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '');
                            });
                            document.getElementById("totalRow").value=room;
                        }else{
                            $("#student_list").empty();
                            $("#student_list").html('Please Select Batch');
                        }
                    }
                });
            }else{
                $("#student_list").empty();
                $("#student_list").html('Please Select Batch');
            }
        }

    </script>
@endsection
