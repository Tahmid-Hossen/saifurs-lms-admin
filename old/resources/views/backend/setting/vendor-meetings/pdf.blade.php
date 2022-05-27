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
                $html .= '<th align="center"><b>Vendor</b></th>';
                $html .= '<th align="center"><b>Name</b></th>';
                $html .= '<th align="center"><b>Course</b></th>';
                $html .= '<th align="center"><b>Instructor</b></th>';
                $html .= '<th align="center"><b>Status</b></th>';
                $html .= '<th align="center"><b>Created At</b></th>';
            $html .= '</tr>';
        $html .= '</head>';
    if(isset($vendorMeetings) && !empty($vendorMeetings)):
        foreach($vendorMeetings as $vendorMeeting):
            $count++;
            $html .= '<tbody>';
                $html .= '<tr>';
                    $html .= '<td>'.$count.'</td>';
                    $html .= '<td>'.(isset($vendorMeeting->vendor->vendor_name)?$vendorMeeting->vendor->vendor_name:null).'</td>';
                    $html .= '<td>'.(isset($vendorMeeting->vendor_meeting_title)?$vendorMeeting->vendor_meeting_title:null).'</td>';
                    $html .= '<td>'.(isset($vendorMeeting->course->course_title)?$vendorMeeting->course->course_title:null).'</td>';
                    $html .= '<td>'.
                    (isset($vendorMeeting->instructor->userDetails->first_name)?$vendorMeeting->instructor->userDetails->first_name:null).
                    (isset($vendorMeeting->instructor->userDetails->last_name)?$vendorMeeting->instructor->userDetails->last_name:null).
                    (isset($vendorMeeting->instructor->mobile_number)?'('.$vendorMeeting->instructor->mobile_number.')':null)
                    .'</td>';
                    $html .= '<td align="center">'.$vendorMeeting->vendor_meeting_status.'</td>';
                    $html .= '<td>'.$vendorMeeting->created_at->format(config('app.date_format2')).'</td>';
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
            <tr><td align="center"><b>Vendor Meeting Report</b></td></tr>
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
    $mpdf->Output('Vendor Meeting Report.pdf', 'D');
@endphp
