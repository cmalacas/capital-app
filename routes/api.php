<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', 'Api\ClientController@login');

Route::group(['middleware' => 'auth:sanctum'], function() {

    Route::get('/accounts', 'Api\ClientController@accounts');

    Route::get('/services', 'Api\ClientController@services');

    Route::get('/post-history', 'Api\ClientController@postHistory');

    Route::get('/pay-invoice', 'Api\ClientController@payInvoice');

    Route::get('/postage-funds', 'Api\ClientController@postageFunds');

    Route::get('/payment-history', 'Api\ClientController@paymentHistory');

    Route::get('/affiliates', 'Api\ClientController@affiliates');

    Route::get('/notifications', 'Api\ClientController@notifications');

    Route::get('/invoice/{id}/pay-now', 'Api\ClientController@payNowInvoice');

    Route::post('/save-profile', 'Api\ClientController@saveProfile');

    Route::get('/invoice/{id}/pay-now', 'Api\ClientController@invoicePayNow');

    Route::get('/invoice/{id}/success', 'Api\ClientController@invoiceSuccess');

    Route::get('/invoice/{id}/failed', 'Api\ClientController@invoiceFailed');

    Route::post('/update-password', 'Api\ClientController@updatePassword');

    Route::post('/pay-via-commission', 'Api\ClientController@payViaCommission');

    Route::post('/save-scan-via-commission', 'Api\ClientController@saveScanViaCommission');

    Route::post('/transfer-funds-to-scans', 'Api\ClientController@transferFundsToScans');
 
    Route::post('/pay-now', 'Api\ClientController@payNow');

    Route::post('/save-scan', 'Api\ClientController@saveScan');

    Route::get('/topup/{id}/success', 'Api\ClientController@topUpSuccess');

    Route::get('/topup/{id}/failed', 'Api\ClientController@topUpFailed');

    Route::get('/scan-topup/{id}/success', 'Api\ClientController@scanTopUpSuccess');

    Route::get('/scan-topup/{id}/failed', 'Api\ClientController@scanTopUpFailed');

    Route::get('/{id}/renew', 'Api\ClientController@renew');

    Route::post('/pay-renew', 'Api\ClientController@payRenew');

    Route::get('/{id}/renew-success', 'Api\ClientController@renewSuccess');

    Route::get('/{id}/renew-failed', 'Api\ClientController@renewFailed');

    Route::post('/coupon', 'Api\ClientController@getCoupon');

    Route::get('/add-new-service', 'Api\ClientController@addNewService');

    Route::post('/pay-new-service', 'Api\ClientController@payNewService');

    Route::get('/{id}/new-service-success', 'Api\ClientController@newServiceSuccess');

});
