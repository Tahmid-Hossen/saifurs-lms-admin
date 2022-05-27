<?php

namespace App\Services;

/**
 * Class SSLCommerzService
 * @package App\Services
 */
class SSLCommerzService
{
    /**
     * SSL  PROPERTIES
     */
    public $safeMode = true;

    public $api_url = null;
    public $store_id;
    public $store_passwd;
    public $total_amount;
    public $currency;
    public $tran_id;
    public $success_url;
    public $fail_url;
    public $cancel_url;
    public $ipn_url;
    public $multi_card_name;
    public $allowed_bin;
    public $emi_option;
    public $emi_max_inst_option;
    public $emi_allow_only;
    public $cus_name;
    public $cus_email;
    public $cus_add1;
    public $cus_add2;
    public $cus_city;
    public $cus_state;
    public $cus_postcode;
    public $cus_country;
    public $cus_phone;
    public $cus_fax;
    public $shipping_method;
    public $num_of_item;
    public $ship_name;
    public $ship_add1;
    public $ship_add2;
    public $ship_city;
    public $ship_state;
    public $ship_postcode;
    public $ship_country;
    public $product_name;
    public $product_category;
    public $product_profile;
    public $hours_till_departure;
    public $flight_type;
    public $pnr;
    public $journey_from_to;
    public $third_party_booking;
    public $hotel_name;
    public $length_of_stay;
    public $check_in_time;
    public $hotel_city;
    public $product_type;
    public $topup_number;
    public $country_topup;
    public $cart;
    public $product_amount;
    public $vat;
    public $discount_amount;
    public $convenience_fee;
    public $value_a;
    public $value_b;
    public $value_c;
    public $value_d;
    /**
     * @var mixed
     */
    private $is_localhost;
    /**
     * @var mixed|string
     */
    private $apiUrl;


    /**
     * SslCommerz constructor.
     */
    public function __construct(bool $safeMode = true)
    {
        $this->config = config('sslcommerz');
        if ($this->config['mode'] === 'sandbox') {
            $this->status = 'sandbox';
            $this->setApiUrl($this->config[$this->status]['api_domain']);
            $this->setStoreId($this->config[$this->status]['store_id']);
            $this->setStorePassword($this->config[$this->status]['store_password']);
            $this->is_localhost = $this->config[$this->status]['is_localhost'];
        } else {
            $this->status = 'live';
            $this->setApiUrl($this->config[$this->status]['api_domain']);
            $this->setStoreId($this->config[$this->status]['store_id']);
            $this->setStorePassword($this->config[$this->status]['store_password']);
            $this->is_localhost = $this->config[$this->status]['is_localhost'];
        }

    }

    public function setStoreId($storeID)
    {
        $this->store_id = $storeID;
    }

    public function getStoreId()
    {
        return $this->store_id;
    }

    public function setStorePassword($storePassword)
    {
        $this->store_passwd = $storePassword;
    }

    public function getStorePassword()
    {
        return $this->store_passwd;
    }

    public function setApiUrl($url)
    {
        $this->api_url = $url;
    }

    public function getApiUrl()
    {
        return $this->api_url;
    }

    public function setSuccessUrl(string $successUrl)
    {
        $this->success_url = url('/') . ($successUrl ?? $this->config[$this->status]['success_url']);
    }

    public function getSuccessUrl(): ?string
    {
        return $this->success_url;
    }

    public function setFailedUrl(string $failedUrl = null)
    {
        $this->fail_url = url('/') . ($failedUrl ?? $this->config[$this->status]['failed_url']);
    }

    public function getFailedUrl(): string
    {
        return $this->fail_url;
    }

    public function setCancelUrl(string $cancelUrl = null)
    {
        $this->cancel_url = url('/') . ($cancelUrl ?? $this->config[$this->status]['cancel_url']);
    }

    public function getCancelUrl(): string
    {
        return $this->cancel_url;
    }

    public function setIpnUrl(string $ipnUrl = null)
    {
        $this->ipn_url = url('/') . ($ipnUrl ?? $this->config[$this->status]['ipn_url']);
    }

    public function getIpnUrl(): string
    {
        return $this->ipn_url;
    }

    /**
     * SSL Chained Methods
     */


    public function currency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    public function amount($amount)
    {
        $this->total_amount = $amount;
        return $this;
    }

    public function transaction_id($trxid = null)
    {
        $this->tran_id = is_null($trxid) ? uniqid() : $trxid;
        return $this;
    }

    /**
     * @param $input
     *
     * For Transaction Query API
     *
     * ['transaction_id'] Transaction id for system provided transaction_id
     * ['sessionkey'] System Session id for collect db stored session_id
     *
     * For Refund API
     * ['bank_tran_id'] System Session id for collect db stored session_id
     * ['refund_amount'] System Session id for collect db stored session_id
     * ['refund_remarks'] System Session id for collect db stored session_id
     * ['refund_ref_id'] System Session id for collect db stored session_id
     * @return array
     * @throws \Exception
     */
    public function transactionQuery($input): array
    {
        $url = $this->config[$this->status]['transaction_status'];
        $data = array();
        if (isset($input['bank_tran_id'])):
            $data['bank_tran_id'] = $input['bank_tran_id'];
        endif;
        if (isset($input['transaction_id'])):
            $data['tran_id'] = $input['transaction_id'];
        endif;
        if (isset($input['session_id'])):
            $data['sessionkey'] = $input['session_id'];
        endif;
        if (isset($input['refund_amount'])):
            $data['refund_amount'] = $input['refund_amount'];
        endif;
        if (isset($input['refund_remarks'])):
            $data['refund_remarks'] = $input['refund_remarks'];
        endif;
        if (isset($input['refe_id'])):
            $data['refe_id'] = $input['refe_id'];
        endif;
        if (isset($input['refund_ref_id'])):
            $data['refund_ref_id'] = $input['refund_ref_id'];
        endif;
        return $this->getData($url, $data);
    }

    /**
     * Base function that is responsible for interacting directly with the sslcommerz api to obtain data
     * @param $url
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function getData($url, array $params = []): array
    {
        $apiUrl = $this->getApiUrl() . $url . '?';
        $params['store_id'] = $this->getStoreId();
        $params['store_passwd'] = $this->getStorePassword();
        $apiUrl .= http_build_query($params);
        \Log::info($apiUrl);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                //'Authorization: Credentials ' . $this->config[$this->status]['api_token']
            )
        );

        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        $error = curl_error($curl);

        if ($response === false) {
            \Log::info($info);
            \Log::info($error);
            throw new \Exception(curl_error($curl), curl_errno($curl));
        }

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        \Log::info(json_decode($response, true));
        return [
            'status' => $status,
            'response' => json_decode($response, true)
        ];

    }


    /********************************** DO NOT TOUCH THIS CODE WITHOUT CONCERN *****************************************/
    /**
     * TODO NOT FOR NOW
     *
     * HAFIZ
     *
     */
    /**
     * @param array $requestData
     * @param string $type
     * @param array $header
     * @return false|mixed|string
     */
    public function makePayment(array $requestData, string $type = 'checkout', array $header = [])
    {
        if (empty($requestData)) {
            return "Please provide a valid information list about transaction with transaction id, amount, success url, fail url, cancel url, store id and pass at least";
        }

        $url = $this->config[$this->status]['make_payment'];

        $this->apiUrl = $this->getApiUrl() . $url . '?';

        // Now, call the Gateway API
        $response = $this->callToApi($requestData, $header, $this->config[$this->status]['is_localhost']);

        $formattedResponse = $this->formatResponse($response, $type); // Here we will define the response pattern

        return $formattedResponse;
        /*if ($type == 'hosted') {
            if (isset($formattedResponse['GatewayPageURL']) && $formattedResponse['GatewayPageURL'] != '') {
                $this->redirect($formattedResponse['GatewayPageURL']);
            } else {
                $errorMessage = "No redirect URL found!";
                return $errorMessage;
            }
        } else {
            return $formattedResponse;
        }*/
    }


    /**
     * Tested only for make payment
     *
     * @param $data
     * @param array $header
     * @param bool $setLocalhost
     * @return bool|string
     */
    public function callToApi($data, array $header = [], bool $setLocalhost = false)
    {
        $curl = curl_init();

        if (!$setLocalhost) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // The default value for this option is 2. It means, it has to have the same name in the certificate as is in the URL you operate against.
        } else {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // When the verify value is 0, the connection succeeds regardless of the names in the certificate.
        }

        curl_setopt($curl, CURLOPT_URL, $this->apiUrl);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlErrorNo = curl_errno($curl);
        curl_close($curl);

        if ($code == 200 & !($curlErrorNo)) {
            return $response;
        } else {
            //return "FAILED TO CONNECT WITH SSLCOMMERZ API";
            return "cURL Error #:" . $err;
        }
    }


    /**
     * Tested only for make payment
     *
     * @param $response
     * @param string $type
     * @return false|mixed|string
     */
    public function formatResponse($response, string $type = 'checkout')
    {
        \Log::info("SSL Response:");
        \Log::info($response);

        $sslcz = json_decode($response, true);

        if ($type != 'checkout') {
            return $sslcz;
        } else {
            if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
                // this is important to show the popup, return or echo to send json response back
                if ($this->getApiUrl() != null && $this->getApiUrl() == 'https://securepay.sslcommerz.com') {
                    $response = json_encode(['status' => 'SUCCESS', 'data' => $sslcz['GatewayPageURL'], 'logo' => $sslcz['storeLogo']]);
                } else {
                    $response = json_encode(['status' => 'success', 'data' => $sslcz['GatewayPageURL'], 'logo' => $sslcz['storeLogo']]);
                }
            } else {
                $response = json_encode(['status' => 'fail', 'data' => null, 'message' => $sslcz['failedreason']]);
            }

            return $response;
        }
    }

    public function postData(array $data = [])
    {
        $body['store_id'] = $data['store_id'] ?? $this->config[$this->status]['store_id'];
        $body['store_passwd'] = $this->store_passwd;
        $body['total_amount'] = $this->total_amount;
        $body['currency'] = $this->currency;
        $body['tran_id'] = $this->tran_id;

        $body['success_url'] = $this->success_url;
        $body['fail_url'] = $this->fail_url;
        $body['cancel_url'] = $this->cancel_url;
        $body['ipn_url'] = $this->ipn_url;

        $body['multi_card_name'] = $this->multi_card_name;
        $body['allowed_bin'] = $this->allowed_bin;

        $body['emi_option'] = $this->emi_option;
        $body['emi_max_inst_option'] = $this->emi_max_inst_option;
        $body['emi_selected_inst'] = $this->emi_selected_inst;
        $body['emi_allow_only'] = $this->emi_allow_only;

        $body['cus_name'] = $this->cus_name;
        $body['cus_email'] = $this->cus_email;
        $body['cus_add1'] = $this->cus_add1;
        $body['cus_add2'] = $this->cus_add2;
        $body['cus_city'] = $this->cus_city;
        $body['cus_state'] = $this->cus_state;
        $body['cus_postcode'] = $this->cus_postcode;
        $body['cus_country'] = $this->cus_country;
        $body['cus_phone'] = $this->cus_phone;
        $body['cus_fax'] = $this->cus_fax;

        $body['shipping_method'] = $this->shipping_method;
        $body['num_of_item'] = $this->num_of_item;
        $body['ship_name'] = $this->ship_name;
        $body['ship_add1'] = $this->ship_add1;
        $body['ship_add2'] = $this->ship_add2;
        $body['ship_city'] = $this->ship_city;
        $body['ship_state'] = $this->ship_state;
        $body['ship_postcode'] = $this->ship_postcode;
        $body['ship_country'] = $this->ship_country;

        $body['product_name'] = $this->product_name;
        $body['product_category'] = $this->product_category;
        $body['product_profile'] = $this->product_profile;

        $body['hours_till_departure'] = $this->hours_till_departure;
        $body['flight_type'] = $this->flight_type;
        $body['pnr'] = $this->pnr;
        $body['journey_from_to'] = $this->journey_from_to;
        $body['third_party_booking'] = $this->third_party_booking;

        $body['hotel_name'] = $this->hotel_name;
        $body['length_of_stay'] = $this->length_of_stay;
        $body['check_in_time'] = $this->check_in_time;
        $body['hotel_city'] = $this->hotel_city;

        $body['product_type'] = $this->product_type;
        $body['topup_number'] = $this->topup_number;
        $body['country_topup'] = $this->country_topup;

        $body['cart'] = $this->cart;
        $body['product_amount'] = $this->product_amount;
        $body['vat'] = $this->vat;
        $body['discount_amount'] = $this->discount_amount;
        $body['convenience_fee'] = $this->convenience_fee;

        $body['value_a'] = $this->value_a;
        $body['value_b'] = $this->value_b;
        $body['value_c'] = $this->value_c;
        $body['value_d'] = $this->value_d;

        return $body;
    }


    /**
     * @param array $input
     * @return array
     */
    public static function convertSSLResponseToTransaction(array $input): array
    {
        return [
            'sale_id' => null,
            'transaction_no' => $input['tran_id'],
            'amount' => $input['amount'] ?? 0,
            'payment_method' => $input['card_type'],
            'transaction_status' => self::convertSSLStatus($input['status']),
            'payment_gateway_response' => json_encode($input)
        ];
    }

    /**
     * @param string $status
     * @return string
     */
    public static function convertSSLStatus(string $status): string
    {
        switch ($status) {
            case 'VALID' :
            case 'SUCCESS':
                return 'paid';
            default :
                return 'unpaid';
        }
    }
}
