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
                $html .= '<th align="center"><b>Name</b></th>';
                $html .= '<th align="center"><b>Address</b></th>';
                $html .= '<th align="center"><b>Mobile</b></th>';
                $html .= '<th align="center"><b>Phone</b></th>';
                $html .= '<th align="center"><b>Latitude</b></th>';
                $html .= '<th align="center"><b>Longitude</b></th>';
                $html .= '<th align="center"><b>Status</b></th>';
                $html .= '<th align="center"><b>Created At</b></th>';
            $html .= '</tr>';
        $html .= '</head>';
    if(isset($branches) && !empty($branches)):
        foreach($branches as $branch):
            $count++;
            $html .= '<tbody>';
                $html .= '<tr>';
                    $html .= '<td>'.$count.'</td>';
                    $html .= '<td>'.$branch->company_name.'</td>';
                    $html .= '<td>'.$branch->branch_name.'</td>';
                    $html .= '<td>'.$branch->branch_address.'</td>';
                    $html .= '<td>'.$branch->branch_mobile.'</td>';
                    $html .= '<td>'.$branch->branch_phone.'</td>';
                    $html .= '<td>'.$branch->branch_latitude.'</td>';
                    $html .= '<td>'.$branch->branch_longitude.'</td>';
                    $html .= '<td align="center">'.$branch->branch_status.'</td>';
                    $html .= '<td>'.$branch->created_at->format(config('app.date_format2')).'</td>';
                $html .= '</tr>';
            $html .= '</tbody>';
        endforeach;
    endif;
    $html .= '</table>';
    $html .= '</body>';
    $html .= '</html>';
    $file_name = 'Branch-Report-For-'.date('F-Y').'.xls';
    /*header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$file_name");*/
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
    header('Content-Disposition: attachment;filename='.$file_name); // specify the download file name
    header('Cache-Control: max-age=0');
    echo $html;
@endphp
