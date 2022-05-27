@php
    env('DEBUGBAR_ENABLED', false);
    $html = ' ';
    $count=0;
    $html .= '<html>';
    $html .= '<style></style>';
    $html .= '<body>';
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
    $file_name = 'Quiz-Result-Report-For-'.date('F-Y').'.xls';
    /*header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$file_name");*/
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
    header('Content-Disposition: attachment;filename='.$file_name); // specify the download file name
    header('Cache-Control: max-age=0');
    echo $html;
@endphp
