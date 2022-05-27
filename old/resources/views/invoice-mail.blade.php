@extends('layouts.mail')

@section('title', 'Order Invoice')

@section('content')


    <tr>
        <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">

            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:bold;line-height:22px;text-align:center;color:#525252;">
                Thank you for your order
            </div>

        </td>
    </tr>

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">

            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:14px;line-height:22px;text-align:left;color:#525252;">
                <p>Hi {!! $sale->user->name ?? null !!},</p>

                <p>Greetings from S@ifur's!<br>
                    We would like to inform you that your invoice for
                    order #{!! $sale->transaction_id ?? null!!} is attached along with this email.</p>
            </div>
        </td>
    </tr>

{{--    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">

            <table 0="[object Object]" 1="[object Object]" 2="[object Object]" border="0" style="cellspacing:0;color:#000;font-family:'Helvetica Neue',Arial,sans-serif;font-size:13px;line-height:22px;table-layout:auto;width:100%;">
                <tr style="border-bottom:1px solid #ecedee;text-align:left;">
                    <th style="padding: 0 15px 10px 0;">Item</th>
                    <th style="padding: 0 15px;">Qt.</th>
                    <th style="padding: 0 0 0 15px;" align="right">Price</th>
                </tr>
                <tr>
                    <td style="padding: 5px 15px 5px 0;">Item number 1</td>
                    <td style="padding: 0 15px;">1</td>
                    <td style="padding: 0 0 0 15px;" align="right">$100,00</td>
                </tr>
                <tr>
                    <td style="padding: 0 15px 5px 0;">Shipping + Handling</td>
                    <td style="padding: 0 15px;">1</td>
                    <td style="padding: 0 0 0 15px;" align="right">$10,00</td>
                </tr>
                <tr style="border-bottom:2px solid #ecedee;text-align:left;padding:15px 0;">
                    <td style="padding: 0 15px 5px 0;">Sales Tax</td>
                    <td style="padding: 0 15px;">1</td>
                    <td style="padding: 0 0 0 15px;" align="right">$10,00</td>
                </tr>
                <tr style="border-bottom:2px solid #ecedee;text-align:left;padding:15px 0;">
                    <td style="padding: 5px 15px 5px 0; font-weight:bold">TOTAL</td>
                    <td style="padding: 0 15px;"></td>
                    <td style="padding: 0 0 0 15px; font-weight:bold" align="right">$120,00</td>
                </tr>
            </table>

        </td>
    </tr>--}}

    <tr>
        <td align="left" style="font-size:0px;padding:10px 25px;word-break:break-word;">

            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:12px;line-height:16px;text-align:left;color:#a2a2a2;">
                Note: <p>{{ $sale->notes ?? 'N/A' }}</p>
            </div>

        </td>
    </tr>

    <tr>
        <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">

            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:24px;font-weight:bold;line-height:22px;text-align:center;color:#525252;">
                Let us know your experience
            </div>

        </td>
    </tr>

    <tr>
        <td align="center" style="font-size:0px;padding:10px 25px;padding-top:30px;padding-bottom:50px;word-break:break-word;">

            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse:separate;line-height:100%;">
                <tr>
                    <td align="center" bgcolor="#2F67F6" role="presentation" style="border:none;border-radius:3px;color:#ffffff;cursor:auto;padding:15px 25px;" valign="middle">
                        <p style="background:#2F67F6;color:#ffffff;font-family:'Helvetica Neue',Arial,sans-serif;font-size:15px;font-weight:normal;line-height:120%;Margin:0;text-decoration:none;text-transform:none;">
                            <a href="https://www.saifurs.com.bd/purchase-history/details/{{ $sale->id }}" style="color:#fff; text-decoration:none">
                                Check Purchase Status</a>
                        </p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>

@endsection

{{--
Hello  Mr./Mrs. ,<br><br>

Greetings from S@ifur's!<br>

We would like to inform you that your invoice for
order #{!! $sale->transaction_id ?? null!!} is attached along with this email.<br>

If you need any further assistance, please contact us.<br>

Thank you for purchasing from S@ifur's.
--}}
