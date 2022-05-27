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
                $html .= '<th align="center"><b>Vendor</b></th>';
                $html .= '<th align="center"><b>Name</b></th>';
                $html .= '<th align="center"><b>Course</b></th>';
                $html .= '<th align="center"><b>Instructor</b></th>';
                $html .= '<th align="center"><b>Status</b></th>';
                $html .= '<th align="center"><b>Created At</b></th>';
            $html .= '</tr>';
        $html .= '</head>';
    if(isset($vendorMeetings) && !empty($vendorMeetings)):
        foreach($vendorMeetings as $vendorMeeting):
            $count++;
            $html .= '<tbody>';
                $html .= '<tr>';
                    $html .= '<td>'.$count.'</td>';
                    $html .= '<td>'.(isset($vendorMeeting->vendor->vendor_name)?$vendorMeeting->vendor->vendor_name:null).'</td>';
                    $html .= '<td>'.(isset($vendorMeeting->vendor_meeting_title)?$vendorMeeting->vendor_meeting_title:null).'</td>';
                    $html .= '<td>'.(isset($vendorMeeting->course->course_title)?$vendorMeeting->course->course_title:null).'</td>';
                    $html .= '<td>'.
                    (isset($vendorMeeting->instructor->userDetails->first_name)?$vendorMeeting->instructor->userDetails->first_name:null).
                    (isset($vendorMeeting->instructor->userDetails->last_name)?$vendorMeeting->instructor->userDetails->last_name:null).
                    (isset($vendorMeeting->instructor->mobile_number)?'('.$vendorMeeting->instructor->mobile_number.')':null)
                    .'</td>';
                    $html .= '<td align="center">'.$vendorMeeting->vendor_meeting_status.'</td>';
                    $html .= '<td>'.$vendorMeeting->created_at->format(config('app.date_format2')).'</td>';
                $html .= '</tr>';
            $html .= '</tbody>';
        endforeach;
    endif;
    $html .= '</table>';
    $html .= '</body>';
    $html .= '</html>';

    $file_name = 'Vendor-Meeting-Report.xls';
    /*header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$file_name");*/
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
    header('Content-Disposition: attachment;filename='.$file_name); // specify the download file name
    header('Cache-Control: max-age=0');
    echo $html;
@endphp
