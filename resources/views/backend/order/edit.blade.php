@extends('backend.layouts.master')
@section('title')
    Update Order Information
@endsection


@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @section('content-header')
            <h1>
                <i class="fa fa-star" aria-hidden="true"></i>
                Order
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
                <form class="horizontal-form" id="order_form" role="form" method="POST" action="{{ route('orders.update',$order->id) }}" enctype="multipart/form-data">
                    @csrf
                    {{method_field('PUT')}}
                    @include('backend.order.form')
                </form>
                <!-- END FORM-->
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script>
        var selected_course_id = '{{old("course_id", (isset($order)?$order->course_id:null))}}';
        var selected_user_id = '{{old("user_id", (isset($order)?$order->user_id:null))}}';

                $(document).ready(function() {
                    getCourseList();
                    $("#company_id").change(function() {
                        getCourseList();
                    });

                    getUserList();
                    $("#user_id").change(function() {
                        getUserList();
                    });


                    jQuery.validator.addMethod("noSpace", function(value, element) {
                        return value.indexOf(" ") < 0 && value != "";
                    }, "No space please and don't leave it empty");

                    jQuery.validator.addMethod("alphanumeric", function(value, element) {
                        return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
                    }, "Letters and numbers only please");

                    $("#order_form").validate({
                        rules: {
                            // order_title: {
                            //     required: true,
                            //     noSpace: false,
                            // },
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

                // function getUserList(){
                //     var company_id = $('#company_id').val();
                //     var pickToken = '{{csrf_token()}}';
                //     if(company_id){
                //         $.ajax({
                //             type:"POST",
                //             dataType:'json',
                //             url:'{{route('students.get-student-list')}}',
                //             data:{
                //                 company_id : company_id,
                //                 '_token':pickToken
                //             },
                //             success:function(res){
                //                 if(res.status == 200){
                //                     $("#user_id").empty();
                //                     $("#user_id").append('<option value="">Please Select Student</option>');
                //                     $.each(res.data,function(key,value){
                //                         if(selected_user_id == value.id){
                //                             userSelectedStatus = ' selected ';
                //                         }else{
                //                             userSelectedStatus = '';
                //                         }
                //                         $("#user_id").append('<option value="'+value.id+'" '+userSelectedStatus+'>'+value.name+'</option>');
                //                     });
                //                 }else{
                //                     $("#user_id").empty();
                //                     $("#user_id").append('<option value="">Please Select Student</option>');
                //                 }
                //             }
                //         });
                //     }else{
                //         $("#user_id").empty();
                //         $("#user_id").append('<option value="">Please Select Student</option>');
                //     }
                // }

    </script>
@endsection

@section('scripts')

@endsection
