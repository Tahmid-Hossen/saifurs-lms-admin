@include('backend.layouts.partials.errors')
<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nSelect('company_id', 'Company', $global_companies,
 old('company_id', isset($branch) ? $branch->company_id : null) , true,
  ['placeholder' => 'Company Name', 'class' => 'form-control select2']) !!}
                <span id="company_id-error" class="help-block">{{ $errors->first('company_id') }}</span>
            </div>
        </div>
        <div class="col-md-6">
            {!! \Form::nText('branch_name', 'Branch Name', (isset($branch) ? $branch->branch_name: null), true, ['placeholder' => 'Enter Branch Name']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nTel('branch_phone', 'Branch Phone', (isset($branch) ? $branch->branch_phone: null), true, ['placeholder' => 'Enter Branch Phone']) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nTel('branch_mobile', 'Branch Mobile', (isset($branch) ? $branch->branch_mobile: null), true, ['placeholder' => 'Enter Branch Mobile Number']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            {!! \Form::nTextarea('branch_address', 'Branch Address', (isset($branch) ? $branch->branch_address: null), true, ['rows' => 3, 'placeholder' => 'Enter Branch Address']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <input type="hidden" name="country_id" id="country_id" value="18">
            <div class="form-group">
                {!! \Form::nLabel('state_id', 'District', true) !!}
                <select name="state_id" id="state_id" class="form-control select2" required>
                    <option value="">Select District</option>
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
                {!! \Form::nLabel('branch_zip_code', 'Postal Code') !!}
                <input
                    type="text"
                    class="form-control"
                    name="branch_zip_code"
                    id="branch_zip_code"
                    placeholder="Enter post code"
                    value="{{ old('branch_zip_code', isset($branch) ? $branch->branch_zip_code:null) }}"
                >
                <span class="help-block">{{ $errors->first('branch_zip_code') }}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('branch_latitude', 'Branch Latitude') !!}
                <input
                    id="branch_latitude"
                    type="text"
                    class="form-control"
                    name="branch_latitude"
                    placeholder="Enter Branch Latitude"
                    value="{{ old('branch_latitude', isset($branch) ? $branch->branch_latitude: null) }}"
                    autofocus
                >

                <span id="branch_latitude-error" class="help-block">{{ $errors->first('branch_latitude') }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('branch_longitude', 'Branch Longitude') !!}
                <input
                    id="branch_longitude"
                    type="text"
                    class="form-control"
                    name="branch_longitude"
                    placeholder="Enter Branch Longitude"
                    value="{{ old('branch_longitude', isset($branch) ? $branch->branch_longitude: null) }}"
                    autofocus
                >

                <span id="branch_longitude-error" class="help-block">{{ $errors->first('branch_longitude') }}</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('branch_status', 'Status') !!}
                <select name="branch_status" id="branch_status" class="form-control">
                    @foreach(\App\Support\Configs\Constants::$user_status as $status)
                        <option value="{{$status}}"
                                @if (isset($branch) && ($branch->branch_status === $status)) selected @endif
                        >{{$status}}</option>
                    @endforeach
                </select>
                <span id="branch_status-error" class="help-block">{{ $errors->first('branch_status') }}</span>
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
        var selected_state_id = '{{old("state_id", (isset($branch)?$branch->state_id:null))}}';
        var selected_city_id = '{{old("city_id", (isset($branch)?$branch->city_id:null))}}';

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

            formObject = $('form#branch_form');
            formValidator = formObject.validate({
                rules: {
                    company_id: {
                        required: true
                    },
                    branch_name: {
                        required: true,
                        branchtitle : true
                    },
                    branch_email: {
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
                    branch_mobile: {
                        required: true,
                        digits: true,
                        minlength: 11,
                        maxlength: 11,
                        mobilenumber: true
                    },
                    branch_phone: {
                        required: true,
                        digits: true,
                        minlength: 9,
                        maxlength: 11,
                        mobilenumber: true
                    },
                    branch_address: {
                        required: false,
                        minlength: 10,
                        maxlength: 250
                    },
                    branch_zip_code: {
                        required: false,
                        digits: true,
                        minlength: 4,
                        maxlength: 5
                    },
                    branch_logo: {
                        required: true,
                        extension: "jpg|jpeg|png|ico|bmp|svg"
                    }
                }
            });
        });
    </script>
@endpush

