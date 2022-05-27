@php
    use Mpdf\Mpdf;env('DEBUGBAR_ENABLED', false);
    error_reporting(0);
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 300);
    ini_set('pcre.backtrack_limit', '9999999');
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
    $mpdfConfig = [
        'mode' => 'utf-8',
        'format' => 'A4',
        'margin_header' => 4, // 30mm not pixel
        'margin_footer' => 5, // 10mm
        'margin_left' => 25, // 10mm
        'margin_right' => 8, // 10mm
        'orientation' => 'L',
        'setAutoTopMargin' => 'stretch',
    ];
    $mpdf = new Mpdf($mpdfConfig);
    $mpdf->autoScriptToLang = true;
    $mpdf->autoLangToFont = true;

    $mpdf->SetFont('helvetica');

/*    $company_logo = isset(auth()->user()->userDetails->company) ? './' . auth()->user()->userDetails->company->company_logo : config('app.report_pdf_image');
                    <tr><td align="center"><img src="' .
            $company_logo .
            '" width="50" alt=""></td></tr>
    */    $mpdf->SetHTMLHeader(
        '
                <table width="100%">

                    <tr><td align="center"><b>' .
            config('app.address') .
            '</b></td></tr>
                    <tr><td align="center"><b>Quiz Report For ' .
            date('F Y') .
            '</b></td></tr>
                </table><br><br>
            ',
    );
    $mpdf->AddPage('L', 'A4');

    $mpdf->SetHTMLFooter('
                <table width="100%" style="font-size:8px;">
                    <tr>
                        <td width="50%" align="left">Printing Date Time :  {DATE j-m-Y H:i A}</td>
                        <td width="50%" align="right">Page {PAGENO}/{nbpg}</td>
                    </tr>
                </table>
            ');
    $mpdf->WriteHTML($html);
    $mpdf->Output('Course-Rating-Report-For-' . date('F Y') . '.pdf', 'D')
@endphp
