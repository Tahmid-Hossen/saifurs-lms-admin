@php
    use Carbon\Carbon;use Mpdf\Mpdf;env('DEBUGBAR_ENABLED', false);
    error_reporting(0);
    ini_set("memory_limit","-1");
    ini_set('max_execution_time', 300);
    ini_set("pcre.backtrack_limit", "9999999");
    $html = ' ';
    $count=0;
    $html .= '<html>';
    $html .= '<style></style>';
    $html .= '<body>';
    $html .= '<table width="100%" style="padding: 2px; font-size:12px;" cellpadding="0" cellspacing="0" border="1">';
        $html .= '<thead>';
            $html .= '<tr>';
                $html .= '<th align="center"><b>SL#</b></th>';
                $html .= '<th align="center"><b>Company</b></th>';
                $html .= '<th align="center"><b>Course Option</b></th>';
                $html .= '<th align="center"><b>Course Category</b></th>';
                $html .= '<th align="center"><b>Course Sub Category</b></th>';
                $html .= '<th align="center"><b>Course Child Category</b></th>';
                $html .= '<th align="center"><b>Course Title</b></th>';
                $html .= '<th align="center"><b>Course Type</b></th>';
                $html .= '<th align="center"><b>Status</b></th>';
                $html .= '<th align="center"><b>Featured</b></th>';
                $html .= '<th align="center"><b>Created At</b></th>';
            $html .= '</tr>';
        $html .= '</head>';
    if(isset($courses) && !empty($courses)):
        foreach($courses as $course):
            $count++;
            $html .= '<tbody>';
                $html .= '<tr>';
                    $html .= '<td>'.$count.'</td>';
                    $html .= '<td>'.(isset($course) ? mb_strtoupper($course->company->company_name):null).'</td>';
                    if(isset($course->course_option) && isset($course->course_type)):  
                    $html .= '<td>'.$course->course_option.'->'.$course->course_type.'</td>';
                    elseif(isset($course->course_option) && $course->course_option == 'Offline'): 
                    $html .= '<td>'.$course->course_option.'</td>';
                    endif;
                    $html .= '<td>'.(isset($course) ? mb_strtoupper($course->courseCategory->course_category_title):null).'</td>';
                    $html .= '<td>'.(isset($course) ? mb_strtoupper($course->courseSubCategory->course_sub_category_title):null).'</td>';
                    $html .= '<td>'.(isset($course) ? mb_strtoupper($course->courseChildCategory->course_child_category_title):null).'</td>';
                    $html .= '<td>'.mb_strtoupper($course->course_title).'</td>';
                    $html .= '<td>'.mb_strtoupper($course->course_content_type).'</td>';
                    $html .= '<td align="center">'.str_replace("-","",$course->course_status).'</td>';
                    $html .= '<td align="center">'.$course->course_featured.'</td>';
                    $html .= '<td>'.Carbon::parse($course->created_at)->format('M d, Y h:i:s A').'</td>';

                    // $html .= '<td>'.$user->created_at->format(config('app.date_format2')).'</td>';
                $html .= '</tr>';
            $html .= '</tbody>';
        endforeach;
    endif;
    $html .= '</table>';
    $html .= '</body>';
    $html .= '</html>';
    $mpdfConfig = array(
        'mode' => 'utf-8',
        'format' => 'A4',
        'margin_header' => 4,     // 30mm not pixel
        'margin_footer' => 5,     // 10mm
        'margin_left' => 25,     // 10mm
        'margin_right' => 8,     // 10mm
        'orientation' => 'L',
        'setAutoTopMargin' => 'stretch'
    );
    $mpdf = new Mpdf($mpdfConfig);
    $mpdf->autoScriptToLang = true;
    $mpdf->autoLangToFont   = true;

    $mpdf->SetFont('helvetica');
/*    $company_logo = isset(auth()->user()->userDetails->company)?'./'.auth()->user()->userDetails->company->company_logo:config("app.report_pdf_image");
            <tr><td align="center"><img src="'.$company_logo.'" width="50" alt=""></td></tr>
*/    $mpdf->SetHTMLHeader('
        <table width="100%">

            <tr><td align="center"><b>'.config("app.address").'</b></td></tr>
            <tr><td align="center"><b>Course List</b></td></tr>
        </table><br><br>
    ');
    $mpdf->AddPage('L', 'A4');

    $mpdf->SetHTMLFooter('
        <table width="100%" style="font-size:8px;">
            <tr>
                <td width="50%" align="left">Printing Date Time :  {DATE j-m-Y H:i A}</td>
                <td width="50%" align="right">Page {PAGENO}/{nbpg}</td>
            </tr>
        </table>
    ');
    $mpdf->WriteHTML(($html));
    $mpdf->Output('Course Report For '.date('F Y').'.pdf', 'D')
@endphp
