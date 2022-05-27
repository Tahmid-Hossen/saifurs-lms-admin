<?php


namespace App\Http\Controllers\Api\V1;


use App\Models\Backend\Setting\CatalogList;
use App\Services\UtilityService;
use Illuminate\Http\JsonResponse;

class UtilityController
{
    /**
     * @return JsonResponse
     */
    public function statusText(): JsonResponse
    {
        $data = array();
        $data[] = array('id'=>'', 'value'=>'Select');
        foreach (UtilityService::$statusText as $key=>$value):
            $data[] = array('id'=>$key, 'value'=>$value);
        endforeach;

        return response()->json($data);
    }

    /**
     * @return JsonResponse
     */
    public function marriedStatus(): JsonResponse
    {
        $data = array();
        $data[] = array('id'=>'', 'value'=>'Select Marital Status');
        foreach (UtilityService::$marriedStatus as $key=>$value):
            $data[] = array('id'=>$key, 'value'=>$value);
        endforeach;

        return response()->json($data);
    }

    /**
     * @return JsonResponse
     */
    public function sslCommerceCredential(): JsonResponse
    {
        $data = array();
        $this->config = config('sslcommerz');
        if ($this->config['mode'] === 'sandbox') {
            $data['api_domain'] = $this->config['sandbox']['api_domain'];
            $data['store_id'] = $this->config['sandbox']['store_id'];
            $data['store_password'] = $this->config['sandbox']['store_password'];
            $data['make_payment'] = $this->config['sandbox']['make_payment'];
            $data['transaction_status'] = $this->config['sandbox']['transaction_status'];
            $data['order_validate'] = $this->config['sandbox']['order_validate'];
            $data['refund_payment'] = $this->config['sandbox']['refund_payment'];
            $data['refund_status'] = $this->config['sandbox']['refund_status'];
            $data['is_localhost'] = $this->config['sandbox']['is_localhost'];
            $data['success_url'] = $this->config['sandbox']['success_url'];
            $data['failed_url'] = $this->config['sandbox']['failed_url'];
            $data['cancel_url'] = $this->config['sandbox']['cancel_url'];
            $data['ipn_url'] = $this->config['sandbox']['ipn_url'];
        } else {
            $data['api_domain'] = $this->config['live']['api_domain'];
            $data['store_id'] = $this->config['live']['store_id'];
            $data['store_password'] = $this->config['live']['store_password'];
            $data['make_payment'] = $this->config['live']['make_payment'];
            $data['transaction_status'] = $this->config['live']['transaction_status'];
            $data['order_validate'] = $this->config['live']['order_validate'];
            $data['refund_payment'] = $this->config['live']['refund_payment'];
            $data['refund_status'] = $this->config['live']['refund_status'];
            $data['is_localhost'] = $this->config['live']['is_localhost'];
            $data['success_url'] = $this->config['live']['success_url'];
            $data['failed_url'] = $this->config['live']['failed_url'];
            $data['cancel_url'] = $this->config['live']['cancel_url'];
            $data['ipn_url'] = $this->config['live']['ipn_url'];
        }
        return response()->json($data);
    }

}
