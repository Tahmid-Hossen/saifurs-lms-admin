@extends('layouts.mail')
@section('title', 'Email Verification')

@section('content')

    <tr>
        <td align="center" style="font-size:0px;padding:10px 25px;padding-bottom:40px;word-break:break-word;">

            <div
                style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:32px;font-weight:bold;line-height:1;text-align:center;color:#555;">
                Please confirm your email
            </div>

        </td>
    </tr>
    <tr>
        <td align="center" style="font-size:0px;padding:10px 25px;padding-bottom:20px;word-break:break-word;">

            <div
                style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;text-align:center;color:#555;">

                We just need to verify your email address before you can checkout or use our services.
                Please validate your email address using this One Time Pin (OTP) below.
            </div>

        </td>
    </tr>

    <tr>
        <td align="center"
            style="font-size:0px;padding:10px 25px;padding-top:30px;padding-bottom:40px;word-break:break-word;">

            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                   style="border-collapse:separate;line-height:100%;">
                <tr>
                    <td align="center" role="presentation"
                        style="border:none;border-radius:3px;color:#ffffff;cursor:auto;padding:15px 25px;"
                        valign="middle">
                        <p style="color:#2F67F6;letter-spacing:1rem; font-family:'Helvetica Neue',Arial,sans-serif;font-size:3rem;font-weight:bolder;line-height:120%;Margin:0;text-decoration:none;text-transform:none;">
                            {{ $otp }}
                        </p>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
@endsection
