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
                $html .= '<th align="center"><b>Member Id</b></th>';
                $html .= '<th align="center"><b>Full Name</b></th>';
                $html .= '<th align="center"><b>Mobile</b></th>';
                $html .= '<th align="center"><b>Gender</b></th>';
                $html .= '<th align="center"><b>Role</b></th>';
                $html .= '<th align="center"><b>Enrollment Date</b></th>';
                $html .= '<th align="center"><b>Joining Date</b></th>';
                $html .= '<th align="center"><b>Status</b></th>';
                $html .= '<th align="center"><b>Created At</b></th>';
            $html .= '</tr>';
        $html .= '</head>';
    if(isset($userDetails) && !empty($userDetails)):
        foreach($userDetails as $user):
            $count++;
            $html .= '<tbody>';
                $html .= '<tr>';
                    $html .= '<td>'.$count.'</td>';
                    $html .= '<td>'.$user->user->username.'</td>';
                    $html .= '<td>'.$user->user->name.'</td>';
                    $html .= '<td>'.$user->mobile_phone.'</td>';
                    $html .= '<td>'.strtoupper($user->gender).'</td>';
                    $html .= '<td>'.(isset($user) ? $user->user->roles[0]->name:null).'</td>';
                    $html .= '<td>'.\Carbon\Carbon::parse($user->date_of_enrollment)->format('M d, Y').'</td>';
                    $html .= '<td>'.\Carbon\Carbon::parse($user->created_at)->format('M d, Y h:i:s A').'</td>';
                    $html .= '<td align="center">'.$user->user->status.'</td>';
                    $html .= '<td>'.$user->created_at->format(config('app.date_format2')).'</td>';
                $html .= '</tr>';
            $html .= '</tbody>';
        endforeach;
    endif;
    $html .= '</table>';
    $html .= '</body>';
    $html .= '</html>';

    $file_name = 'User-Details-Report-For-'.date('F-Y').'.xls';
    /*header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$file_name");*/
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
    header('Content-Disposition: attachment;filename='.$file_name); // specify the download file name
    header('Cache-Control: max-age=0');
    echo $html;
@endphp
