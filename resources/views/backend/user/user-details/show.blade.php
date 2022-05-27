@extends('backend.layouts.master')
@section('title')
    Detail/Show User Detail
@endsection

@section('content-header')
    <h1>
        <i class="fa fa-building"></i>
        User Detail
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
                        <h3 class="box-title">Detail</h3>
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                {!!
                                    \CHTML::actionButton(
                                        $reportTitle='..',
                                        $routeLink='#',
                                        $userDetails->id,
                                        $selectButton=['backButton','editButton'],
                                        $class = ' btn-icon btn-circle ',
                                        $onlyIcon='no',
                                        $othersPram=array()
                                    )
                                !!}
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
                                                        {{isset($userDetails) ? $userDetails->user->name: null}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="username" class="control-label">Username</label><br>
                                                        {{isset($userDetails) ? $userDetails->user->username: null}}
                                                    </div>
                                                    <span id="usernamespan"></span>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email" class="control-label">Email</label><br>
                                                        {{isset($userDetails) ? $userDetails->user->email:null}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="status" class="control-label">Status</label><br>
                                                        {{isset($userDetails) ? $userDetails->user->status:null}}
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="role" class="control-label">Assign Role(s)</label><br>
                                                    {{isset($userDetails) ? $userDetails->user->roles[0]->name:null}}
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
                                                        {{isset($userDetails->company) ? $userDetails->company->company_name:null}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="branch_id">Branch</label><br>
                                                        {{isset($userDetails->branch) ? $userDetails->branch->branch_name:null}}
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="first_name">First Name</label><br>
                                                        {{isset($userDetails) ? $userDetails->first_name:null}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="last_name">Last Name</label><br>
                                                        {{isset($userDetails) ? $userDetails->last_name:null}}
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
                                                        {{isset($userDetails) ? $userDetails->identity_card:null}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="date_of_birth">Date of birth</label><br>
                                                        {{isset($userDetails) ? $userDetails->date_of_birth:null}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="date_of_enrollment">Date of Enrollment</label><br>
                                                        {{isset($userDetails) ? $userDetails->date_of_enrollment:null}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Gender</label><br>
                                                        {{isset($userDetails) ? strtoupper($userDetails->gender):null}}
                                                    </div>
                                                </div>
                                                {{--<div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="married_status">Married Status</label><br>
                                                        {{isset($userDetails) ? strtoupper($userDetails->married_status):null}}
                                                    </div>
                                                </div>--}}
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="mobile_phone">Mobile Phone</label><br>
                                                        {{isset($userDetails) ? $userDetails->mobile_phone:null}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="home_phone">Home Phone</label><br>
                                                        {{isset($userDetails) ? $userDetails->home_phone:null}}
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
                                                        {{isset($userDetails) ? $userDetails->mailing_address:null}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="hidden" name="country_id" id="country_id" value="18">
                                                    <div class="form-group">
                                                        <label for="state_id">Division</label><br>
                                                        {{isset($userDetails) ? $userDetails->state->state_name:null}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="city_id">City</label><br>
                                                        {{isset($userDetails) ? $userDetails->city->city_name:null}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="post_code">Post Code</label><br>
                                                        {{isset($userDetails) ? $userDetails->post_code:null}}
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
                                                        <label for="mailing_address">Shipping Address</label><br>
                                                        {{isset($userDetails->shipping_address) ? $userDetails->shipping_address:'N/A'}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="hidden" name="country_id" id="country_id" value="18">
                                                    <div class="form-group">
                                                        <label for="shipping_state_id">Division</label><br>
                                                        {{isset($userDetails->ship_state) ? $userDetails->ship_state->state_name:'N/A'}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="shipping_city_id">City</label><br>
                                                        {{isset($userDetails->ship_city) ? $userDetails->ship_city->city_name:'N/A'}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="shipping_post_code">Post Code</label><br>
                                                        {{isset($userDetails->shipping_address) ? $userDetails->shipping_post_code:'N/A'}}
                                                    </div>
                                                </div>
                                            </div> <!-- end row -->
                                            {{-- <div class="row"> --}}
                                                {{--<div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="police_station">Police Station</label><br>
                                                        {{isset($userDetails) ? $userDetails->police_station:null}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="national_id">National ID</label><br>
                                                        {{isset($userDetails) ? $userDetails->national_id:null}}
                                                    </div>
                                                </div>--}}
                                            {{-- </div> --}}
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <img
                                                        id="user_detail_photo_show"
                                                        src="{{isset($userDetails->user_detail_photo)?URL::to($userDetails->user_detail_photo):config('app.default_image')}}"
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
    </div>
    <!-- END CONTENT -->
@endsection
