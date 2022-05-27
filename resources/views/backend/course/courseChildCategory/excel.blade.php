@php
    use Carbon\Carbon;env('DEBUGBAR_ENABLED', false);
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
                $html .= '<th align="center"><b>Course Category</b></th>';
                $html .= '<th align="center"><b>Course Sub Category</b></th>';
                $html .= '<th align="center"><b>Course Child Category Title</b></th>';
                $html .= '<th align="center"><b>Status</b></th>';
                $html .= '<th align="center"><b>Featured</b></th>';
                $html .= '<th align="center"><b>Created At</b></th>';
            $html .= '</tr>';
        $html .= '</head>';
    if(isset($course_child_categories) && !empty($course_child_categories)):
        foreach($course_child_categories as $course_child_category):
            $count++;
            $html .= '<tbody>';
                $html .= '<tr>';
                    $html .= '<td>'.$count.'</td>';
                    $html .= '<td>'.(isset($course_child_category) ? ($course_child_category->company->company_name):null).'</td>';
                    $html .= '<td>'.(isset($course_child_category) ? $course_child_category->courseCategory->course_category_title:null).'</td>';
                    $html .= '<td>'.(isset($course_child_category) ? $course_child_category->courseSubCategory->course_sub_category_title:null).'</td>';
                    $html .= '<td>'.($course_child_category->course_child_category_title).'</td>';
                    $html .= '<td align="center">'.$course_child_category->course_child_category_status.'</td>';
                    $html .= '<td align="center">'.$course_child_category->course_child_category_featured.'</td>';
                    $html .= '<td>'.Carbon::parse($course_child_category->created_at)->format('M d, Y h:i:s A').'</td>';

                $html .= '</tr>';
            $html .= '</tbody>';
        endforeach;
    endif;
    $html .= '</table>';
    $html .= '</body>';
    $html .= '</html>';
    $file_name = 'Course-Child-Category-Report-For-'.date('F-Y').'.xls';
    /*header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$file_name");*/
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
    header('Content-Disposition: attachment;filename='.$file_name); // specify the download file name
    header('Cache-Control: max-age=0');
    echo $html
@endphp
