<div class="box-body">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(auth()->user()->userDetails->company_id == 1)
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
        <div class="col-md-4">
            {!! \Form::nSelect('user', 'Customer', $users, (isset($sale) ? $sale->user_id : null), true, ['class' => 'form-control select2', 'placeholder' => 'Select a User']) !!}
        </div>
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
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive mt-4">
                <table class="table table-stripped table-center table-hover" id="invoice-table">
                    <thead>
                    <tr>
                        <th>Items</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php $count = 0; @endphp
                    @if(!empty($items))
                        {{--@dd($items)--}}
                        @foreach($items as $si =>$item)
                            @php $count = $si; @endphp
                            <tr>
                                <td width="50%">
                                    {!! \Form::hidden('invoice[' .$si . '][id]', $item->id) !!}
                                    {!! \Form::select('invoice[' .$si . '][item]', $books, $item->book_id, ['class' => 'form-control select2', 'onchange'=>"updateInvoice();"]) !!}
                                </td>
                                <td>
                                    {!! \Form::number('invoice[' .$si . '][price]', $item->price, ['class'=> 'form-control price', 'onchange'=>"updateInvoice();"]) !!}
                                </td>
                                <td>
                                    {!! \Form::number('invoice[' .$si . '][quantity]', $item->quantity, ['class'=> 'form-control quantity', 'onchange'=>"updateInvoice();"]) !!}
                                </td>
                                <td>
                                    {!! \Form::number('invoice[' .$si . '][total]', $item->total, ['class'=> 'form-control total', 'readonly' => 'readonly', 'onchange'=>"updateInvoice();"]) !!}
                                </td>

                                <td class="text-right" width="96">
                                    <button type="button"
                                            class="btn btn-sm btn-danger btn-block text-bold"
                                            onclick="removeRow(this);">Remove
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td style="width: 50%">
                                {!! \Form::select('invoice[0][item]', [], null, ['class' => 'form-control item-select', 'onchange' => 'updateInvoice();']) !!}
                            </td>
                            <td>
                                {!! \Form::number('invoice[0][price]', 0, ['class'=> 'form-control price', 'onchange'=>"updateInvoice();"]) !!}
                            </td>
                            <td>
                                {!! \Form::number('invoice[0][quantity]', 0, ['class'=> 'form-control quantity', 'onchange'=>"updateInvoice();"]) !!}
                            </td>
                            <td>
                                {!! \Form::number('invoice[0][total]', 0, ['class'=> 'form-control total', 'readonly' => 'readonly', 'onchange'=>"updateInvoice();"]) !!}
                            </td>
                            <td class="text-right" width="80">
                                <button type="button"
                                        class="btn btn-sm btn-danger btn-block text-bold"
                                        onclick="removeRow(this);">Remove
                                </button>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="5">
                            <button type="button" class="btn btn-primary btn-block text-bold"
                                    data-current-index="{{ $count+1 ?? 0 }}" onclick="addRow(this);"><i
                                    class="fa fa-plus"></i> Add More Item
                            </button>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td class="text-right text-bold vcenter" colspan="2">Sub Total</td>
                        <td class="text-right" colspan="3">
                            <input class="form-control form-control-plaintext" id="sub-total"
                                   value="{{ $sale->sub_total_amount ?? 0 }}">
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right text-bold vcenter" colspan="2">Coupon</td>
                        <td class="text-right" colspan="2">
                            {!! \Form::text('coupon_code', null,['class' => 'form-control form-control-plaintext',
                                        'id' => 'coupon_code']) !!}
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary" id="coupon-apply">Apply</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right text-bold vcenter" colspan="2">Discount Amount</td>
                        <td class="text-right" colspan="3">
                            <input class="form-control form-control-plaintext" id="discount"
                                   value="{{ $sale->total ?? 0 }}" readonly>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right text-bold vcenter" colspan="2">Shipping Cost</td>
                        <td class="text-right" colspan="3">
                            {!! \Form::number('shipping_cost', $data->shipping_cost ?? 0, ['class'=> 'form-control', 'onchange'=>"updateInvoice();", 'id' => 'ship-cost']) !!}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-right text-bold vcenter" colspan="2">Grand Total</td>
                        <td class="text-right" colspan="3">
                            <input class="form-control form-control-plaintext" id="grand-total"
                                   value="{{ $sale->total ?? 0 }}">
                        </td>
                    </tr>

                    </tfoot>
                </table>
            </div>
            <div class="row">
                <div class="col-md-12">
                    {!! \Form::nTextarea('notes', 'Footer Notes',(isset($sale) ? $sale->notes : null), false, ['rows' => 2]) !!}
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
        const selected_user_id = '{{ old('user', ($sale->user_id ??  null)) }}';

        function getRowTemplate(index) {
            return "{!! html_entity_decode(addslashes("<tr> <td width='50%'> " .
                                (\Form::select('invoice[" + index + "][item]', [], null, ['class' => 'form-control item-select']) ) .
                                "</td> <td> " .
                                (\Form::number('invoice[" + index + "][price]', 0, ['class'=> 'form-control price', 'onchange'=>"updateInvoice();"]) ) .
                                "</td><td> " .
                                (\Form::number('invoice[" + index + "][quantity]', 0, ['class'=> 'form-control quantity', 'onchange'=>"updateInvoice();"]) ) .
                                "</td><td> " .
                                (\Form::number('invoice[" + index + "][total]', 0, ['class'=> 'form-control total', 'readonly' => 'readonly', 'onchange'=>"updateInvoice();"]) ) .
                                "</td><td class='text-right' width='96'> " .
                                "<button type='button' class='btn btn-sm btn-danger btn-block text-bold' onclick='removeRow(this);'>Remove</button> ".
                                "</td></tr>")) !!}";
        }

        function updateInvoice() {
            var subTotalCol = $('#sub-total');
            var shipCostCol = $('#ship-cost');
            var discountCol = $('#discount');
            var grandTotalCol = $('#grand-total');

            var subTotal = 0, grandTotal = 0;

            $('table#invoice-table tbody tr').each(function () {
                var row = $(this);
                var priceCol = row.find('td input.price');
                var qtyCol = row.find('td input.quantity');
                var totalCol = row.find('td input.total');

                if (!isNaN(priceCol.val()) || !isNaN(qtyCol.val())) {
                    var rate = parseFloat(priceCol.val());
                    var qty = parseFloat(qtyCol.val());
                    var total = rate * qty;
                    subTotal += total;
                    totalCol.val(total.toFixed(2));
                }
            });
            subTotalCol.val(subTotal.toFixed(2));

            if (!isNaN(discountCol.val())) {
                grandTotal = subTotal - parseFloat(discountCol.val());
            }

            console.log(shipCostCol.val());

            if (!isNaN(shipCostCol.val())) {

                grandTotal += parseFloat(shipCostCol.val());
            }

            grandTotalCol.val(grandTotal.toFixed(2));
        }

        function addRow(element) {
            var jqelement = $(element);
            var index = parseInt(jqelement.data('current-index'));
            $(getRowTemplate(index)).insertBefore(jqelement.parent().parent());
            jqelement.data('current-index', index + 1);

            updateInvoice();

            initItemDropDown();
        }

        function removeRow(element) {
            var r = $(element).parent().parent().remove();
            updateInvoice();
        }

        function formatResponseSelection(item) {
            return item.title || item.text;
        }


        function initItemDropDown() {
            $(".item-select").each(function () {
                $(this).select2({
                    ajax: {
                        url: "{{ route('sales.items') }}",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                search_text: params.term, // search term
                                page: params.page,
                                company_id: '{{ auth()->user()->userDetails->company_id }}'
                            };
                        },
                        processResults: function (data, params) {
                            // parse the results into the format expected by Select2
                            // since we are using custom formatting functions we do not need to
                            // alter the remote JSON data, except to indicate that infinite
                            // scrolling can be used
                            params.page = params.page || 1;
                            return {
                                results: data
                            };
                        },
                        cache: true
                    },
                    placeholder: 'Select a Book/Course',
                    minimumInputLength: 3,
                    width: "100%",
                    allowClear: true,
                    escapeMarkup: function (item) {
                        return item;
                    },
                    templateResult: function (item) {
                        if (item.loading) {
                            return item.text;
                        }

                        return $(
                            `<div class="media">
                    <div class="media-left media-middle">
                        <img alt="64x64" class="media-object" style="width: 64px; height: 64px;"
                        src='` + item.image + `' data-holder-rendered="true">
                    </div>
                    <div class="media-body">
                        <p class="media-heading text-info text-bold">` + item.title + `</p>
                        <p><span class="badge badge-success" style='margin-right: 1rem;'> <i class="fa fa-tags"></i> ` + item.type + `</span>
                            <span style='margin-right: 1rem;'> <i class="fa fa-user"></i> ` + item.provider + `</span>
                            <span style='margin-right: 1rem;'> <i class="fa fa-usd"></i> ` + item.price + `</span>
                        </p>
                    </div>
                </div>`);
                    },
                    templateSelection: function (item) {
                        return item.title || item.text;
                    }

                });
            });
        }

        $(document).ready(function () {

            getBranchDropdown($("#company"), $("#branch"), selected_branch_id);

            $('#company').change(function () {
                getBranchDropdown($(this), $("#branch"), selected_branch_id);
            });

            $('form#sales').validate({
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
                                discountAmount = ((parseFloat(subTotalCol.val()) * disAmt) / 100) || 0;
                            } else {
                                discountAmount = disAmt || 0;
                            }

                            discountCol.val(discountAmount);
                            updateInvoice();
                        } else {
                            alert(response.message);
                        }
                    }, 'json');
                }
            });

            if (selected_user_id.length > 0) {
                $("#user").val(selected_user_id);
                $("#user").trigger('change');

            }
            initItemDropDown();
        });
    </script>
@endpush
