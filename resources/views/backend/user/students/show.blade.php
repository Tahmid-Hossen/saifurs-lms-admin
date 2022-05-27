@extends('backend.layouts.master')
@section('title')
    Detail/Show Student
@endsection


@section('content')
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        @section('content-header')
            <h1>
                <i class="fa fa-building"></i>
                Student
                <small>Control Panel</small>
            </h1>
            {!! Breadcrumbs::render(Route::getCurrentRoute()->getName()) !!}
        @endsection
        @include('backend.layouts.flash')
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail</h3>
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                {!!
                                    \CHTML::actionButton(
                                        $reportTitle='..',
                                        $routeLink='#',
                                        $student->id,
                                        $selectButton=['backButton','editButton'],
                                        $class = ' btn-icon btn-circle ',
                                        $onlyIcon='no',
                                        $othersPram=array()
                                    )
                                !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#credentials" data-toggle="tab">Credentials</a></li>
                        <li><a href="#details" data-toggle="tab">Details</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="credentials">
                            <div class="panel-heading">Credentials</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="control-label">Name</label><br>
                                                    {{isset($student) ? $student->user->name: null}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="username" class="control-label">Username</label><br>
                                                    {{isset($student) ? $student->user->username: null}}
                                                </div>
                                                <span id="usernamespan"></span>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email" class="control-label">Email</label><br>
                                                    {{isset($student) ? $student->user->email:null}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="status" class="control-label">Status</label><br>
                                                    {{isset($student) ? $student->user->status:null}}
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="role" class="control-label">Assign Role(s)</label><br>
                                                {{isset($student) ? $student->user->roles[0]->name:null}}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="details">
                            <div class="panel-heading">Details</div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="company_id">Company</label><br>
                                                    {{isset($student->company) ? $student->company->company_name:null}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="branch_id">Branch</label><br>
                                                    {{isset($student->branch) ? $student->branch->branch_name:null}}
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="first_name">First Name</label><br>
                                                    {{isset($student) ? $student->first_name:null}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="last_name">Last Name</label><br>
                                                    {{isset($student) ? $student->last_name:null}}
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Verified</label> <br/>
                                                    {{isset($student) ? ($student->user_details_verified):null}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="identity_card">Organization Card</label><br>
                                                    {{isset($student) ? $student->identity_card:null}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="date_of_birth">Date of birth</label><br>
                                                    {{isset($student) ? $student->date_of_birth:null}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="date_of_enrollment">Date of Enrollment</label><br>
                                                    {{isset($student) ? $student->date_of_enrollment:null}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Gender</label><br>
                                                    {{isset($student) ? strtoupper($student->gender):null}}
                                                </div>
                                            </div>
                                            {{--<div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="married_status">Married Status</label><br>
                                                    {{isset($student) ? strtoupper($student->married_status):null}}
                                                </div>
                                            </div>--}}
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mobile_phone">Mobile Phone</label><br>
                                                    {{isset($student) ? $student->mobile_phone:null}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="home_phone">Home Phone</label><br>
                                                    {{isset($student) ? $student->home_phone:null}}
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>Mailing Address Details: </h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="mailing_address">Mailing Address</label><br>
                                                    {{isset($student) ? $student->mailing_address:null}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="hidden" name="country_id" id="country_id" value="18">
                                                <div class="form-group">
                                                    <label for="state_id">Division</label><br>
                                                    {{isset($student) ? $student->state->state_name:null}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="city_id">City</label><br>
                                                    {{isset($student) ? $student->city->city_name:null}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="post_code">Post Code</label><br>
                                                    {{isset($student) ? $student->post_code:null}}
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4>Shipping Address Details: </h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="shipping_address">Shipping Address</label><br>
                                                    {{isset($student->shipping_address) ? $student->shipping_address:'N/A'}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="hidden" name="country_id" id="country_id" value="18">
                                                <div class="form-group">
                                                    <label for="shipping_state_id">Division</label><br>
                                                    {{isset($student->ship_state) ? $student->ship_state->state_name:'N/A'}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="shipping_city_id">City</label><br>
                                                    {{isset($student->ship_city) ? $student->ship_city->city_name:'N/A'}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="shipping_post_code">Post Code</label><br>
                                                    {{isset($student->shipping_post_code) ? $student->shipping_post_code:'N/A'}}
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                        {{-- <div class="row"> --}}
                                            {{--<div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="police_station">Police Station</label><br>
                                                    {{isset($student) ? $student->police_station:null}}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="national_id">National ID</label><br>
                                                    {{isset($student) ? $student->national_id:null}}
                                                </div>
                                            </div>--}}
                                        {{-- </div> --}}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <img
                                                    id="user_detail_photo_show"
                                                    src="{{isset($student->user_detail_photo)?URL::to($student->user_detail_photo):config('app.default_image')}}"
                                                    width="{{\Utility::$userPhotoSize['width']}}"
                                                    height="{{\Utility::$userPhotoSize['height']}}"
                                                >
                                            </div>
                                        </div>
                                    </div>

                                </div> <!-- end row -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
@endsection
