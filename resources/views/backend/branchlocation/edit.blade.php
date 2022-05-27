@extends('backend.layouts.master')
@section('title')
    Update Branch Location
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-question-circle" aria-hidden="true"></i>
        Branch Location
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
                    <form class="horizontal-form" id="branch_location_form" role="form" method="POST"
                          action="{{ route('branchlocation.update',$branchlocation->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('backend.branchlocation.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection

@push('old-scripts')
    <script>
        $(document).ready(function () {
            $("#branch_location_form").validate({
                rules: {
                    branch_name: {
                        required: true,
                    },
                    /*cover_price: {
                        min: 1,
                        number: true
                    },
                    retail_price: {
                        min: 1,
                        number: true
                    },
                    wholesale: {
                        min: 1,
                        number: true
                    }*/

                },
            });
        });
    </script>
@endpush













{{--
@extends('backend.layouts.master')
@section('title')
    Edit/Update Branch
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-building"></i>
        Branch
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
                        <h3 class="box-title">Edit</h3>
                    </div>
                    <!-- form start -->
                    <form class="horizontal-form" id="branch_form" role="form" method="POST"
                          action="{{ route('branches.update', $branch->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('backend.user.branches.form')
                    </form>
                    <!-- END FORM-->
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>
            var selected_state_id = '{{old("state_id", (isset($branch)?$branch->state_id:null))}}';
            var selected_city_id = '{{old("city_id", (isset($branch)?$branch->city_id:null))}}';
            getProvinceList();
            getCityList();
            $(document).ready(function () {
                $("#branch_logo").change(function () {
                    imageIsLoaded(this, 'branch_logo_show');
                });
                jQuery.validator.addMethod("noSpace", function (value, element) {
                    return value.indexOf(" ") < 0 && value != "";
                }, "No space please and don't leave it empty");

                jQuery.validator.addMethod("alphanumeric", function (value, element) {
                    return this.optional(element) || /^[a-zA-Z0-9]+$/i.test(value);
                }, "Letters and numbers only please");

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
                    $("#province_id").empty();
                    $("#province_id").append('<option value="">Please Select Province</option>');
                    $("#city_id").empty();
                    $("#city_id").append('<option value="">Please Select City</option>');
                }
            }

            function getCityList() {
                var country_id = $('#country_id').val();
                var state_id = $('#state_id').val() || '{{old("present_state_id", (isset($branch)?$branch->state_id:null))}}';
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
        </script>
@endsection
--}}
