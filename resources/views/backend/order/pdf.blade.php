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
                $html .= '<th align="center"><b>Company</b></th>';
                $html .= '<th align="center"><b>Class</b></th>';
                $html .= '<th align="center"><b>Course</b></th>';
                $html .= '<th align="center"><b>Course Batch</b></th>';
                $html .= '<th align="center"><b>Quiz URL</b></th>';
                $html .= '<th align="center"><b>Score</b></th>';
                $html .= '<th align="center"><b>Pass Mark</b></th>';
                $html .= '<th align="center"><b>Status</b></th>';
                $html .= '<th align="center"><b>Created At</b></th>';
            $html .= '</tr>';
        $html .= '</head>';
    if(isset($results) && !empty($results)):
        foreach($results as $result):
            $count++;
            $html .= '<tbody>';
                $html .= '<tr>';
                    $html .= '<td>'.$count.'</td>';
                    $html .= '<td>'.(isset($result) ? strtoupper($result->company->company_name):null).'</td>';
                    $html .= '<td>'.(isset($result) ? strtoupper($result->courseClass->class_name):null).'</td>';
                    $html .= '<td>'.(isset($result) ? strtoupper($result->course->course_title):null).'</td>';
                    $html .= '<td>'.(isset($result) ? strtoupper($result->courseBatch->course_batch_name):null).'</td>';
                    $html .= '<td>'.(isset($result) ? strtoupper($result->quiz->quiz_topic):null).'</td>';
                    $html .= '<td>'.(isset($result) ? strtoupper($result->quiz->quiz_type):null).'</td>';
                    $html .= '<td>'.$result->total_score.'</td>';
                    $html .= '<td>'.$result->pass_score.'</td>';
                    $html .= '<td align="center">'.str_replace("-","",$result->result_status).'</td>';
                    $html .= '<td>'.\Carbon\Carbon::parse($result->created_at)->format('M d, Y h:i:s A').'</td>';
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
    $company_logo = isset(auth()->user()->userDetails->company)?'./'.auth()->user()->userDetails->company->company_logo:config("app.report_pdf_image");
    $mpdf->SetHTMLHeader('
        <table width="100%">
            <tr><td align="center"><img src="'.$company_logo.'" width="50" alt=""></td></tr>
            <tr><td align="center"><b>'.config("app.address").'</b></td></tr>
            <tr><td align="center"><b>Quiz Result List For '.date('F Y').'</b></td></tr>
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
    $mpdf->Output('Quiz Result Report For '.date('F Y').'.pdf', 'D');
@endphp
