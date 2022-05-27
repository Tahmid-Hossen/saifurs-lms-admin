<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!!\Form::nLabel('country_name', 'Name', true) !!}
                <input
                    id="country_name"
                    type="text"
                    class="form-control"
                    name="country_name"
                    placeholder="Enter Country Name"
                    value="{{ old('country_name', isset($country) ? $country->country_name: null) }}"
                    required

                >
                <span id="country_name-error" class="d-block text-danger help-block">
                    @error('country_name')
                    {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('country_language', 'Language') !!}
                <input
                    id="country_language"
                    type="text"
                    class="form-control"
                    name="country_language"
                    placeholder="Enter Country Language"
                    value="{{ old('country_language', isset($country) ? $country->country_language: null) }}"

                >
                <span id="country_language-error" class="d-block text-danger help-block">
                    @error('country_language')
                    {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('country_iso', 'ISO Name', true) !!}
                <input
                    id="country_iso"
                    type="text"
                    class="form-control"
                    name="country_iso"
                    placeholder="Enter Country ISO"
                    value="{{ old('country_iso', isset($country) ? $country->country_iso: null) }}"
                    required

                >
                <span id="country_iso-error" class="d-block text-danger help-block">
                    @error('country_iso')
                    {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('country_iso3', 'ISO3 Name', true) !!}

                <input
                    id="country_iso3"
                    type="text"
                    class="form-control"
                    name="country_iso3"
                    placeholder="Enter Country ISO3"
                    value="{{ old('country_iso3', isset($country) ? $country->country_iso3: null) }}"
                    required

                >
                <span id="country_iso3-error" class="d-block text-danger help-block">
                    @error('country_iso3')
                    {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('country_num_code', 'Number Code', true) !!}
                <input
                    id="country_num_code"
                    type="text"
                    class="form-control"
                    name="country_num_code"
                    placeholder="Enter Country Num Code"
                    value="{{ old('country_num_code', isset($country) ? $country->country_num_code: null) }}"
                    required

                >
                <span id="country_num_code-error" class="d-block text-danger help-block">
                    @error('country_num_code')
                    {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('country_phone_code', 'Country Phone Code', true) !!}
                <input
                    id="country_phone_code"
                    type="text"
                    class="form-control"
                    name="country_phone_code"
                    placeholder="Enter Country Phone Code"
                    value="{{ old('country_phone_code', isset($country) ? $country->country_phone_code: null) }}"
                    required

                >
                <span id="country_phone_code-error" class="d-block text-danger help-block">
                    @error('country_phone_code')
                    {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('country_currency', 'Currency', true) !!}
                <input
                    id="country_currency"
                    type="text"
                    class="form-control"
                    name="country_currency"
                    placeholder="Enter Country Currency"
                    value="{{ old('country_currency', isset($country) ? $country->country_currency: null) }}"
                    required

                >
                <span id="country_currency-error" class="d-block text-danger help-block">
                    @error('country_currency')
                    {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('country_currency_symbol','Symbol') !!}
                <input
                    id="country_currency_symbol"
                    type="text"
                    class="form-control"
                    name="country_currency_symbol"
                    placeholder="Enter Country Currency Symbol"
                    value="{{ old('country_currency_symbol', isset($country) ? $country->country_currency_symbol: null) }}"

                >
                <span id="country_currency_symbol-error" class="d-block text-danger help-block">
                    @error('country_currency_symbol')
                    {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('country_status', 'Status') !!}
                <select name="country_status" id="country_status" class="form-control">
                    @foreach(\App\Support\Configs\Constants::$user_status as $status)
                        <option value="{{$status}}"
                                @if (isset($country) && ($country->country_status === $status)) selected @endif
                        >{{$status}}</option>
                    @endforeach
                </select>
                <span id="country_status-error" class="d-block text-danger help-block">
                    @error('country_status')
                    {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('country_logo', 'Flag Photo') !!}
                <label for="country_logo">Country Flag</label>
                <input
                    type="file" onchange="imageIsLoaded(this, 'country_logo_show');"
                    class="form-control"
                    name="country_logo"
                    id="country_logo"
                    placeholder="Enter Country Flag"
                    value="{{ old('country_logo', isset($country) ? $country->country_logo:null) }}"
                >
                <span id="country_logo-error" class="d-block text-danger help-block">
                    @error('country_logo')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="text-center">
                <img
                    id="country_logo_show" class="img-thumbnail img-responsive"
                    src="{{isset($country->country_logo)?URL::to($country->country_logo):config('app.default_image')}}"
                    width="{{\Utility::$countryFlagSize['width']}}"
                    height="{{\Utility::$countryFlagSize['height']}}"
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
        $(document).ready(function () {
            formObject = $("form#country_form");
            formObject.validate({
                rules: {
                    country_name: {
                        required: true,
                        minlength: 3
                    },
                    country_iso: {
                        required: true
                    },
                    country_iso3: {
                        required: true
                    },
                    country_num_code: {
                        required: true
                    },
                    country_phone_code: {
                        required: true
                    },
                    country_logo: {
                        extension: "jpg|jpeg|png|ico|bmp|svg"
                    }
                }
            });
        });
    </script>
@endpush
