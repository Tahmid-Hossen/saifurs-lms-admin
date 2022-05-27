@php
    env('DEBUGBAR_ENABLED', false);
    error_reporting(0);
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 300);
    ini_set('pcre.backtrack_limit', '9999999');

    $html = ' ';
    $html .= '<html> <head>';
    $html .= '<style> .table th, .table td {
  border: 1px solid black;
  padding: 3px;
  vertical-align: middle;
}
</style>';
    $html .= '</head><body>';
    $html .= '<table class="table" border="1" style="width:100%; border-collapse: collapse; ">';
    $html .= '<thead style="font-weight: bold;">';
    $html .= '<tr>';
    $html .= '<th align="center"><b>SL#</b></th>';
    $html .= '<th align="center"><b>Book Title</b></th>';
    $html .= '<th align="center"><b>Edition</b></th>';
    $html .= '<th align="center"><b>Author</b></th>';
    $html .= '<th align="center"><b>Contributors</b></th>';
    $html .= '<th align="center"><b>Category</b></th>';
    $html .= '<th align="center"><b>Publish Date</b></th>';
    $html .= '<th align="center"><b>Language</b></th>';
    $html .= '<th align="center"><b>Price</b></th>';
    $html .= '<th align="center"><b>Status</b></th>';
    $html .= '<th align="center"><b>Created At</b></th>';
    $html .= '</tr>';
    $html .= '</thead>';
    if (isset($books) && !empty($books)):
        $html .= '<tbody>';
            foreach ($books as $si => $book):
            $html .= '<tr>';
            $html .= '<td>' . (++$si) . '</td>';
            $html .= '<td>' . $book->book_name . '</td>';
            $html .= '<td>' . $book->edition . '</td>';
            $html .= '<td>' . $book->author . '</td>';
            $html .= '<td>' . $book->contributor . '</td>';
            $html .= '<td>' . $book->category->book_category_name . '</td>';
            $html .= '<td>' . $book->publish_date->format('d F, Y'). '</td>';
            $html .= '<td>' . (\Utility::$languageList[$book->language]) . '</td>';
            $html .= '<td align="center">' . (($book->is_sellable =='YES') ? round($book->book_price, 2) : 'N/A') . '</td>';
            $html .= '<td align="center">' . $book->book_status . '</td>';
            $html .= '<td>' . (\Carbon\Carbon::parse($book->created_at)->format(config('app.date_format2'))) . '</td>';
            $html .= '</tr>';
        endforeach;
        $html.='</tbody>';
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
    $mpdf = new \Mpdf\Mpdf($mpdfConfig);
    $mpdf->autoScriptToLang = true;
    $mpdf->autoLangToFont   = true;
    $mpdf->showImageErrors = true;
    $mpdf->curlAllowUnsafeSslRequests = true;
    $mpdf->allow_charset_conversion = true;
    $mpdf->charset_in = 'utf-8';

    $mpdf->SetFont('helvetica');

/*    $company_logo = isset(auth()->user()->userDetails->company) ? './'.config('app.backend_base_url') . auth()->user()->userDetails->company->company_logo : config('app.report_pdf_image');
<tr><td align="center"><img src="' .
            $company_logo .
            '" width="50" alt=""></td></tr>
*/
    $mpdf->SetHTMLHeader(
        '
            <table width="100%">

                <tr><td align="center"><b>' .
            config('app.address') .
            '</b></td></tr>
                <tr><td align="center"><b>Book Report</b></td></tr>
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
    $mpdf->Output('Book Report For ' . date('F Y') . '.pdf', 'D');
@endphp
