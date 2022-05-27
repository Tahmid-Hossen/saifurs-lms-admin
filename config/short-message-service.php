<?php
/**
 * Created by PhpStorm.
 * User: MD ARIFUL HAQUE
 * Date: 6/7/2021
 * Time: 9:33 pM
 */


return [
    'mode'  => env('SHORT_MESSAGE_MODE','sandbox'),
    'sandbox' => [
        'server_url'    => env( 'SHORT_MESSAGE_URL', 'http://66.45.237.70/api.php'),
        'username'    => env( 'SHORT_MESSAGE_USERNAME', 'Saifurs101'),
        'password'    => env( 'SHORT_MESSAGE_PASSWORD', 'Saifurs@2021dm#'),
    ],
    'live' => [
        'server_url'    => env( 'SHORT_MESSAGE_URL', 'http://66.45.237.70/api.php'),
        'username'    => env( 'SHORT_MESSAGE_USERNAME', 'Saifurs101'),
        'password'    => env( 'SHORT_MESSAGE_PASSWORD', 'Saifurs@2021dm#'),
    ],
];
