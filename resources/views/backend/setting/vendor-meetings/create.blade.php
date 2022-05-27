@extends('backend.layouts.master')
@section('title')
    Create/Add Vendor Meeting
@endsection


@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @section('content-header')
            <h1>
                <i class="fa fa-building"></i>
                Vendor Meeting
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
                    <form class="horizontal-form" id="vendor_meeting_form" role="form" method="POST" action="{{ route('vendor-meetings.store') }}" enctype="multipart/form-data">
                       @csrf
                        @include('backend.setting.vendor-meetings.form')
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
        var selected_branch_id = '{{old("branch_id", (isset($vendorMeeting)?$vendorMeeting->branch_id:null))}}';
        var selected_course_id = '{{old("course_id", (isset($vendorMeeting)?$vendorMeeting->course_id:null))}}';
        var selected_course_batch_id = '{{old("course_chapter_id", (isset($vendorMeeting)?$vendorMeeting->course_chapter_id:null))}}';
        var selected_course_chapter_id = '{{old("course_chapter_id", (isset($vendorMeeting)?$vendorMeeting->course_chapter_id:null))}}';
        var selected_instructor_id = '{{old("course_batch_id", (isset($vendorMeeting)?$vendorMeeting->course_batch_id:null))}}';
        $(document).ready(function() {
            getBranchList();
            getCourseList();
            getCourseBatchList();
            getCourseChapterList();
            getTeacherList();
            $("#company_id").change(function() {
                getBranchList();
                getCourseList();
                getCourseBatchList();
                getCourseChapterList();
                getTeacherList();
            });
            $("#branch_id").change(function() {
                getCourseList();
                getCourseBatchList();
                getCourseChapterList();
                getTeacherList();
            });
            $("#course_id").change(function() {
                getCourseBatchList();
                getCourseChapterList();
                getTeacherList();
            });
            $("#vendor_meeting_logo").change(function () {
                imageIsLoaded(this, 'vendor_meeting_logo_show');
            });
            jQuery.validator.addMethod("noSpace", function(value, element) {
                return value.indexOf(" ") < 0 && value != "";
            }, "No space please and don't leave it empty");

            jQuery.validator.addMethod("alphanumeric", function(value, element) {
                return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
            }, "Letters and numbers only please");

            $("#vendor_meeting_form").validate({
                rules: {
                    company_id: {
                        required: true
                    },
                    vendor_id: {
                        required: true
                    },
                    vendor_meeting_name: {
                        required: true
                    },
                    vendor_meeting_agenda: {
                        required: true,
                        minlength:200
                    },
                    vendor_meeting_url: {
                        required: true,
                        url: true
                    },
                    vendor_meeting_logo: {
                        required: true,
                        extension: "jpg|jpeg|png|ico|bmp|svg"
                    }
                }
            });
        });

        function getBranchList(){
            var company_id = $('#company_id').val();
            var pickToken = '{{csrf_token()}}';
            if(company_id){
                $.ajax({
                    type:"POST",
                    dataType:'json',
                    url:'{{route('branches.get-branch-list')}}',
                    data:{
                        company_id : company_id,
                        '_token':pickToken
                    },
                    success:function(res){
                        if(res.status == 200){
                            $("#branch_id").empty();
                            $("#branch_id").append('<option value="">Please Select Branch</option>');
                            $.each(res.data,function(key,value){
                                if(selected_branch_id == value.id){
                                    branchSelectedStatus = ' selected ';
                                }else{
                                    branchSelectedStatus = '';
                                }
                                $("#branch_id").append('<option value="'+value.id+'" '+branchSelectedStatus+'>'+value.branch_name+'</option>');
                            });
                        }else{
                            $("#branch_id").empty();
                            $("#branch_id").append('<option value="">Please Select Branch</option>');
                        }
                    }
                });
            }else{
                $("#branch_id").empty();
                $("#branch_id").append('<option value="">Please Select Branch</option>');
            }
        }
        function getCourseList(){
            var company_id = $('#company_id').val();
            var branch_id = $('#branch_id').val() || '';
            var pickToken = '{{csrf_token()}}';
            if(company_id){
                $.ajax({
                    type:"POST",
                    dataType:'json',
                    url:'{{route('course.get-course-list')}}',
                    data:{
                        company_id : company_id,
                        branch_id : branch_id,
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
            var company_id = $('#company_id').val();
            var branch_id = $('#branch_id').val() || '';
            var course_id = $('#course_id').val() || '';
            var pickToken = '{{csrf_token()}}';
            if(company_id){
                $.ajax({
                    type:"POST",
                    dataType:'json',
                    url:'{{route('course-batches.get-course-batch-list')}}',
                    data:{
                        company_id : company_id,
                        branch_id : branch_id,
                        course_id : course_id,
                        '_token':pickToken
                    },
                    success:function(res){
                        if(res.status == 200){
                            $("#course_batch_id").empty();
                            $("#course_batch_id").append('<option value="">Please Select Course Batch</option>');
                            $.each(res.data,function(key,value){
                                if(selected_course_batch_id == value.id){
                                    courseBatchSelectedStatus = ' selected ';
                                }else{
                                    courseBatchSelectedStatus = '';
                                }
                                $("#course_batch_id").append('<option value="'+value.id+'" '+courseBatchSelectedStatus+'>'+value.course_batch_name+'</option>');
                            });
                        }else{
                            $("#course_batch_id").empty();
                            $("#course_batch_id").append('<option value="">Please Select Course Batch</option>');
                        }
                    }
                });
            }else{
                $("#course_batch_id").empty();
                $("#course_batch_id").append('<option value="">Please Select Course Batch</option>');
            }
        }
        function getCourseChapterList(){
            var company_id = $('#company_id').val();
            var branch_id = $('#branch_id').val() || '';
            var course_id = $('#course_id').val() || '';
            var pickToken = '{{csrf_token()}}';
            if(company_id){
                $.ajax({
                    type:"POST",
                    dataType:'json',
                    url:'{{route('course.get-course-chapter-list')}}',
                    data:{
                        company_id : company_id,
                        branch_id : branch_id,
                        course_id : course_id,
                        '_token':pickToken
                    },
                    success:function(res){
                        if(res.status == 200){
                            $("#course_chapter_id").empty();
                            $("#course_chapter_id").append('<option value="">Please Select Course Chapter</option>');
                            $.each(res.data,function(key,value){
                                if(selected_course_chapter_id == value.id){
                                    courseChapterSelectedStatus = ' selected ';
                                }else{
                                    courseChapterSelectedStatus = '';
                                }
                                $("#course_chapter_id").append('<option value="'+value.id+'" '+courseChapterSelectedStatus+'>'+value.chapter_title+'</option>');
                            });
                        }else{
                            $("#course_chapter_id").empty();
                            $("#course_chapter_id").append('<option value="">Please Select Course Chapter</option>');
                        }
                    }
                });
            }else{
                $("#course_chapter_id").empty();
                $("#course_chapter_id").append('<option value="">Please Select Course Chapter</option>');
            }
        }
        function getTeacherList(){
            var company_id = $('#company_id').val();
            var branch_id = $('#branch_id').val() || '';
            var course_id = $('#course_id').val() || '';
            var is_course_instructor = true;
            var pickToken = '{{csrf_token()}}';
            if(company_id){
                $.ajax({
                    type:"POST",
                    dataType:'json',
                    url:'{{route('teachers.get-teacher-list')}}',
                    data:{
                        company_id : company_id,
                        branch_id : branch_id,
                        course_id : course_id,
                        is_course_instructor : is_course_instructor,
                        '_token':pickToken
                    },
                    success:function(res){
                        if(res.status == 200){
                            $("#instructor_id").empty();
                            $("#instructor_id").append('<option value="">Please Select Instructor</option>');
                            $.each(res.data,function(key,value){
                                if(selected_instructor_id == value.user_id){
                                    instructorSelectedStatus = ' selected ';
                                }else{
                                    instructorSelectedStatus = '';
                                }
                                $("#instructor_id").append('<option value="'+value.user_id+'" '+instructorSelectedStatus+'>'+value.first_name+' '+value.last_name+' ('+value.mobile_phone+')'+'</option>');
                            });
                        }else{
                            $("#instructor_id").empty();
                            $("#instructor_id").append('<option value="">Please Select Instructor</option>');
                        }
                    }
                });
            }else{
                $("#instructor_id").empty();
                $("#instructor_id").append('<option value="">Please Select Instructor</option>');
            }
        }
    </script>
@endpush
