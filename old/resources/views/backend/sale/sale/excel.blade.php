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
    $html .= '<th align="center"><b>Sale Title</b></th>';
    $html .= '<th align="center"><b>Edition</b></th>';
    $html .= '<th align="center"><b>Author</b></th>';
    $html .= '<th align="center"><b>Contributors</b></th>';
    $html .= '<th align="center"><b>Category</b></th>';
    $html .= '<th align="center"><b>Publish Date</b></th>';
    $html .= '<th align="center"><b>Language</b></th>';
    $html .= '<th align="center"><b>Short Description</b></th>';
    $html .= '<th align="center"><b>Status</b></th>';
    $html .= '<th align="center"><b>Created At</b></th>';
    $html .= '</tr>';
    $html .= '</thead>';
    if (isset($books) && !empty($books)):
        $html .= '<tbody>';
            foreach ($books as $si => $book):
            $html .= '<tr>';
            $html .= '<td>' . (++$si) . '</td>';
            $html .= '<td><b>' . $book->book_name . '</b></td>';
            $html .= '<td>' . $book->edition . '</td>';
            $html .= '<td>' . $book->author . '</td>';
            $html .= '<td>' . $book->contributor . '</td>';
            $html .= '<td>' . $book->category->book_category_name . '</td>';
            $html .= '<td>' . $book->publish_date->format('d F, Y'). '</td>';
            $html .= '<td>' . (\Utility::$languageList[$book->language]) . '</td>';
            $html .= '<td width="20%">' . substr(html_entity_decode($book->book_description), 0, 50) . '</td>';
            $html .= '<td align="center">' . $book->book_status . '</td>';
            $html .= '<td>' . $book->created_at->format(config('app.date_format2')) . '</td>';
            $html .= '</tr>';
            $html .= '</tbody>';
        endforeach;
        $html.='</tbody>';
    endif;
    $html .= '</table>';
    $html .= '</body>';
    $html .= '</html>';


    $file_name = 'Sales-Report-For-'.date('F-Y').'.xls';
    header("Content-type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=$file_name");
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); // header for .xlxs file
    header('Content-Disposition: attachment;filename='.$file_name); // specify the download file name
    header('Cache-Control: max-age=0');
    echo $html;
@endphp
