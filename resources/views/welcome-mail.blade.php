@extends('layouts.mail')

@section('title', 'Registration Confirmation')

@section('content')
    <tr>
        <td align="center"
            style="font-size:0px;padding:10px 25px;padding-bottom:40px;word-break:break-word;">

            <div
                style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:26px;font-weight:bold;line-height:1;text-align:center;color:#555;">
                Welcome {{ $user->name }}
            </div>

        </td>
    </tr>
    <tr>
        <td align="center" style="font-size:0px;padding:10px 25px;word-break:break-word;">
            <div
                style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;text-align:left;color:#555;">
                Thank you for registering with us. We welcome you on S@ifur's online Learning Management System. You can explore
                very attractive course, books and much more while visiting our site.
            </div>
        </td>
    </tr>
    <tr>
        <td align="center"
            style="font-size:0px;padding:10px 25px;padding-top:30px;padding-bottom:40px;word-break:break-word;">

            <table align="center" border="0" cellpadding="0" cellspacing="0" role="presentation"
                   style="border-collapse:separate;line-height:100%;">
                <tr>
                    <td align="center" bgcolor="#2F67F6" role="presentation"
                        style="border:none;border-radius:3px;color:#ffffff;cursor:auto;padding:15px 25px;"
                        valign="middle">
                        <a href="https://www.saifurs.com.bd" style="background:#2F67F6;color:#ffffff;font-family:'Helvetica Neue',Arial,sans-serif;font-size:15px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;">
                            S@ifurs
                        </a>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td align="center" style="font-size:0px;padding:10px 25px;padding-bottom:40px;word-break:break-word;">
            <div style="font-family:'Helvetica Neue',Arial,sans-serif;font-size:16px;line-height:22px;text-align:center;color:#555;">
                <a href="https://www.saifurs.com.bd/courses" style="color:#2F67F6">Try Our Latest Courses</a>
            </div>

        </td>
    </tr>
@endsection
