<div class="box-body">
    <input type="hidden" name="country_id" id="country_id" value="18">
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nText('state_name', 'State Name', old('state_name', isset($state) ? $state->state_name: null), true) !!}
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('state_status', 'Status') !!}
                <select name="state_status" id="state_status" class="form-control">
                    @foreach(\App\Support\Configs\Constants::$user_status as $status)
                        <option value="{{$status}}"
                                @if (isset($state) && ($state->state_status === $status)) selected @endif
                        >{{$status}}</option>
                    @endforeach
                </select>
                <span id="state_name-error" class="d-block text-danger help-block" >
                    @error('state_name')
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
            formObject = $("form#state_form");
            formObject.validate({
                rules: {
                    state_name: {
                        required: true,
                        minlength: 2,
                        maxlength: 255
                    },
                    country_id: {
                        required: true
                    }
                }
            })
        });
    </script>
@endpush
