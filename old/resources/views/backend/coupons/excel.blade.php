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
$html .= '<th><b>Coupon Title</b></th>';
$html .= '<th align="center"><b>Coupon Code</b></th>';
$html .= '<th align="center"><b>Validity Starts</b></th>';
$html .= '<th align="center"><b>Validity Ends</b></th>';
$html .= '<th align="center"><b>Status</b></th>';
$html .= '<th align="center"><b>Created At</b></th>';
$html .= '</tr>';
$html .= '</thead>';
if (isset($datas) && !empty($datas)):
    foreach ($datas as $data):
        $count++;
        $html .= '<tbody>';
        $html .= '<tr>';
        $html .= '<td>' . $count . '</td>';
        $html .= '<td>' . $data->coupon_title . '</td>';
        $html .= '<td align="center">' . $data->coupon_code . '</td>';
        $html .= '<td align="center">' . $data->coupon_start . '</td>';
        $html .= '<td align="center">' . $data->coupon_end . '</td>';
        $html .= '<td align="center">' . $data->coupon_status . '</td>';
        $html .= '<td align="center">' . $data->created_at->format(config('app.date_format2')) . '</td>';
        $html .= '</tr>';
        $html .= '</tbody>';
    endforeach;
endif;
$html .= '</table>';
$html .= '</body>';
$html .= '</html>';
$file_name = 'Coupon-Report-For-' . date('F-Y') . '.xls';
/*header("Content-type: application/vnd.ms-excel");
 header("Content-Disposition: attachment; filename=$file_name");*/
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
header('Content-Disposition: attachment;filename=' . $file_name); // specify the download file name
header('Cache-Control: max-age=0');
echo $html;
@endphp
