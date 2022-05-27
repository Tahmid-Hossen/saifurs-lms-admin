<?php

namespace App\Mail;

use App\Models\Backend\Sale\Sale;
use Exception;
use Illuminate\Mail\Mailable;
use Mpdf\MpdfException;

class SaleInvoiceMail extends Mailable
{
    /**
     * @var Sale
     */
    public $sale;

    /**
     * @var string
     */
    public $type;

    /**
     * Create a new message instance.
     *
     * @param Sale $sale
     * @param string $type
     */
    public function __construct(Sale $sale, string $type)
    {
        $this->sale = $sale;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     * @throws MpdfException|Exception
     */
    public function build(): self
    {
        try {
            error_reporting(0);
            ini_set('memory_limit', '-1');
            ini_set('max_execution_time', 300);
            ini_set('pcre.backtrack_limit', '9999999');

            $mpdfConfig = array(
                'mode' => 'utf-8',
                'format' => 'A4',
                'margin_header' => 8,     // 30mm not pixel
                'margin_footer' => 8,     // 10mm
                'margin_left' => 8,     // 10mm
                'margin_right' => 8,     // 10mm
                'orientation' => 'P',
                'setAutoTopMargin' => 'stretch'
            );
            $mpdf = new \Mpdf\Mpdf($mpdfConfig);
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->showImageErrors = true;
            $mpdf->curlAllowUnsafeSslRequests = true;
            $mpdf->allow_charset_conversion = true;
            $mpdf->charset_in = 'utf-8';

            $mpdf->SetFont('helvetica');
            $mpdf->AddPage('P', 'A4');
            $mpdf->SetHTMLFooter('<table width="100%" style="font-size:8px;">
                <tr>
                    <td width="50%" align="left">Generated on :  {DATE d/m/Y H:i A}</td>
                </tr>
            </table>');
            $mpdf->WriteHTML(view('invoice-pdf', ['sale' => $this->sale, 'type' => $this->type]));

            return $this->subject('Order Confirmation')
                ->view('invoice-mail', ['sale' => $this->sale, 'type' => $this->type])
                ->attachData($mpdf->Output('invoice.pdf', 'S'), 'invoice.pdf', [
                    'mime' => 'application/pdf',
                ]);

        } catch (Exception $exception) {
            \Log::error("Invoice Mail Error: " . $exception->getMessage());
            return $this;
        }
    }
}
