@php
env('DEBUGBAR_ENABLED', false);
$html = ' ';
$count = 0;
$html .= '<html>';
$html .= '<style></style>';
$html .= '<body>';
$html .= '<html>';
$html .= '<style></style>';
$html .= '<body>';
$html .= '<table width="100%" style="padding: 2px; font-size:12px;" cellpadding="0" cellspacing="0" border="1">';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th align="center"><b>SL</b></th>';
$html .= '<th align="center"><b>Event Title</b></th>';
$html .= '<th align="center"><b>Event URL</b></th>';
$html .= '<th align="center"><b>Event Starts</b></th>';
$html .= '<th align="center"><b>Event Ends</b></th>';
$html .= '</tr>';
$html .= '</head>';
if (isset($events) && !empty($events)):
    foreach ($events as $event):
        $count++;
        $html .= '<tbody>';
        $html .= '<tr>';
        $html .= '<td>' . $count . '</td>';
        $html .= '<td>' . $event->event_title . '</td>';
        $html .= '<td>' . $event->event_link . '</td>';
        $html .= '<td>' . $event->event_start . '</td>';
        $html .= '<td>' . $event->event_end . '</td>';
        $html .= '</tr>';
        $html .= '</tbody>';
    endforeach;
endif;
$html .= '</table>';
$html .= '</body>';
$html .= '</html>';
$file_name = 'Event-Report-For-' . date('F-Y') . '.xls';
/*header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition: attachment; filename=$file_name");*/
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
header('Content-Disposition: attachment;filename=' . $file_name); // specify the download file name
header('Cache-Control: max-age=0');
echo $html;
@endphp
