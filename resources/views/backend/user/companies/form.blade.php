<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nText('company_name', 'Company Name', (isset($company) ? $company->company_name: null), true, ['placeholder' => 'Enter Company Name']) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('company_email', 'Company Email', (isset($company) ? $company->company_email: null), true, ['placeholder' => 'Enter Company Email Address']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nTel('company_phone', 'Company Phone', (isset($company) ? $company->company_phone: null), true, ['placeholder' => 'Enter Company Phone']) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nTel('company_mobile', 'Company Mobile', (isset($company) ? $company->company_mobile: null), true, ['placeholder' => 'Enter Company Mobile Number']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! \Form::nTextarea('company_address', 'Company Address', (isset($company) ? $company->company_address: null), true, ['rows' => 3, 'placeholder' => 'Enter Company Address']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <input type="hidden" name="country_id" id="country_id" value="18">
            <div class="form-group">
                {!! \Form::nLabel('state_id', 'State', true) !!}
                <select name="state_id" id="state_id" class="form-control select2" required>
                    <option value="">Select State</option>
                </select>
                <span id="state_id-error" class="help-block">{{ $errors->first('state_id') }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('city_id', 'City', true) !!}

                <select name="city_id" id="city_id" class="form-control select2" required>
                    <option value="">Select City</option>
                </select>
                <span id="city_id-error" class="help-block">{{ $errors->first('city_id') }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('company_zip_code', 'Postal Code') !!}
                <input
                    type="text"
                    class="form-control"
                    name="company_zip_code"
                    id="company_zip_code"
                    placeholder="Enter post code"
                    value="{{ old('company_zip_code', isset($company) ? $company->company_zip_code:null) }}"
                >
                <span class="help-block">{{ $errors->first('company_zip_code') }}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('company_status', 'Status', false) !!}
                <select name="company_status" id="company_status" class="form-control">
                    @foreach(\App\Support\Configs\Constants::$user_status as $status)
                        <option value="{{$status}}"
                                @if (isset($company) && ($company->company_status === $status)) selected @endif
                        >{{$status}}</option>
                    @endforeach
                </select>
                <span id="company_status-error" class="help-block">{{ $errors->first('company_status') }}</span>
            </div>
            <div class="form-group">
                {!! \Form::nLabel('company_logo', 'Company Logo', empty($company)) !!}
                <input
                    type="file" onchange="imageIsLoaded(this, 'company_logo_show');"
                    class="form-control"
                    name="company_logo"
                    id="company_logo"
                    placeholder="Enter Company Logo"
                    value="{{ old('company_logo', isset($company) ? $company->company_logo:null) }}"
                >
                <span class="text-danger d-block help-block">{{ $errors->first('company_logo') }}</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="container  img-thumbnail text-center">
                <img class="img-responsive" style="display: inline-block; height: 178px;"
                     id="company_logo_show"
                     src="{{isset($company->company_logo)?URL::to($company->company_logo):config('app.default_image')}}"
                     width="{{\Utility::$companyLogoSize['width']}}"
                     height="{{\Utility::$companyLogoSize['height']}}"
                >
            </div>
        </div>
    </div>
</div>
<div class="box-footer">
    {!!
        \CHTML::actionButton(
            $reportTitle='..',
            $routeLink='#',
            '',
            $selectButton=['cancelButton','storeButton'],
            $class = ' btn-icon btn-circle ',
            $onlyIcon='yes',
            $othersPram=array()
        )
    !!}
</div>

@push('scripts')
    <script>
        const selected_state_id = '{{old("state_id", (isset($company)?$company->state_id:null))}}';
        const selected_city_id = '{{old("city_id", (isset($company)?$company->city_id:null))}}';

        $(document).ready(function () {

            if (selected_state_id.length > 0) {
                getStateDropdown($("#country_id"), $("#state_id"), selected_state_id);
                $('#state_id').trigger('change:select2');
            } else {
                getStateDropdown($("#country_id"), $("#state_id"), null);

            }
            if (selected_city_id.length > 0)
                getCityDropdown($('#country_id'), $('#state_id'), $("#city_id"), selected_city_id);

            $("#state_id").change(function () {
                getCityDropdown($('#country_id'), $(this), $("#city_id"), selected_city_id);
            });

            formObject = $('form#company_form');
            formValidator = formObject.validate({
                rules: {
                    company_name: {
                        required: true,
                        branchtitle : true
                    },
                    company_email: {
                        email: true
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
                    company_mobile: {
                        required: true,
                        digits: true,
                        minlength: 11,
                        maxlength: 11,
                        mobilenumber: true
                    },
                    company_phone: {
                        required: true,
                        digits: true,
                        minlength: 9,
                        maxlength: 11
                    },
                    company_address: {
                        required: false,
                        minlength: 10,
                        maxlength: 250
                    },
                    company_zip_code: {
                        required: false,
                        digits: true,
                        minlength: 4,
                        maxlength: 5
                    },
                    company_logo: {
                        required: {{ isset($company)?'false':'true' }},
                        extension: "jpg|jpeg|png|ico|bmp|svg|gif"
                    }
                }
            });
        });
    </script>
@endpush
