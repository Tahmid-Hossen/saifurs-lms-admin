@php
    env('DEBUGBAR_ENABLED', false);
    error_reporting(0);
    ini_set('memory_limit', '-1');
    ini_set('max_execution_time', 300);
    ini_set('pcre.backtrack_limit', '9999999');

    $html = ' ';
    $count=0;
$html = ' ';
    $html .= '<html> <head>';
    $html.='<meta charset="utf-8">';
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
                $html .= '<th align="center"><b>Book</b></th>';
                $html .= '<th align="center"><b>Rating</b></th>';
                $html .= '<th align="center"><b>Comment</b></th>';
                $html .= '<th align="center"><b>Approved</b></th>';
                $html .= '<th align="center"><b>Status</b></th>';
                $html .= '<th align="center"><b>Created At</b></th>';
            $html .= '</tr>';
        $html .= '</thead>';
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
    $file_name = '>Book-Rating-Comment-Report-For-'.date('F-Y').'.xls';
    /*header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$file_name");*/
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
    header('Content-Disposition: attachment;filename='.$file_name); // specify the download file name
    header('Cache-Control: max-age=0');
    echo $html;
@endphp
