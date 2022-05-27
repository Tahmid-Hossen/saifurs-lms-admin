@php
    use Carbon\Carbon;use Mpdf\Mpdf;env('DEBUGBAR_ENABLED', false);
    error_reporting(0);
    ini_set("memory_limit","-1");
    ini_set('max_execution_time', 300);
    ini_set("pcre.backtrack_limit", "9999999");
    $html = ' ';
    $html .= '<html> <head>';
    $html .= '<style></style>';
    $html .= '</head><body>';
    $html .= '<table width="100%" style="padding: 2px; font-size:12px;" cellpadding="0" cellspacing="0" border="1">';
    $html .= '<thead style="font-weight: bold;">';
    $html .= '<tr>';
                $html .= '<th align="center"><b>SL#</b></th>';
                $html .= '<th align="center"><b>Book</b></th>';
                $html .= '<th align="center"><b>Rating</b></th>';
                $html .= '<th align="center"><b>Comment</b></th>';
                $html .= '<th align="center"><b>Approved</b></th>';
                $html .= '<th align="center"><b>Status</b></th>';
                $html .= '<th align="center"><b>Created At</b></th>';
            $html .= '</tr>';
        $html .= '</head>';
    if(isset($bookRatingComments) && !empty($bookRatingComments)):
        foreach($bookRatingComments as $bookRatingComment):
            $count++;
            $html .= '<tbody>';
                $html .= '<tr>';
                    $html .= '<td>'.$count.'</td>';
                    $html .= '<td>'.$bookRatingComment->book_name.'</td>';
                    $html .= '<td>'.$bookRatingComment->book_rating.'</td>';
                    $html .= '<td>'.$bookRatingComment->book_comment.'</td>';
                    $html .= '<td align="center">'.$bookRatingComment->is_approved.'</td>';
                    $html .= '<td align="center">'.$bookRatingComment->book_rating_comment_status.'</td>';
                    $html .= '<td>'.$bookRatingComment->created_at->format(config('app.date_format2')).'</td>';
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
/*    $company_logo = isset(auth()->user()->userDetails->company) ? './'.config('app.backend_base_url') . auth()->user()->userDetails->company->company_logo : config('app.report_pdf_image');
            <tr><td align="center"><img src="'.$company_logo.'" width="50" alt=""></td></tr>
*/    $mpdf->SetHTMLHeader('
        <table width="100%">
            <tr><td align="center"><b>'.config("app.address").'</b></td></tr>
            <tr><td align="center"><b>Book Rating Comment Report</b></td></tr>
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
    $mpdf->Output('Book Rating Comment Report For '.date('F Y').'.pdf', 'D');
@endphp
