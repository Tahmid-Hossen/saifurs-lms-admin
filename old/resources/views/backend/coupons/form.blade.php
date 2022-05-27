<div class="box-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('company_id', 'Company', true) !!}
                <select name="company_id" id="company_id" class="form-control" required>
                    <option value="">Select Company</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}"
                                @if (old('company_id', isset($data) ? $data['company_id'] : null) == $company->id) selected @endif>{{ $company->company_name }}
                        </option>
                    @endforeach
                </select>
                @if ($errors->has('company_id'))
                    <span class="help-block"><strong>{{ $errors->first('company_id') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('branch_id', 'Branch') !!}
                <select name="branch_id" id="branch_id" class="form-control">
                    <option value="">Select Branch</option>
                </select>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('coupon_title', 'Coupon Title', true) !!}
                <input id="coupon_title" type="text" class="form-control" name="coupon_title"
                       value="{{ old('coupon_title', isset($data) ? $data['coupon_title'] : null) }}" required
                       autofocus>

                <span id="coupon_title-error" class="help-block">{{ $errors->first('coupon_title') }}</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('coupon_schedule', 'Coupon Validation Period', true) !!}
                @php
                    $start_date = (isset($data) && !is_null($data->coupon_start))
                    ? $data->coupon_start : date('Y-m-d H:i:s');

                    $end_date = (isset($data) && !is_null($data->coupon_end))
                    ? $data->coupon_end : date('Y-m-d H:i:s');

                    $duration = $start_date . ' - ' . $end_date;
                @endphp
                <input id="coupon_schedule" type="text" readonly
                       class="form-control event_duration" name="coupon_schedule"
                       value="{{ old('coupon_schedule', $duration) }}"
                       required>
                <span class="help-block">{{ $errors->first('coupon_schedule') }}</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nSelect('discount_type', 'Discount Type',
                ['fixed' => 'Fixed Amount', 'percent' => 'Percentage'],
                 isset($data['discount_type']) ? $data['discount_type'] : 'fixed', true)!!}</div>
        <div class="col-md-6">
            {!! \Form::nNumber('discount_amount', 'Discount Amount', $data['discount_amount'] ?? 0,true, ['min' => 0, 'max' => '9000000', 'step' => '0.001']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! \Form::nLabel('coupon_code', 'Coupon Code', true) !!}
                <input id="coupon_code" type="text" class="form-control" name="coupon_code"
                       value="{{ old('coupon_code', isset($data) ? $data['coupon_code'] : null) }}" required
                       autofocus>
                <span id="coupon_code-error" class="help-block">{{ $errors->first('coupon_code') }}</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="coupon_status" class="control-label">Status</label>
                <select name="coupon_status" id="coupon_status" class="form-control">
                    @foreach (\App\Services\UtilityService::$statusText as $status)
                        <option value="{{ $status }}"
                                @if (isset($data) && $data['coupon_status'] === $status) selected @endif>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="box-footer">
    {!! \CHTML::actionButton(
    $reportTitle='..',
    $routeLink='coupons',
    isset($data) ? $data->id : null,
    $selectButton=['cancelButton','storeButton'],
    $class = ' btn-icon btn-circle ',
    $onlyIcon='yes',
    $othersPram=array()
)
!!}
</div>

@push('scripts')
    <script>
        const selected_branch_id = '{{(empty(old('branch')) ? (isset($book)  ? $book->branch_id  : null) : old('branch')) }}';

        $(document).ready(function () {
            getBranchDropdown($("#company_id"), $("#branch_id"), selected_branch_id);
            $("#company_id").trigger("change");

            $('#company_id').change(function () {
                getBranchDropdown($(this), $("#branch_id"), selected_branch_id);
            });

            $('#branch').select2({width: "100%", placeholder: "Please Select an option"});
            $("#coupon_form").validate({
                rules: {
                    coupon_title: {
                        required: true
                    },
                    coupon_code: {
                        required: true,
                        minlength: 3,
                        maxlength: 10,
                        alphanumeric: true
                    },
                    company_id: {
                        required: true
                    },
                }
            });
        });
    </script>
@endpush
