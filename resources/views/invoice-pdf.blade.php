<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            font-weight: 400;
            font-size: 12px;
            color: #000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid rgba(112, 112, 112, 0.5);
        }

        table tr th {
            border: 1px solid rgba(112, 112, 112, 0.5);
            padding: 5px;
            text-transform: capitalize;
        }

        table tr td {
            border: 1px solid rgba(112, 112, 112, 0.5);
            text-align: center;
            padding: 5px;
            text-transform: capitalize;
        }

        .calc-table tr:last-of-type {
            border-top: 1px solid rgba(112, 112, 112, 0.5);
        }

        .calc-table tr td {
            border: 0;
            text-align: right;
            padding-left: 0;
        }

        .calc-table tr td:first-child {
            text-align: left;
        }

        .title {
            font-weight: 600;
            font-size: 14px;
            text-transform: capitalize;
            margin-bottom: 10px;
        }

        .border-right::before,
        .border-right::after {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            height: 5px;
            width: 5px;
            background-color: #707070;
            border-radius: 5px;
        }

        .border-right::before {
            top: 0;
        }

        .border-right::after {
            bottom: 0;
        }

    </style>
</head>

<body style="width: 595px; margin-left: auto; margin-right: auto;">
<div class="invoice">
    <!-- Title -->
    <div class="title">
        <h2 style="font-size: 20px; font-weight: 600; text-align: center;">INVOICE</h2>
    </div>
    <div style="border: 1px solid #707070; box-sizing: border-box;">
        <!-- Header Top -->
        <table style="border: 0; width: 100%">
            <tr>
                <td style="border: 0; text-align: left; width: 50%">
                    <img style="width: 140px;"
                         src="data:image/png;base64, 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">
                </td>
                <td style="border: 0; text-align: right; width: 50%">
                    <p>Invoice ID: #{!! $sale->transaction_id ?? null !!}</p>
                    <p style="font-size: 11px; font-weight: 300;">
                        Date: {!! $sale->entry_date->format(config('app.date_format2')) ?? null !!}</p>
                </td>
            </tr>
        </table>
        <!-- Shipping & Billing Address -->
        <div style="display: flex; justify-content: space-between; padding: 10px;">
            <table style="border:0">
                <tr style="border:0">
                    <td style="text-align: left; border:0; width: 50%">
                        <p class="title">Billing Address</p>
                        <p style="text-transform: capitalize;">{!! $sale->user->name ?? null !!}</p>
                        <p><b>Mobile:</b> {!! $sale->user->mobile_number ?? null !!}</p>
                        <p><b>Email:</b>{!! $sale->user->email ?? null !!}</p>
                        <p><b>Address:</b> {!! $sale->user->userDetails->mailing_address ?? null !!}</p>
                        <div class="border-right"
                             style="content: ''; position: absolute; top: 0; left: 103%; height: 100%; width: 1px; background-color: #707070;">
                        </div>
                    </td>
                    <td style="text-align: left; border:0; width: 50%">
                        <p class="title">Shipping Address</p>
                        <p style="text-transform: capitalize;">{!! $sale->customer_name ?? null !!}</p>
                        <p><b>Mobile:</b>  {!! $sale->customer_phone ?? null !!}</p>
                        <p><b>Email:</b> {!! $sale->customer_email ?? null !!}</p>
                        <p><b>Address:</b>  {!! $sale->user->ship_address ?? ($sale->user->userDetails->mailing_address ?? null) !!}</p>
                    </td>
                </tr>
            </table>
        </div>
        <div style="margin-top: 20px; padding: 10px;">
            <table>
                <thead>
                <tr>
                    <th style="text-align: center;">Description</th>
                    <th style="text-align: center;">Price</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: center;">Sub-Total</th>
                    <th style="text-align: center;">Discount</th>
                    <th style="text-align: center;">Amount</th>
                </tr>
                </thead>
                <tbody>
                @forelse($sale->items as $si => $item)
                    <tr>
                        <td style="text-align: left;">
                            {{ ++$si }}. {!!  $item->item_name !!}
                        </td>
                        <td style="text-align: right;">{{ number_format($item->price_amount, 2,'.',',') }}</td>
                        <td style="text-align: right;">{{ number_format($item->quantity, 3, '.', ',') }}</td>
                        <td style="text-align: right;">{{ number_format($item->sub_total_amount, 2,'.',',') }}</td>
                        <td style="text-align: right;">-{{ number_format($item->discount_amount, 2,'.',',') }}</td>
                        <td style="text-align: right;">{{ number_format($item->total_amount, 2,'.',',') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No Items Available</td>
                    </tr>
                @endforelse
                </tbody>
                <tfoot>
                <tr>
                    <th style="text-align: right" colspan="5">Subtotal</th>
                    <td style="text-align: right">{{ number_format($sale->sub_total_amount, 2,'.',',') }}</td>
                </tr>
                <tr>
                    <th style="text-align: right" colspan="5">Discount</th>
                    <td style="text-align: right">
                        {{ number_format($sale->discount_amount, 2,'.',',') }}
                    </td>
                </tr>
                <tr>
                    <th style="text-align: right" colspan="5">Shipping Cost</th>
                    <td style="text-align: right">
                        {{ number_format($sale->shipping_cost, 2,'.',',') }}
                    </td>
                </tr>

                <tr>
                    <th style="text-align: right" colspan="5">Total</th>
                    <td style="text-align: right">{{ number_format($sale->total_amount, 2,'.',',') }}</td>
                </tr>
                <tr>
                    <th style="text-align: right" colspan="5">Due Amount</th>
                    <td style="text-align: right">{{ number_format($sale->due_amount, 2,'.',',') }}</td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <!-- Footer -->
    <div class="footer" style="margin-top: 20px;">
        <table style="border: 0;">
            <tr>
                <td style="border: 0; padding: 0; text-align: left;">
                    Mobile: {!! $sale->user->userDetails->company->company_phone ?? null !!}</td>
                <td style="border: 0; padding: 0; text-align: center; text-transform: lowercase;">www.saifurs.com.bd
                </td>
                <td style="border: 0; padding: 0; text-align: right; text-transform: lowercase;">
                    {!! $sale->user->userDetails->company->company_email ?? null !!}
                </td>
            </tr>
        </table>
    </div>
</div>
</body>

</html>
