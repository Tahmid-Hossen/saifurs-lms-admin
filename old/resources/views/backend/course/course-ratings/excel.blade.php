@php
    env('DEBUGBAR_ENABLED', false);
    $html = ' ';
    $count = 0;
    $html .= '<html>';
    $html .= '<style></style>';
    $html .= '<body>';
    $html .= '<table width="100%" style="padding: 2px; font-size:12px;" cellpadding="0" cellspacing="0" border="1">';
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th align="center"><b>SL</b></th>';
    $html .= '<th align="center"><b>Course Name</b></th>';
    $html .= '<th align="center"><b>User</b></th>';
    $html .= '<th align="center"><b>Reviews</b></th>';
    $html .= '<th align="center"><b>Ratings</b></th>';
    $html .= '<th align="center"><b>Approved</b></th>';
    $html .= '<th align="center"><b>Featured</b></th>';
    $html .= '<th align="center"><b>Created</b></th>';
    $html .= '</tr>';
    $html .= '</head>';
    if (isset($datas) && !empty($datas)):
        foreach ($datas as $data):
            $count++;
            $html .= '<tbody>';
            $html .= '<tr>';
            $html .= '<td>' . $count . '</td>';
            $html .= '<td>' . $data->course->course_title . '</td>';
            $html .= '<td>' . $data->user->name . '</td>';
            $html .= '<td align="center">' . $data->course_rating_feedback . '</td>';
            $html .= '<td align="center">' . $data->course_rating_stars . '</td>';
            $html .= '<td align="center">' . $data->is_approved . '</td>';
            $html .= '<td align="center">' . $data->course->course_featured . '</td>';
            $html .= '<td align="center">' . $data->created_at->format('j M,Y H:i A') . '</td>';
            $html .= '</tr>';
            $html .= '</tbody>';
        endforeach;
    endif;
    $html .= '</table>';
    $html .= '</body>';
    $html .= '</html>';

    $file_name = 'Course-Rating-Report-For-' . date('F-Y') . '.xls';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename=' . $file_name);
    header('Cache-Control: max-age=0');
    echo $html
@endphp
