<div class="box-body">
    <div class="row">
        <div class="col-md-4">
            <input type="hidden" name="country_id" id="country_id" value="18">
            <div class="form-group">
                {!! \Form::nLabel('state_id', 'State', true) !!}
                <select name="state_id" id="state_id" class="form-control select2" required>
                    <option value="" @if (isset($city) && ($city->state_id === "")) selected @endif>Select State
                    </option>
                    @foreach($provinces as $state)
                        <option value="{{$state->id}}"
                                @if (isset($city) && ($city->state_id === $state->id)) selected @endif
                        >{{$state->state_name}}</option>
                    @endforeach
                </select>
                <span id="state_id-error" class="d-block text-danger help-block" >
                    @error('state_id')
                    {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                {!! \Form::nLabel('city_name', 'City Name', true) !!}
                <input
                    id="city_name"
                    type="text"
                    class="form-control"
                    name="city_name"
                    placeholder="Enter City Name"
                    value="{{ old('city_name', isset($city) ? $city->city_name: null) }}"
                    required
                    autofocus
                >
                <span id="city_name-error" class="d-block text-danger help-block" >
                    @error('city_name')
                    {{ $message }}
                    @enderror
                </span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="city_status" class="control-label">@lang('common.Status')</label>
                <select name="city_status" id="city_status" class="form-control">
                    @foreach(\App\Support\Configs\Constants::$user_status as $status)
                        <option value="{{$status}}"
                                @if (isset($city) && ($city->city_status === $status)) selected @endif
                        >{{$status}}</option>
                    @endforeach
                </select>
                <span id="city_status-error" class="d-block text-danger help-block" >
                    @error('city_status')
                    {{ $message }}
                    @enderror
                </span>
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
            formObject = $("form#city_form");
            formObject.validate({
                rules: {
                    city_name: {
                        required: true,
                        minlength: 2,
                        maxlength: 255
                    },
                    state_id: {
                        required: true
                    },
                    country_id: {
                        required: true
                    }
                }
            })
        });
    </script>
@endpush
