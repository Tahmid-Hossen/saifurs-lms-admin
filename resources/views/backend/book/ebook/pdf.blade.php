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
    $html .= '<th align="center"><b>Type</b></th>';
    $html .= '<th align="center"><b>Category</b></th>';
    $html .= '<th align="center"><b>Publish Date</b></th>';
    $html .= '<th align="center"><b>Language</b></th>';
    $html .= '<th align="center"><b>Status</b></th>';
    $html .= '<th align="center"><b>Created At</b></th>';
    $html .= '</tr>';
    $html .= '</thead>';
    if (isset($books) && !empty($books)):
        $html .= '<tbody>';
            foreach ($books as $si => $book):
            $html .= '<tr>';
            $html .= '<td>' . (++$si) . '</td>';
            $html .= '<td>' . $book->ebook_name . '</td>';
            $html .= '<td>' . $book->edition . '</td>';
            $html .= '<td>' . $book->author . '</td>';
            $html .= '<td>' . $book->contributor . '</td>';
            $html .= '<td>' . $book->type->extension . '</td>';
            $html .= '<td>' . $book->category->book_category_name . '</td>';
            $html .= '<td>' . $book->publish_date->format('d F, Y'). '</td>';
            $html .= '<td>' . (\Utility::$languageList[$book->language]) . '</td>';
            $html .= '<td align="center">' . $book->ebook_status . '</td>';
            $html .= '<td>' . $book->created_at->format(config('app.date_format2')) . '</td>';
            $html .= '</tr>';
            $html .= '</tbody>';
        endforeach;
        $html.='</tbody>';
    endif;
    $html .= '</table>';
    $html .= '</body>';
    $html .= '</html>';
    $mpdfConfig = [
        'mode' => 'utf-8',
        'format' => 'A4',
        'margin_header' => 8, // 30mm not pixel
        'margin_footer' => 8, // 10mm
        'margin_left' => 8, // 10mm
        'margin_right' => 8, // 10mm
        'orientation' => 'L',
        'setAutoTopMargin' => 'stretch',
    ];
    $mpdf = new \Mpdf\Mpdf($mpdfConfig);
    $mpdf->autoScriptToLang = true;
    $mpdf->autoLangToFont = true;

    $mpdf->SetFont('helvetica');

/*    $company_logo = isset(auth()->user()->userDetails->company) ? './' . auth()->user()->userDetails->company->company_logo : config('app.report_pdf_image');
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
                <tr><td align="center"><b>EBook Report For ' .
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
    $mpdf->Output('EBooks Report For ' . date('F Y') . '.pdf', 'D');
@endphp
