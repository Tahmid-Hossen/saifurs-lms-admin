<?php

use Illuminate\Support\Facades\Route;

Route::prefix('cron')->group(function() {
    //Check Payment transaction status
    Route::get('transaction-query', ['as' => 'transaction-query', 'uses' => 'Cron\TransactionQueryController@__invoke']);
});

