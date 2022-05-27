<?php

// SSLCommerz configuration

/*return [
    'projectPath' => env('PROJECT_PATH'),
    // For Sandbox, use "https://sandbox.sslcommerz.com"
    // For Live, use "https://securepay.sslcommerz.com"
    'apiDomain' => env("API_DOMAIN_URL", "https://sandbox.sslcommerz.com"),
    'apiCredentials' => [
        'store_id' => env("STORE_ID"),
        'store_password' => env("STORE_PASSWORD"),
    ],
    'apiUrl' => [
        'make_payment' => "/gwprocess/v4/api.php",
        'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
        'order_validate' => "/validator/api/validationserverAPI.php",
        'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
        'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
    ],
    'connect_from_localhost' => env("IS_LOCALHOST", true), // For Sandbox, use "true", For Live, use "false"
    'success_url' => '/success',
    'failed_url' => '/fail',
    'cancel_url' => '/cancel',
    'ipn_url' => '/ipn',
];*/

return [
    'mode'  => env('SSL_COMMERZ','sandbox'),
    'sandbox' => [
        'api_domain'            => env( 'SSL_COMMERZ_API_DOMAIN', 'https://sandbox.sslcommerz.com'),
        'store_id'              => env( 'SSL_COMMERZ_STORE_ID', 'saifu611761899e4c4'),
        'store_password'        => env( 'SSL_COMMERZ_STORE_PASSWORD', 'saifu611761899e4c4@ssl'),
        'make_payment'          => env( 'SSL_COMMERZ_MAKE_PAYMENT', '/gwprocess/v4/api.php'),
        'transaction_status'    => env( 'SSL_COMMERZ_TRANSACTION_STATUS', '/validator/api/merchantTransIDvalidationAPI.php'),
        'order_validate'        => env( 'SSL_COMMERZ_ORDER_VALIDATE', '/validator/api/validationserverAPI.php'),
        'refund_payment'        => env( 'SSL_COMMERZ_REFUND_PAYMENT', '/validator/api/merchantTransIDvalidationAPI.php'),
        'refund_status'         => env( 'SSL_COMMERZ_REFUND_STATUS', '/validator/api/merchantTransIDvalidationAPI.php'),
        'is_localhost'          => env( 'SSL_COMMERZ_IS_LOCALHOST', true),
        'success_url'           => env( 'SSL_COMMERZ_SUCCESS_URL', '/success'),
        'failed_url'            => env( 'SSL_COMMERZ_FAILED_URL', '/fail'),
        'cancel_url'            => env( 'SSL_COMMERZ_CANCEL_URL', '/cancel'),
        'ipn_url'               => env( 'SSL_COMMERZ_IPN_URL', '/ipn'),
    ],
    'live' => [
        'api_domain'            => env( 'SSL_COMMERZ_API_DOMAIN', 'https://securepay.sslcommerz.com'),
        'store_id'              => env( 'SSL_COMMERZ_STORE_ID', 'saifurscombdlive'),
        'store_password'        => env( 'SSL_COMMERZ_STORE_PASSWORD', '60D96CFEAB8DD33614'),
        'make_payment'          => env( 'SSL_COMMERZ_MAKE_PAYMENT', '/gwprocess/v4/api.php'),
        'transaction_status'    => env( 'SSL_COMMERZ_TRANSACTION_STATUS', '/validator/api/merchantTransIDvalidationAPI.php'),
        'order_validate'        => env( 'SSL_COMMERZ_ORDER_VALIDATE', '/validator/api/validationserverAPI.php'),
        'refund_payment'        => env( 'SSL_COMMERZ_REFUND_PAYMENT', '/validator/api/merchantTransIDvalidationAPI.php'),
        'refund_status'         => env( 'SSL_COMMERZ_REFUND_STATUS', '/validator/api/merchantTransIDvalidationAPI.php'),
        'is_localhost'          => env( 'SSL_COMMERZ_IS_LOCALHOST', true),
        'success_url'           => env( 'SSL_COMMERZ_SUCCESS_URL', '/success'),
        'failed_url'            => env( 'SSL_COMMERZ_FAILED_URL', '/fail'),
        'cancel_url'            => env( 'SSL_COMMERZ_CANCEL_URL', '/cancel'),
        'ipn_url'               => env( 'SSL_COMMERZ_IPN_URL', '/ipn'),
    ],
];
