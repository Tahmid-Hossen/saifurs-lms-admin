<?php


namespace App\Services;


use Illuminate\Support\Facades\Log;

class ShortMessageService
{
    /**
     * Notification configuration.
     *
     * @var array
     */
    private $config;

    /**
     * Notification Url.
     *
     * @var string
     */
    private $apiUrl;

    private $status = 'sandbox';

    /**
     * ShortMessageService constructor.
     */
    public function __construct()
    {
        $this->config = config('short-message-service');
        if ($this->config['mode'] === 'sandbox') {
            $this->status = 'sandbox';
            $this->apiUrl = $this->config[$this->status]['server_url'];

        } else {
            $this->status = 'live';
            $this->apiUrl = $this->config[$this->status]['server_url'];
        }
    }

    /**
     * @param $text
     * @param $number
     * @return bool|string
     */
    public function sendSms($text, $number)
    {
        if (substr($number, 0, 2) == "88"):
            $mobile_num = str_replace('88', '88', $number);
        elseif (substr($number, 0, 3) == "+88"):
            $mobile_num = str_replace('+88', '88', $number);
        else:
            $mobile_num = $number;
        endif;
        if ($mobile_num != null):
            $data= array(
                'username'=>$this->config[$this->status]['username'],
                'password'=>$this->config[$this->status]['password'],
                'number'=>$mobile_num,
                'message'=>$text
            );
           \Log::info('sms send message: ' . json_encode($data));
            // Open connection
            $ch = curl_init();

            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Execute post
            $result = curl_exec($ch);
            Log::info('sms send message: ' . json_encode($result));
            $explode_result = explode('|', $result);
            $return_result['status'] = true;
            if ($result === false) {
                $return_result['status'] = false;
                Log::info('Curl failed: ' . curl_error($ch));
            }
            $return_result['status_code'] = $explode_result[0];
            $return_result['message'] = $this->smsResponseMessage($explode_result[0]);
            $return_result['operator_transaction_id'] = $explode_result[1];
            $return_result['total_sms_send'] = $explode_result[2];

            // Close connection
            curl_close($ch);
        else:
            $return_result['status'] = false;
            $return_result['message'] = 'Empty Number or Number is Invalid';
        endif;
        Log::info('sms send message: ' . json_encode($return_result));
        return $return_result;
    }

    /**
     * @param $responseCode
     * @return string
     */
    public function smsResponseMessage($responseCode): string
    {
        $sms_response=array(
            1000 => 'Invalid user or Password',
            1002 => 'Empty Number',
            1003 => 'Invalid message or empty message',
            1004 => 'Invalid number',
            1005 => 'All Number is Invalid',
            1006 => 'insufficient Balance',
            1009 => 'Inactive Account',
            1010 => 'Max number limit exceeded',
            1101 => 'Success',
        );

        return $sms_response[$responseCode];
    }
}
