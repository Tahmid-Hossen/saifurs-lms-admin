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
                $html .= '<th align="center"><b>User</b></th>';
                $html .= '<th align="center"><b>Course</b></th>';
                $html .= '<th align="center"><b>Course Batch</b></th>';
                $html .= '<th align="center"><b>Status</b></th>';
                $html .= '<th align="center"><b>Created At</b></th>';
            $html .= '</tr>';
        $html .= '</head>';
    if(isset($enrollments) && !empty($enrollments)):
        foreach($enrollments as $enrollment):
            $count++;
            $html .= '<tbody>';
                $html .= '<tr>';
                    $html .= '<td>'.$count.'</td>';
                    $html .= '<td>'.(isset($enrollment->company->company_name) ? strtoupper($enrollment->company->company_name):null).'</td>';
                    $html .= '<td>'.(isset($enrollment->user->name) ? strtoupper($enrollment->user->name):null).'</td>';
                    $html .= '<td>'.(isset($enrollment->course->course_title) ? strtoupper($enrollment->course->course_title):null).'</td>';
                    $html .= '<td>'.(isset($enrollment->courseBatch->course_batch_name) ? strtoupper($enrollment->courseBatch->course_batch_name):null).'</td>';
                    $html .= '<td align="center">'.(isset($enrollment->enroll_status) ? str_replace("-","",$enrollment->enroll_status) : null).'</td>';
                    $html .= '<td>'.\Carbon\Carbon::parse($enrollment->created_at)->format('M d, Y h:i:s A').'</td>';
                $html .= '</tr>';
            $html .= '</tbody>';
        endforeach;
    endif;
    $html .= '</table>';
    $html .= '</body>';
    $html .= '</html>';
    $file_name = 'Course-Enrollment-Report-For-'.date('F-Y').'.xls';
    /*header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$file_name");*/
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
    header('Content-Disposition: attachment;filename='.$file_name); // specify the download file name
    header('Cache-Control: max-age=0');
    echo $html;
@endphp
