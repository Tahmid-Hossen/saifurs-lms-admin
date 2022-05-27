<div class="box-body">
    @include('backend.layouts.partials.errors')
    <div class="row" id="customer-entry-form">
        <div class="col-md-4">
            {!! Form::nLabel('transaction_id', 'Transaction ID', true) !!}
            <select name="tran_id" class="form-control">
                @foreach($sales as  $sale)
                    <option value="{{ $sale->transaction_id }}">{{ $sale->transaction_id }}</option>
                @endforeach
            </select>
            {!! \Form::nSelect('status', 'Payment Status', \App\Services\UtilityService::$paymentStates, true) !!}
        </div>
        <div class="col-md-4">
            {!! \Form::nTel('phone', 'Phone', (isset($sale) ? $sale->customer_phone : null), true) !!}
        </div>
        <div class="col-md-4">
            {!! \Form::nEmail('email', 'Email', (isset($sale) ? $sale->customer_email : null),true) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nTextarea('ship_address', 'Shipping Address',(isset($sale) ? $sale->address : null), true, ['rows' => 2]) !!}
        </div>
    </div>
    {{--@if(auth()->user()->userDetails->company_id == 1)
        <div class="row">
            <div class="col-md-6">
                {!! \Form::nSelect('company', 'Select Company', $global_companies, (isset($sale) ? $sale->company_id: null), true,
    [ 'class' => 'form-control select2']) !!}
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="branch" class="control-label">Select Branch:</label>
                    <select name="branch" id="branch" class="form-control">
                        <option value="">Select an option</option>
                    </select>
                </div>
            </div>
        </div>
    @else
        <input type="hidden" name="company" id="company"
               value="{{auth()->user()->userDetails->company_id}}">

        <input type="hidden" name="branch" id="branch"
               value="{{auth()->user()->userDetails->branch_id}}">
    @endif
    <div class="row">
        <div class="col-md-4">
            {!! \Form::nText('reference_number', 'Reference Number', (isset($sale) ? $sale->reference_number : null), false) !!}
        </div>
        <div class="col-md-4">
            {!! \Form::nText('entry_date', 'Entry Date', isset($sale) ? $sale->entry_date->format('Y-m-d'): date('Y-m-d'), true, [
'class' => 'form-control only_date'])!!}
        </div>
--}}{{--        <div class="col-md-4">
            {!! \Form::nSelect('user', 'Customer', $users ?? [], (isset($sale) ? $sale->user_id : null), true, ['class' => 'form-control select2', 'placeholder' => 'Select a User']) !!}
        </div>--}}{{--
    </div>
    <div class="row" id="customer-entry-form">
        <div class="col-md-4">
            {!! \Form::nText('name', 'Name', (isset($sale) ? $sale->customer_name : null), true) !!}
        </div>
        <div class="col-md-4">
            {!! \Form::nTel('phone', 'Phone', (isset($sale) ? $sale->customer_phone : null), true) !!}
        </div>
        <div class="col-md-4">
            {!! \Form::nEmail('email', 'Email', (isset($sale) ? $sale->customer_email : null),true) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nTextarea('ship_address', 'Shipping Address',(isset($sale) ? $sale->address : null), true, ['rows' => 2]) !!}
        </div>
    </div>--}}
</div>
<div class="box-footer">
    {!!
        \CHTML::actionButton(
            $reportTitle='..',
            $routeLink='#',
            (isset($sale) ? $sale->id : null),
            $selectButton=['cancelButton','storeButton'],
            $class = ' btn-icon btn-circle ',
            $onlyIcon='yes',
            $othersPram=array()
        )
    !!}
</div>

@push('scripts')
    <script>
        const selected_branch_id = '{{ old('branch', ($sale->branch_id ??  null)) }}';

        $(document).ready(function () {

            getBranchDropdown($("#company"), $("#branch"), selected_branch_id);

            $('#company').change(function () {
                getBranchDropdown($(this), $("#branch"), selected_branch_id);
            });

            $('form#transactions').validate({
                rules: {
                    company: {
                        required: true,
                        min: 1
                    }, branch: {
                        min: 1
                    },
                    reference_number: {
                        required: false
                    },
                    entry_date: {
                        date: true,
                        required: true
                    },
                    user: {
                        digits: true
                    },
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    phone: {
                        required: true,
                        minlength: 11,
                        maxlength: 11,
                    },
                    email: {
                        required: true
                    },
                    address: {
                        required: false,
                        minlength: 3
                    }
                }
            });

/*
            $("#user").change(function () {
                var user = $(this).val();
                var company = $('#company').val();
                if (user) {
                    $.post('{{ route('users.find-user-have-id') }}', {
                            user_id: user,
                            company_id: company,
                            '_token': CSRF_TOKEN
                        },
                        function (response) {
                            $("#name").val(response.name);
                            $("#phone").val(response.mobile_number);
                            $("#email").val(response.email);
                        }, 'json');
                }
            });

            $("#coupon-apply").click(function () {
                var coupon = $("#coupon_code").val();
                var company = $('#company').val();
                var subTotalCol = $('#sub-total');

                if ((coupon.length > 3) && (!isNaN(subTotalCol.val()))) {
                    $.post('{{ route('coupons.check') }}', {
                        'company_id': company,
                        'coupon_code': coupon,
                        '_token': CSRF_TOKEN,
                        'coupon_status': 'ACTIVE',
                        'coupon_end_verify': 'YES',
                        'coupon_end': 'CHECK'
                    }, function (response) {
                        if (response.status === true) {
                            alert(response.message);
                            var discountCol = $('#discount');
                            var discountAmount = 0;

                            var disAmt = parseFloat(response.coupon.discount_amount);
                            if (response.coupon.discount_type === 'percent') {
                                discountAmount = (parseFloat(subTotalCol.val()) * disAmt) / 100;
                            } else {
                                discountAmount = disAmt;
                            }

                            discountCol.val(discountAmount);
                            updateInvoice();
                        } else {
                            alert(response.message);
                        }
                    }, 'json');
                }
            });
*/

            if (selected_user_id.length > 0) {
                $("#user").val(selected_user_id);
                $("#user").trigger('change');

            }
            initItemDropDown();
        });
    </script>
@endpush
