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
$html .= '<th align="center"><b>Announcement Title</b></th>';
$html .= '<th align="center"><b>Course Title</b></th>';
$html .= '<th align="center"><b>Announcement Status</b></th>';
$html .= '<th align="center"><b>Created At</b></th>';
$html .= '</tr>';
$html .= '</head>';
if (isset($datas) && !empty($datas)):
    foreach ($datas as $data):
        $count++;
        $html .= '<tbody>';
        $html .= '<tr>';
        $html .= '<td>' . $count . '</td>';
        $html .= '<td>' . $data->announcement_title . '</td>';
        $html .= '<td>' . $data->course->course_title . '</td>';
        $html .= '<td>' . $data->announcement_status . '</td>';
        $html .= '<td>' . $data->created_at->format(config('app.date_format2')) . '</td>';
        $html .= '</tr>';
        $html .= '</tbody>';
    endforeach;
endif;
$html .= '</table>';
$html .= '</body>';
$html .= '</html>';

$file_name = 'Announcements-Report-For-' . date('F-Y') . '.xls';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename=' . $file_name);
header('Cache-Control: max-age=0');
echo $html;
@endphp
