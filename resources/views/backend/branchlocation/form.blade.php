@include('backend.layouts.partials.errors')
<div class="box-body">
    <div class="row">
        <div class="col-md-3">
            {!! \Form::nText('branch_name', 'Branch Name', (isset($branchlocation) ? $branchlocation->branch_name: null), true, ['placeholder' => 'Enter Branch Name']) !!}
        </div>
        <div class="col-md-3">
            {!! \Form::nText('manager_name', 'Manager Name', (isset($branchlocation) ? $branchlocation->manager_name: null), false, ['placeholder' => 'Enter Manager Name']) !!}
        </div>
        <div class="col-md-3">
            {!! \Form::nTel('phone', 'Phone', (isset($branchlocation) ? $branchlocation->phone: null), true, ['placeholder' => 'Enter Branch Phone']) !!}
        </div>
        <div class="col-md-3">
            {!! \Form::nText('email', 'Email', (isset($branchlocation) ? $branchlocation->email: null), false, ['placeholder' => 'Enter Email']) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            {!! \Form::nTextarea('address_en', 'Address English', (isset($branchlocation) ? $branchlocation->address_en: null), false, ['rows' => 3, 'placeholder' => 'Enter English Address']) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nTextarea('address_bn', 'Address Bangla', (isset($branchlocation) ? $branchlocation->address_bn: null), false, ['rows' => 3, 'placeholder' => 'Enter Bangla Address']) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        {!! \Form::nLabel('status', 'Status', false) !!}
                        <select name="status" id="status" class="form-control view-color">
                            @foreach(\App\Support\Configs\Constants::$branch_location_status as $status)
                                <option value="{{$status}}"
                                        @if (isset($branchlocation) && ($branchlocation->status === $status)) selected @endif
                                >{{str_replace("-","",$status)}}</option>
                            @endforeach
                        </select>
                        <span class="form-text text-danger" role="alert">{{ $errors->first('status') }}</span>
                    </div>
                </div>

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
       /* var selected_state_id = '{{old("state_id", (isset($branch)?$branch->state_id:null))}}';
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
*/
            formObject = $('form#branch_form');
            formValidator = formObject.validate({
                rules: {

                    branch_name: {
                        required: true,
                        branchtitle : true
                    },
                    /*branch_email: {
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
                    }*/
                }
            });
        });
    </script>
@endpush

