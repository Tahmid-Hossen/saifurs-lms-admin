@extends('backend.layouts.master')
@section('title')
    Create/Add Student
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-user-secret"></i>
        Student
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
                        <h3 class="box-title">Create </h3>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="student_form" role="form" method="POST"
                          action="{{ route('students.store') }}" enctype="multipart/form-data">
                        @csrf
                        @include('backend.user.students.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    </div>
    {{--        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
            <script>
                var selected_state_id = '{{old("state_id", (isset($userDetails)?$userDetails->state_id:null))}}';
                var selected_city_id = '{{old("city_id", (isset($userDetails)?$userDetails->city_id:null))}}';
                var selected_branch_id = '{{old("branch_id", (isset($userDetails)?$userDetails->branch_id:null))}}';
                getProvinceList();
                getCityList();

                function findUserName() {
                    $('#usernamespan').html(
                        '<i class="fa fa-spinner fa-spin"></i> Please Wait Few Second....'
                    );
                    var username = $('#username').val() || '';
                    var pickToken = '{{csrf_token()}}';
                    if (username != '') {
                        $.ajax({
                            type: "POST",
                            url: '{{route('users.find-user-name')}}',
                            dataType: 'json',
                            data: {
                                'username': username,
                                '_token': pickToken
                            },
                            success: function (data) {
                                if (data['countUser'] > 0) {
                                    $('#usernamespan').html('<span class="bg-red-active color-palette">Username already have, please provide another username!</span>');
                                } else {
                                    $('#usernamespan').html('<span class="bg-green-active color-palette">Username available.</span>');
                                }
                            }
                        });
                    } else {
                        $('#usernamespan').html('<span class="bg-red-active color-palette">Please provide User ID!</span>');
                    }
                }

                function findSponsor() {
                    $('#sponsorspan').html(
                        '<i class="fa fa-spinner fa-spin"></i> Please Wait Few Second....'
                    );
                    var username = $('#sponsro_username').val() || '';
                    var pickToken = '{{csrf_token()}}';
                    if (username != '') {
                        $.ajax({
                            type: "POST",
                            url: '{{route('users.find-user-name')}}',
                            dataType: 'json',
                            data: {
                                'username': username,
                                '_token': pickToken
                            },
                            success: function (data) {
                                if (data['findUser'] != null) {
                                    $('#sponsor_id').val(data['findUser']['id']);
                                } else {
                                    $('#sponsor_id').val('');
                                }
                                if (data['countUser'] > 0) {
                                    $('#sponsorspan').html('<span class="bg-green-active color-palette">Sponsor available.</span>');
                                } else {
                                    $('#sponsorspan').html('<span class="bg-red-active color-palette">Invalid Sponsor ID!</span>');
                                }
                            }
                        });
                    } else {
                        $('#sponsor_id').val('');
                        $('#sponsorspan').html('<span class="bg-red-active color-palette">Please provide Sponsor ID!</span>');
                    }
                }

                function findEmail() {
                    $('#email').html(
                        '<i class="fa fa-spinner fa-spin"></i> Please Wait Few Second....'
                    );
                    var email = $('#email').val() || '';
                    var pickToken = '{{csrf_token()}}';
                    if (email != '') {
                        $.ajax({
                            type: "POST",
                            url: '{{route('users.findHaveEmail')}}',
                            dataType: 'json',
                            data: {
                                'email': email,
                                '_token': pickToken
                            },
                            success: function (data) {
                                if (data['countUser'] > 0) {
                                    $('#emailspan').html('<span class="bg-red-active color-palette">Username already have, please provide another username!</span>');
                                } else {
                                    $('#emailspan').html('<span class="bg-green-active color-palette">Username available.</span>');
                                }
                            }
                        });
                    } else {
                        $('#emailspan').html('<span class="bg-red-active color-palette">Please provide User email!</span>');
                    }
                }

                $(document).ready(function () {
                    $("#user_detail_photo").change(function () {
                        imageIsLoaded(this, 'user_detail_photo_show');
                    });
                    getBranchList();
                    $("#company_id").change(function () {
                        getBranchList();
                    });
                    jQuery.validator.addMethod("noSpace", function (value, element) {
                        return value.indexOf(" ") < 0 && value != "";
                    }, "No space please and don't leave it empty");

                    jQuery.validator.addMethod("alphanumeric", function (value, element) {
                        return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
                    }, "Letters and numbers only please");

                    $("#student_form").validate({
                        rules: {
                            username: {
                                required: true,
                                noSpace: true,
                                alphanumeric: true
                            },
                            password: {
                                required: true,
                                equalTo: "#confirm_password"
                            },
                            confirm_password: {
                                required: true,
                                equalTo: "#password"
                            },
                            email: {
                                required: true,
                                email: true
                            },
                            /*sponsor_id: {
                                required: true
                            },*/
                            company_id: {
                                required: true
                            },
                            branch_id: {
                                required: true
                            },
                            national_id: {
                                required: true
                            },
                            date_of_birth: {
                                required: true
                            },
                            mailing_address: {
                                required: true
                            },
                            police_station: {
                                required: true
                            },
                            city_id: {
                                required: true
                            },
                            state_id: {
                                required: true
                            },
                            country_id: {
                                required: true
                            },
                            mobile_phone: {
                                required: true,
                                digits: true,
                                minlength: 11,
                                maxlength: 11
                            },
                            home_phone: {
                                digits: true,
                                minlength: 9,
                                maxlength: 11
                            },
                            user_detail_photo: {
                                required: true,
                                extension: "jpg|jpeg|png|ico|bmp|svg"
                            }
                        }
                    });
                });

                function getProvinceList() {
                    var country_id = $('#country_id').val();
                    var pickToken = '{{csrf_token()}}';
                    if (country_id) {
                        $.ajax({
                            type: "POST",
                            dataType: 'json',
                            url: '{{route('states.get-state-list')}}',
                            data: {
                                country_id: country_id,
                                '_token': pickToken
                            },
                            success: function (res) {
                                if (res.status == 200) {
                                    $("#state_id").empty();
                                    $("#state_id").append('<option value="">Please Select state</option>');
                                    $.each(res.data, function (key, value) {
                                        if (selected_state_id == value.id) {
                                            stateSelectedStatus = ' selected ';
                                        } else {
                                            stateSelectedStatus = '';
                                        }
                                        $("#state_id").append('<option value="' + value.id + '" ' + stateSelectedStatus + '>' + value.state_name + '</option>');
                                    });
                                } else {
                                    $("#state_id").empty();
                                    $("#state_id").append('<option value="">Please Select state</option>');
                                    $("#city_id").empty();
                                    $("#city_id").append('<option value="">Please Select City</option>');
                                }
                            }
                        });
                    } else {
                        $("#state_id").empty();
                        $("#state_id").append('<option value="">Please Select Province</option>');
                        $("#city_id").empty();
                        $("#city_id").append('<option value="">Please Select City</option>');
                    }
                }

                function getCityList() {
                    var country_id = $('#country_id').val();
                    var state_id = $('#state_id').val() || '{{old("present_state_id", (isset($userDetails)?$userDetails->state_id:null))}}';
                    var pickToken = '{{csrf_token()}}';
                    if (state_id || country_id) {
                        $.ajax({
                            type: "POST",
                            dataType: 'json',
                            url: '{{route('cities.get-city-list')}}',
                            data: {
                                country_id: country_id,
                                state_id: state_id,
                                '_token': pickToken
                            },
                            success: function (res) {
                                if (res.status == 200) {
                                    $("#city_id").empty();
                                    $("#city_id").append('<option value="">Please Select City</option>');
                                    $.each(res.data, function (key, value) {
                                        if (selected_city_id == value.id) {
                                            citySelectedStatus = ' selected ';
                                        } else {
                                            citySelectedStatus = '';
                                        }
                                        $("#city_id").append('<option value="' + value.id + '" ' + citySelectedStatus + '>' + value.city_name + '</option>');
                                    });
                                } else {
                                    $("#city_id").empty();
                                    $("#city_id").append('<option value="">Please Select City</option>');
                                }
                            }
                        });
                    } else {
                        $("#city_id").empty();
                        $("#city_id").append('<option value="">Please Select City</option>');
                    }
                }

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
            </script>--}}
@endsection
