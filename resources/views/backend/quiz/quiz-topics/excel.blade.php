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
$html .= '<th align="center"><b>Quiz Topic</b></th>';
$html .= '<th align="center"><b>Quiz URL</b></th>';
$html .= '<th align="center"><b>Quiz Type</b></th>';
$html .= '<th align="center"><b>Full Mark</b></th>';
$html .= '<th align="center"><b>Course Title</b></th>';
$html .= '<th align="center"><b>Status</b></th>';
$html .= '<th align="center"><b>Created</b></th>';
$html .= '</tr>';
$html .= '</head>';
if (isset($datas) && !empty($datas)):
    foreach ($datas as $data):
        $count++;
        $html .= '<tbody>';
        $html .= '<tr>';
        $html .= '<td>' . $count . '</td>';
        $html .= '<td>' . $data->quiz_topic . '</td>';
        $html .= '<td>' . $data->quiz_url . '</td>';
        $html .= '<td align="center">' . $data->quiz_type . '</td>';
        $html .= '<td align="center">' . $data->quiz_full_marks . '</td>';
        $html .= '<td align="center">' . $data->course_title . '</td>';
        $html .= '<td align="center">' . $data->quiz_status . '</td>';
        $html .= '<td align="center">' . $data->created_at->format('j M,Y H:i A') . '</td>';
        $html .= '</tr>';
        $html .= '</tbody>';
    endforeach;
endif;
$html .= '</table>';
$html .= '</body>';
$html .= '</html>';

$file_name = 'Quiz-Report-For-' . date('F-Y') . '.xls';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $file_name);
header('Cache-Control: max-age=0');
echo $html;
@endphp
