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
    $html .= '<table width="100%" style="padding: 5px; font-size:16px; margin-bottom: 15px" cellpadding="0" cellspacing="0" border="0">';
        $html .= '<thead>';
            $html .= '<tr>';
                $html .= '<th align="center" style="padding-bottom: 15px; color:rgb(55, 22, 201)"><b>ENROLL DETAILS</b></th>';
            $html .= '</tr>';
        $html .= '</thead>';
            $count++;
            $html .= '<tbody>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 5px;"><b>SL#</b></th>';
                    $html .= '<td style="padding-bottom: 5px;">'.'000'.$count.'</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 5px;"><b>Company</b></th>';
                    $html .= '<td style="padding-bottom: 5px;">'.(isset($enrollment) ? strtoupper($enrollment->company->company_name):null).'</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 5px;"><b>Course</b></th>';
                    $html .= '<td style="padding-bottom: 5px;">'.(isset($enrollment) ? strtoupper($enrollment->course->course_title):null).'</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 5px;"><b>Course Batch</b></th>';
                    $html .= '<td style="padding-bottom: 5px;">'.(isset($enrollment) ? strtoupper($enrollment->courseBatch->course_batch_name):null).'</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 5px;"><b>Status</b></th>';
                    $html .= '<td align="left" style="padding-bottom: 5px;">'.str_replace("-","",$enrollment->enroll_status).'</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 5px;"><b>Created By</b></th>';
                    $html .= '<td style="padding-bottom: 5px;">'.(isset($enrollment) ? strtoupper($enrollment->createdBy->name):'N/A').'</td>';
                $html .= '</tr>';
            $html .= '</tbody>';
    $html .= '</table>';
    $html .= '<hr style="height: 10px">';
    $html .= '<table width="100%" style="padding: 5px; font-size:16px; margin-top: 18px" cellpadding="0" cellspacing="0" border="0">';
        $html .= '<thead>';
            $html .= '<tr>';
                $html .= '<th align="center" style="padding-bottom: 15px; color:rgb(55, 22, 201)"><b>USER DETAILS</b></th>';
            $html .= '</tr>';
        $html .= '</thead>';
            $count++;
            $html .= '<tbody>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 5px;"><b>Name </b></th>';
                    $html .= '<td style="padding-bottom: 5px;">'.(isset($enrollment) ? strtoupper($enrollment->user->name):null).'</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 5px;"><b>Email </b></th>';
                    $html .= '<td style="padding-bottom: 5px;">'.(isset($enrollment) ? strtoupper($enrollment->user->email):null).'</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 5px;"><b>Mobile </b></th>';
                    $html .= '<td style="padding-bottom: 5px;">'.(isset($enrollment) ? strtoupper($enrollment->user->mobile_number):null).'</td>';
                $html .= '</tr>';
            $html .= '</tbody>';
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
        'orientation' => 'P',
        'setAutoTopMargin' => 'stretch'
    );
    $mpdf = new \Mpdf\Mpdf($mpdfConfig);
    $mpdf->autoScriptToLang = true;
    $mpdf->autoLangToFont   = true;

    $mpdf->SetFont('helvetica');
    $company_logo = isset(auth()->user()->userDetails->company)?'./'.auth()->user()->userDetails->company->company_logo:config("app.report_pdf_image");
    $mpdf->SetHTMLHeader('
        <table width="100%">
            <tr><td align="center"><img src="'.$company_logo.'" width="100" height="100" alt=""></td></tr>
            <tr><td align="center"><b>'.config("app.address").'</b></td></tr>
            <tr><td align="center" style="font-size: 18px"><b>Enrollment Details For '.strtoupper($enrollment->user->name).'</b></td></tr>
        </table><br><br>
        <p>Date: {DATE j-m-Y H:i A}</p>
    ');
    $mpdf->AddPage('P', 'A4');

    $mpdf->SetHTMLFooter('
        <table width="100%" style="font-size:8px;">
            <tr>
                <td width="50%" align="left">Printing Date Time :  {DATE j-m-Y H:i A}</td>
                <td width="50%" align="right">Page {PAGENO}/{nbpg}</td>
            </tr>
        </table>
    ');
    $mpdf->WriteHTML(($html));
    $mpdf->Output('000'.$enrollment->id.'-Enrollment Details For '.date('F Y').'.pdf', 'D');
@endphp
