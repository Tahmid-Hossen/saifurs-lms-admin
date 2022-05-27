@extends('backend.layouts.master')

@section('title')
    Create/Add Course Rating
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-user-plus"></i>
        Course Rating
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
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit/Update </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="portlet-body">
                        <form class="horizontal-form" role="form" method="POST"
                              action="{{ route('course-ratings.update', $data->id) }}" id="course_rating_form">
                            @csrf
                            @method('PUT')
                            @include('backend.course.course-ratings.form')
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
            </div>

        </div>
    </div>
    <!-- END CONTENT -->
@endsection
@push('scripts')
    <script>
        let selected_branch_id = "{{ old('branch_id', isset($data) ? $data->branch_id : null) }}";
        let selected_course_id = "{{ old('course_id', isset($data) ? $data->course_id : null) }}";
        $(document).ready(function () {
            getBranchList();
            $("#company_id").change(function () {
                getBranchList();
                getCourseList();
            });

            jQuery.validator.addMethod("noSpace", function (value, element) {
                return value.indexOf(" ") < 0 && value != "";
            }, "No space please and don't leave it empty");

            jQuery.validator.addMethod("alphanumeric", function (value, element) {
                return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
            }, "Letters and numbers only please");


            $("#course_rating_form").validate({
                rules: {
                    course_rating_stars: {
                        required: true,
                        digits: true,
                        max: 5,
                        min: 0,
                        step: 1
                    },
                    course_id: {
                        required: true
                    },
                    company_id: {
                        required: true
                    }
                }
            });
        });

        function getBranchList() {
            let company_id = $('#company_id').val();
            let pickToken = '{{ csrf_token() }}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "{{ route('branches.get-branch-list') }}",
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
                                $("#branch_id").append('<option value="' + value.id + '" ' +
                                    branchSelectedStatus + '>' + value.branch_name + '</option>');
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
            let company_id = $('#company_id').val();
            let pickToken = '{{ csrf_token() }}';
            if (company_id) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "{{ route('course-listview.get') }}",
                    data: {
                        company_id: company_id,
                        '_token': pickToken
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
                                $("#course_id").append('<option value="' + value.id + '" ' +
                                    courseSelectedStatus + '>' + value.course_title + '</option>');
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
    </script>
@endpush
