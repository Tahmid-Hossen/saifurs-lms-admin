@php
    env('DEBUGBAR_ENABLED', false);
    error_reporting(0);
    ini_set("memory_limit","-1");
    ini_set('max_execution_time', 300);
    ini_set("pcre.backtrack_limit", "9999999");
    $html = ' ';
    $count=0;
    $html .= '<html>';
    $html .= '<style></style>';
    $html .= '<body>';
    $html .= '<table width="100%" style="padding: 2px; font-size:12px;" cellpadding="0" cellspacing="0" border="1">';
        $html .= '<thead>';
            $html .= '<tr>';
                $html .= '<th align="center"><b>SL#</b></th>';
                $html .= '<th align="center"><b>Member Id</b></th>';
                $html .= '<th align="center"><b>Full Name</b></th>';
                $html .= '<th align="center"><b>Mobile</b></th>';
                $html .= '<th align="center"><b>Gender</b></th>';
                $html .= '<th align="center"><b>Role</b></th>';
                $html .= '<th align="center"><b>Enrollment Date</b></th>';
                $html .= '<th align="center"><b>Joining Date</b></th>';
                $html .= '<th align="center"><b>Status</b></th>';
                $html .= '<th align="center"><b>Created At</b></th>';
            $html .= '</tr>';
        $html .= '</head>';
    if(isset($userDetails) && !empty($userDetails)):
        foreach($userDetails as $user):
            $count++;
            $html .= '<tbody>';
                $html .= '<tr>';
                    $html .= '<td>'.$count.'</td>';
                    $html .= '<td>'.$user->user->username.'</td>';
                    $html .= '<td>'.$user->user->name.'</td>';
                    $html .= '<td>'.$user->mobile_phone.'</td>';
                    $html .= '<td>'.strtoupper($user->gender).'</td>';
                    $html .= '<td>'.(isset($user) ? $user->user->roles[0]->name:null).'</td>';
                    $html .= '<td>'.\Carbon\Carbon::parse($user->date_of_enrollment)->format('M d, Y').'</td>';
                    $html .= '<td>'.\Carbon\Carbon::parse($user->created_at)->format('M d, Y h:i:s A').'</td>';
                    $html .= '<td align="center">'.$user->user->status.'</td>';
                    $html .= '<td>'.$user->created_at->format(config('app.date_format2')).'</td>';
                $html .= '</tr>';
            $html .= '</tbody>';
        endforeach;
    endif;
    $html .= '</table>';
    $html .= '</body>';
    $html .= '</html>';
    $mpdfConfig = array(
        'mode' => 'utf-8',
        'format' => 'A4',
        'margin_header' => 4,     // 30mm not pixel
        'margin_footer' => 5,     // 10mm
        'margin_left' => 25,     // 10mm
        'margin_right' => 8,     // 10mm
        'orientation' => 'L',
        'setAutoTopMargin' => 'stretch'
    );
    $mpdf = new \Mpdf\Mpdf($mpdfConfig);
    $mpdf->autoScriptToLang = true;
    $mpdf->autoLangToFont   = true;

    $mpdf->SetFont('helvetica');
/*    $company_logo = isset(auth()->user()->userDetails->company)?'./'.auth()->user()->userDetails->company->company_logo:config("app.report_pdf_image");

            <tr><td align="center"><img src="'.$company_logo.'" width="50" alt=""></td></tr>
*/    $mpdf->SetHTMLHeader('
        <table width="100%">
            <tr><td align="center"><b>'.config("app.address").'</b></td></tr>
            <tr><td align="center"><b>Teacher For '.date('F Y').'</b></td></tr>
        </table><br><br>
    ');
    $mpdf->AddPage('L', 'A4');

    $mpdf->SetHTMLFooter('
        <table width="100%" style="font-size:8px;">
            <tr>
                <td width="50%" align="left">Printing Date Time :  {DATE j-m-Y H:i A}</td>
                <td width="50%" align="right">Page {PAGENO}/{nbpg}</td>
            </tr>
        </table>
    ');
    $mpdf->WriteHTML(($html));
    $mpdf->Output('Teacher Report For '.date('F Y').'.pdf', 'D');
@endphp
