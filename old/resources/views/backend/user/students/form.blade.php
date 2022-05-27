@include('backend.layouts.partials.errors')
<div class="box-body">
    <h3>User Credentials</h3>
    <section>
        <div class="row">
            @if(isset($student))
                <input type="hidden" id="user_id" value="{{isset($student) ? $student->user->id: null}}">
                <input type="hidden" name="student_id" value="{{isset($student) ? $student->user->id: null}}">
            @endif
            <div class="col-md-6">
                {!! \Form::nText('username', 'Username (Unique Identifier)', old('username', isset($student) ? $student->user->username: null) , true) !!}
            </div>
            <div class="col-md-6">
                {!! \Form::nEmail('email', 'Email Address',
old('name', isset($student) ? $student->user->email: null) , true) !!}
            </div>
        </div>
        @if(empty($student))
        <div class="row">
            <div class="col-md-6">
                {!! \Form::nPassword('password', 'Password', (isset($student) ? '' : '123456') , empty($student)) !!}
                <span class="help-block">
                    {{isset($student) ? 'Left it blank if you do not want to change!!!':'By default: 123456;'}}
                </span>
            </div>
            <div class="col-md-6">
                {!! \Form::nPassword('confirm_password', 'ReType Password', (isset($student) ? '' : '123456') , empty($student)) !!}
                <span class="help-block">
                    {{isset($student) ? 'Left it blank if you do not want to change!!!':'By default: 123456;'}}
                </span>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="form-group @error('roles.*') has-error @enderror">
                    {!! \Form::nLabel('role', 'Assign Role(s)', true) !!}
                    <select class="form-control custom-select" id="role" name="roles[]">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" label="{{ $role->name }}"
                                    @if(isset($userRoles))
                                    @foreach($userRoles as $userRole)
                                    @if($role->id == $userRole) selected @endif
                                    @endforeach
                                    @elseif(!empty(old('roles')))
                                    @foreach(old('roles') as $r)
                                    @if($role->id == $r) selected @endif
                                @endforeach
                                @endif
                            >
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    <span id="roles-error" class="d-block text-danger help-block">
                    @error('roles.*')
                        {{ $message }}
                        @enderror
                </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    {!! \Form::nLabel('status', 'Status') !!}
                    <select name="status" id="status" class="form-control">
                        @foreach(\App\Support\Configs\Constants::$user_status as $status)
                            <option value="{{$status}}"
                                    @if (isset($student) && ($student->user->status === $status)) selected @endif
                            >{{$status}}</option>
                        @endforeach
                    </select>
                    <span id="status-error" class="d-block text-danger help-block">
                    @error('status')
                        {{ $message }}
                        @enderror
                </span>
                </div>
            </div>
        </div>
    </section>
    <h3>Profile Details</h3>
    <section>
        <div class="row">
            @if(auth()->user()->userDetails->company_id == 1)
                <div class="col-md-6">
                    {!! \Form::nSelect('company_id', 'Company', $global_companies, isset($student) ? $student->company_id:null, true,
        [ 'class' => 'form-control custom-select']) !!}
                </div>
            @else
                <input type="hidden" name="company_id" id="company_id"
                       value="{{auth()->user()->userDetails->company_id}}">
            @endif
            <div class="col-md-6">
                {!! \Form::nSelect('branch_id', 'Branch', [], null, false, ['placeholder' => 'Please Select Branch First']) !!}
            </div>
        </div> <!-- end row -->
        <div class="row">
            <div class="col-md-6">
                {!! \Form::nText('first_name', 'First Name', isset($student) ? $student->first_name:null, true) !!}
            </div>
            <div class="col-md-6">
                {!! \Form::nText('last_name', 'Last Name', isset($student) ? $student->last_name:null, true) !!}
            </div>
        </div> <!-- end row -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group @error('gender') has-error @enderror">
                    {!! \Form::nLabel('gender', 'Gender', true) !!}
                    <br/>
                    <label class="radio-inline">
                        <input type="radio" name="gender" id="genderMale" value="male"
                               @if(old('gender', isset($student) ? $student->gender:null) == 'male') checked @endif
                        >
                        Male
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" id="genderFemale" value="female"
                               @if(old('gender', isset($student) ? $student->gender:null) == 'female') checked @endif
                        >
                        Female
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" id="genderOther" value="other"
                               @if(old('gender', isset($student) ? $student->gender:null) == 'other') checked @endif
                        >
                        Other
                    </label>
                    <span id="gender-error" class="d-block text-danger help-block">
                    @error('gender')
                        {{ $message }}
                        @enderror
                </span>
                </div>
            </div>
            <div class="col-md-6">
                {!! \Form::nText('identity_card', 'Organization Card',
                isset($student) ? $student->identity_card:null, false,
                 ['placeholder' => 'Enter Org. ID Card Number']) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! \Form::nDate('date_of_birth', 'Date of Birth',
 isset($student) ? $student->date_of_birth:null, true,
  ['readonly' => 'readonly', 'placeholder' => 'Enter Birth Date', 'class' => 'form-control date_of_birth']) !!}
            </div>
            <div class="col-md-6">
                {!! \Form::nDate('date_of_enrollment', 'Date of Enrollment',
isset($student) ? $student->date_of_enrollment:null, true,
['readonly' => 'readonly', 'placeholder' => 'Date of Enrollment', 'class' => 'form-control input-date']) !!}
            </div>
        </div>
        <div class="row">
            {{--<div class="col-md-6">
                {!! \Form::nText('national_id', 'National ID', isset($student) ? $student->national_id:null, false) !!}
            </div>--}}
            {{--<div class="col-md-6">
                <div class="form-group">
                    {!! \Form::nLabel('married_status', 'Married Status', true) !!}
                    <select name="married_status" id="married_status" class="form-control" required>
                        <option value="">Select Married Status</option>
                        @foreach(\Utility::$marriedStatus as $key=>$marriedStatus)
                            <option value="{{ $key }}"
                                    @if(old('married_status', isset($student) ? $student->married_status:null) == $key) selected @endif
                            >{{ $marriedStatus }}</option>
                        @endforeach
                    </select>
                    <span id="married_status-error" class="d-block text-danger help-block">
                    @error('married_status')
                        {{ $message }}
                        @enderror
                </span>
                </div>
            </div>--}}
        </div>
    </section>
    <h3>Contact Information</h3>
    <section>
        <div class="row">
            <div class="col-md-6">
                {!! \Form::nTel('mobile_phone', 'Mobile Phone',
old('mobile_phone', isset($student) ? $student->mobile_phone: null) , true) !!}
            </div>
            <div class="col-md-6">
                {!! \Form::nTel('home_phone', 'Home Phone',
old('home_phone', isset($student) ? $student->home_phone: null) , false) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Mailing Address Details: </h4>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! \Form::nTextarea('mailing_address', 'Mailing Address',
                    isset($student) ? $student->mailing_address:null, true, ['rows' => 2]) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <input type="hidden" name="country_id" id="country_id" value="18">
                <div class="form-group">
                    {!! \Form::nLabel('state_id', 'State', true) !!}
                    <select name="state_id" id="state_id" class="form-control custom-select"
                            required>
                        <option value="">Select State</option>
                    </select>
                    <span id="state_id-error" class="d-block text-danger help-block">
                    @error('state_id')
                        {{ $message }}
                        @enderror
                </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! \Form::nLabel('city_id', 'City', true) !!}
                    <select name="city_id" id="city_id" class="form-control custom-select" required>
                        <option value="">Select City</option>
                    </select>
                    <span id="city_id-error" class="d-block text-danger help-block">
                    @error('city_id')
                        {{ $message }}
                        @enderror
                </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! \Form::nLabel('post_code', 'Post Code') !!}
                    <input
                        type="text"
                        class="form-control"
                        name="post_code"
                        id="post_code"
                        placeholder="Enter post code"
                        value="{{ old('post_code', isset($student) ? $student->post_code:null) }}"
                    >
                    <span id="post_code-error" class="d-block text-danger help-block">
                    @error('post_code')
                        {{ $message }}
                        @enderror
                </span>
                </div>
            </div>
        </div>
        {{-- Mailing address end --}}
        <br>
        {{-- Shipping Address start --}}
        <div class="row">
            <div class="col-md-12">
                <h4>Shipping Address Details: </h4>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {!! \Form::nTextarea('shipping_address', 'Shipping Address',
                    isset($student) ? $student->shipping_address:null, false, ['rows' => 2]) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <input type="hidden" name="country_id" id="country_id" value="18">
                <div class="form-group">
                    {!! \Form::nLabel('shipping_state_id', 'State', false) !!}
                    <select name="shipping_state_id" id="shipping_state_id" class="form-control custom-select"
                            required>
                        <option value="">Select State</option>
                    </select>
                    <span id="shipping_state_id-error" class="d-block text-danger help-block">
                    @error('shipping_state_id')
                        {{ $message }}
                        @enderror
                </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! \Form::nLabel('shipping_city_id', 'City', false) !!}
                    <select name="shipping_city_id" id="shipping_city_id" class="form-control custom-select" required>
                        <option value="">Select City</option>
                    </select>
                    <span id="shipping_city_id-error" class="d-block text-danger help-block">
                    @error('shipping_city_id')
                        {{ $message }}
                        @enderror
                </span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    {!! \Form::nLabel('shipping_post_code', 'Post Code') !!}
                    <input
                        type="text"
                        class="form-control"
                        name="shipping_post_code"
                        id="shipping_post_code"
                        placeholder="Enter post code"
                        value="{{ old('shipping_post_code', isset($student) ? $student->shipping_post_code:null) }}"
                    >
                    <span id="shipping_post_code-error" class="d-block text-danger help-block">
                    @error('shipping_post_code')
                        {{ $message }}
                        @enderror
                </span>
                </div>
            </div>
        </div>
        {{-- Shipping address end --}}
    </section>
    <h3>User Photo</h3>
    <section>
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! \Form::nLabel('user_detail_photo', 'Profile Photo', true) !!}
                            <input
                                type="file" onchange="imageIsLoaded(this, 'user_detail_photo_show')"
                                class="form-control" name="user_detail_photo" id="user_detail_photo"
                                placeholder="Enter User Photo"
                                value="{{ old('user_detail_photo', isset($student) ? $student->user_detail_photo:null) }}"
                            >
                            <span id="user_detail_photo-error" class="d-block text-danger help-block">
                    @error('user_detail_photo')
                                {{ $message }}
                                @enderror
                </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! \Form::nLabel('user_details_verified', 'Account Verified?', true) !!}
                            <br/>
                            <label class="radio-inline">
                                <input type="radio" name="user_details_verified"
                                       id="userDetailsVerifiedEnable" value="{{\App\Support\Configs\Constants::$user_active_status}}"
                                       @if(old('user_details_verified', isset($student) ? ($student->user_details_verified):null) == \App\Support\Configs\Constants::$user_active_status) checked @endif
                                >
                                Yes
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="user_details_verified"
                                       id="userDetailsVerifiedDisable" value="{{\App\Support\Configs\Constants::$user_default_status}}"
                                       @if(old('user_details_verified', isset($student) ? ($student->user_details_verified):null) == \App\Support\Configs\Constants::$user_default_status) checked @endif
                                >
                                No
                            </label>
                            <span id="user_details_verified-error" class="d-block text-danger help-block">
                    @error('user_details_verified')
                                {{ $message }}
                                @enderror
                </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <img class="img-responsive img-thumbnail"
                     id="user_detail_photo_show"
                     src="{{isset($student->user_detail_photo)?URL::to($student->user_detail_photo):config('app.default_image')}}"
                     width="{{\Utility::$userPhotoSize['width']}}"
                     height="{{\Utility::$userPhotoSize['height']}}"
                >
            </div>
        </div>
    </section>
</div>

@push('scripts')
    <script>
        const selected_state_id = '{{old("state_id", (isset($student)?$student->state_id:null))}}';
        const selected_shipping_state_id = '{{old("shipping_state_id", (isset($student)?$student->shipping_state_id:null))}}';
        const selected_city_id = '{{old("city_id", (isset($student)?$student->city_id:null))}}';
        const selected_shipping_city_id = '{{old("shipping_city_id", (isset($student)?$student->shipping_city_id:null))}}';
        const selected_branch_id = '{{old("branch_id", (isset($student)?$student->branch_id:null))}}';
        const selected_company_id = '{{old("company_id", (isset($student)?$student->company_id:null))}}';

        $(document).ready(function () {

            formObject = $('form#student_form');

            //Jquery Steps
            $('.box-body').steps({
                startIndex: 0,
                onStepChanging: function (event, currentIndex, newIndex) {
                    if (currentIndex < newIndex) {
                        // Step 1 form validation
                        if (currentIndex === 0) {
                            return !!(formValidator.element("#username") &&
                                formValidator.element("#email") &&
                                @if(empty($student))
                                formValidator.element("#password") &&
                                formValidator.element("#confirm_password") &&
                                @endif
                                formValidator.element("#role") &&
                                formValidator.element("#status"));
                        }
                        // Step 2 form validation
                        if (currentIndex === 1) {
                            return !!(formValidator.element("#company_id") &&
                                formValidator.element("#branch_id") &&
                                formValidator.element("#first_name") &&
                                formValidator.element("#last_name") &&
                                //formValidator.element("#national_id") &&
                                formValidator.element("#identity_card") &&
                                formValidator.element("#date_of_birth") &&
                                //formValidator.element("#married_status") &&
                                formValidator.element("#date_of_enrollment"));
                        }
                        // Step 3 form validation
                        if (currentIndex === 2) {
                            return !!(formValidator.element("#mobile_phone") &&
                                formValidator.element("#home_phone") &&
                                formValidator.element("#mailing_address") &&
                                formValidator.element("#state_id") &&
                                formValidator.element("#city_id") &&
                                //formValidator.element("#police_station") &&
                                formValidator.element("#post_code"));
                        }
                        // Step 4 form validation
                        if (currentIndex === 3) {
                            return !!(formValidator.element("#user_detail_photo"));
                        }
                        // Always allow step back to the previous step even if the current step is not valid.
                    } else {
                        return true;
                    }
                },
                onFinished: function (event, currentIndex) {
                    formObject.submit();
                }
            });

            $('.custom-select').select2({
                width: "100%",
                placeholder: "Please Select an option"
            });

            /**
             * get branches
             */
            getBranchDropdown($("#company_id"), $("#branch_id"), selected_branch_id);
            if (selected_company_id.length > 0)
                getBranchDropdown($("#company_id"), $("#branch_id"), selected_branch_id);

            if (selected_state_id.length > 0) {
                getStateDropdown($("#country_id"), $("#state_id"), selected_state_id);
                $('#state_id').trigger('change');
            } else {
                getStateDropdown($("#country_id"), $("#state_id"), null);

            }
            if (selected_shipping_state_id.length > 0) {
                getStateDropdown($("#country_id"), $("#shipping_state_id"), selected_shipping_state_id);
                $('#shipping_state_id').trigger('change');
            } else {
                getStateDropdown($("#country_id"), $("#shipping_state_id"), null);

            }
            if (selected_city_id.length > 0)
                getCityDropdown($('#country_id'), $('#state_id'), $("#city_id"), selected_city_id);

            if (selected_shipping_city_id.length > 0)
                getCityDropdown($('#country_id'), $('#shipping_state_id'), $("#shipping_city_id"), selected_shipping_city_id);

            $('#company_id').change(function () {
                getBranchDropdown($(this), $("#branch_id"), selected_branch_id);
            });

            $('#state_id').change(function () {
                getCityDropdown($('#country_id'), $(this), $("#city_id"), selected_city_id);
            });

            $('#shipping_state_id').change(function () {
                getCityDropdown($('#country_id'), $(this), $("#shipping_city_id"), selected_shipping_city_id);
            });

            //Date picker
            $('.input-date').daterangepicker({
                buttonClasses: 'btn',
                startDate: moment(),
                singleDatePicker: true,
                showDropdowns: true,
                locale: {format: 'YYYY-MM-DD'}
            });

            formValidator = formObject.validate({
                rules: {
                    //Step 1
                    username: {
                        required: true,
                        minlength: 5,
                        maxlength: 255,
                        alphanumeric: true,
                        /*"uniqueusername": function () {
                            return $("#user_id").val() ?? null;
                        }*/
                    },
                    email: {
                        required: true,
                        minlength: 5,
                        maxlength: 255,
                        email:true,
                        /*uniqueemail: function () {
                            return $("#user_id").val() ?? null;
                        },*/
                    },
                    password: {
                        required: {{ isset($student) ? 'false' : 'true' }},
                        minlength: 6,
                        maxlength: 255,
                        equalTo: "#confirm_password"
                    },
                    confirm_password: {
                        required: {{ isset($student) ? 'false' : 'true' }},
                        minlength: 6,
                        maxlength: 255,
                        equalTo: "#password"
                    },
                    "roles[]": {
                        minlength: 1,
                        required: true
                    },
                    //Step 2
                    company_id: {
                        required: true
                    },
                    branch_id: {
                        required: false
                    },
                    first_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255,
                    },
                    last_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255,
                    },
                    /*national_id: {
                        alphanumeric: true,
                        minlength: 10
                    },*/
                    identity_card: {
                        alphanumeric: true
                    },
                    date_of_birth: {
                        required: true,
                        dateISO: true,
                        maxDate: "{{ \Carbon\Carbon::now() }}"
                    },
                    date_of_enrollment: {
                        required: true,
                        dateISO: true,
                        maxDate: "{{ \Carbon\Carbon::now() }}",
                        minDate: function () {
                            return $("#date_of_birth").val() + " 13:07:45";
                        }
                    },
                    gender: {
                        required: true
                    },
                    /*married_status: {
                        required: true,
                    },*/
                    //Step 3
                    mailing_address: {
                        required: true
                    },
                    shipping_address: {
                        required: false
                    },
                    /*police_station: {
                        required: true
                    },*/
                    city_id: {
                        required: true
                    },
                    state_id: {
                        required: true
                    },
                    shipping_city_id: {
                        required: false
                    },
                    shipping_state_id: {
                        required: false
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
                    post_code: {
                        required: false,
                        digits: true,
                        minlength: 4,
                        maxlength: 5
                    },
                    //step 4
                    user_detail_photo: {
                        required: {{ isset($student) ? 'false' : 'true' }},
                        extension: "jpg|jpeg|png|ico|bmp|svg"
                    }
                },
                messages: {
                    'roles[]':
                        "Please assign at least 1 Role(s)"
                }
            });

            $('#username').focusout(function () {
                findUserName();
            });
            $('#email').focusout(function () {
                findEmail();
            });
            $('#mobile_phone').focusout(function () {
                findMobile();
            });
            $(".date_of_birth").daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                startDate: moment().subtract(15, "years"),
                endDate: moment(),
                maxDate: moment(),
                locale: {
                    format: "YYYY-MM-DD"
                }
            });
        });
    </script>
@endpush
