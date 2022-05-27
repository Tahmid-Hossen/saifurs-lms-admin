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
    $html .= '<table width="100%" style="padding: 5px; font-size:16px; margin-bottom: 15px" cellpadding="1" cellspacing="1" border="1">';
        $html .= '<thead>';
            $html .= '<tr>';
                $html .= '<th align="center" style="padding: 5px 0px 0px 15px; color:rgb(55, 22, 201)" colspan="2"><b>RESULT DETAILS</b></th>';                
            $html .= '</tr>';
        $html .= '</thead>';
            $count++;
            $html .= '<tbody>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 7px;"><b>SL#</b></th>';
                    $html .= '<td style="padding-bottom: 7px;">'.'000'.$count.'</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 7px;"><b>Company</b></th>';
                    $html .= '<td style="padding-bottom: 7px;">'.(isset($result) ? strtoupper($result->company->company_name):null).'</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 7px;"><b>Class</b></th>';
                    $html .= '<td style="padding-bottom: 7px;">'.(isset($result) ? strtoupper($result->courseClass->class_name):null).'</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 7px;"><b>Course</b></th>';
                    $html .= '<td style="padding-bottom: 7px;">'.(isset($result) ? strtoupper($result->course->course_title):null).'</td>';
                $html .= '</tr>';
                $html .= '<tr>';    
                    $html .= '<th align="left" style="padding-bottom: 7px;"><b>Course Batch</b></th>';
                    $html .= '<td style="padding-bottom: 7px;">'.(isset($result) ? strtoupper($result->courseBatch->course_batch_name):null).'</td>';
                $html .= '</tr>';
                $html .= '<tr>';    
                    $html .= '<th align="left" style="padding-bottom: 5px;"><b>Quiz</b></th>';
                    $html .= '<td style="padding-bottom: 7px;">'.(isset($result) ? strtoupper($result->quiz->quiz_topic):null).'</td>';
                $html .= '</tr>';
                <!-- $html .= '<tr>';  
                    $html .= '<th align="left" style="padding-bottom: 7px;"><b>Result Title</b></th>';  
                    $html .= '<td align="left" style="padding-bottom: 7px;">'.(isset($result) ? strtoupper($result->result_title):'N/A').'</td>';
                $html .= '</tr>'; -->
                $html .= '<tr>';  
                    $html .= '<th align="left" style="padding-bottom: 7px;"><b>Score</b></th>';  
                    $html .= '<td align="left" style="padding-bottom: 7px;">'.(isset($result) ? strtoupper($result->total_score):'N/A').'</td>';
                $html .= '</tr>';
                $html .= '<tr>';  
                    $html .= '<th align="left" style="padding-bottom: 7px;"><b>Pass Mark</b></th>';  
                    $html .= '<td align="left" style="padding-bottom: 7px;">'.(isset($result) ? strtoupper($result->pass_score):'N/A').'</td>';
                $html .= '</tr>';
                $html .= '<tr>';  
                    $html .= '<th align="left" style="padding-bottom: 7px;"><b>Status</b></th>';  
                    $html .= '<td align="left" style="padding-bottom: 7px;">'.str_replace("-","",$result->result_status).'</td>';
                $html .= '</tr>';
                $html .= '<tr>'; 
                    $html .= '<th align="left" style="padding-bottom: 7px;"><b>Created By</b></th>';   
                    $html .= '<td style="padding-bottom: 7px;">'.(isset($result) ? strtoupper($result->createdBy->name):'N/A').'</td>';
                $html .= '</tr>';
            $html .= '</tbody>';
    $html .= '</table>';
    $html .= '<hr style="height: 10px" width="100px">';
    $html .= '<table width="100%" style="padding: 5px; font-size:16px; margin-top: 18px" cellpadding="1" cellspacing="1" border="1">';
        $html .= '<thead>';
            $html .= '<tr>';
                $html .= '<th align="center" style="padding: 5px 0px 0px 15px; color:rgb(55, 22, 201)" colspan="2"><b>USER DETAILS</b></th>';                
            $html .= '</tr>';
        $html .= '</thead>';
            $count++;
            $html .= '<tbody>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 7px;"><b>Name </b></th>';
                    $html .= '<td style="padding-bottom: 7px;">'.(isset($result) ? strtoupper($result->user->name):null).'</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 7px;"><b>Email </b></th>';
                    $html .= '<td style="padding-bottom: 7px;">'.(isset($result) ? strtoupper($result->user->email):null).'</td>';
                $html .= '</tr>';
                $html .= '<tr>';
                    $html .= '<th align="left" style="padding-bottom: 7px;"><b>Mobile </b></th>';
                    $html .= '<td style="padding-bottom: 7px;">'.(isset($result) ? strtoupper($result->user->mobile_number):null).'</td>';
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
        'margin_left' => 20,     // 10mm
        'margin_right' => 10,     // 10mm
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
            <tr><td align="center" style="font-size: 18px"><b>Result Details For '.strtoupper($result->user->name).'</b></td></tr>
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
    $mpdf->Output('000'.$result->id.'-Result Details For '.date('F Y').'.pdf', 'D');
@endphp
