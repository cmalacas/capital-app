<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', 'Api\ClientController@login');

Route::post('/reset-password', 'Api\ClientController@resetPassword');

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

    Route::get('/save-profile', 'Api\ClientController@saveProfile');

    Route::get('/invoice/{id}/pay-now', 'Api\ClientController@invoicePayNow');

    Route::get('/invoice/{id}/success', 'Api\ClientController@invoiceSuccess');

    Route::get('/invoice/{id}/failed', 'Api\ClientController@invoiceFailed');

    Route::get('/update-password', 'Api\ClientController@updatePassword');

    Route::get('/pay-via-commission', 'Api\ClientController@payViaCommission');

    Route::get('/save-scan-via-commission', 'Api\ClientController@saveScanViaCommission');

    Route::get('/transfer-funds-to-scans', 'Api\ClientController@transferFundsToScans');
 
    Route::get('/pay-now', 'Api\ClientController@payNow');

    Route::get('/save-scan', 'Api\ClientController@saveScan');

    Route::get('/topup/{id}/success', 'Api\ClientController@topUpSuccess');

    Route::get('/topup/{id}/failed', 'Api\ClientController@topUpFailed');

    Route::get('/scan-topup/{id}/success', 'Api\ClientController@scanTopUpSuccess');

    Route::get('/scan-topup/{id}/failed', 'Api\ClientController@scanTopUpFailed');

    Route::get('/{id}/renew', 'Api\ClientController@renew');

    Route::get('/pay-renew', 'Api\ClientController@payRenew');

    Route::get('/{id}/renew-success', 'Api\ClientController@renewSuccess');

    Route::get('/{id}/renew-failed', 'Api\ClientController@renewFailed');

    Route::get('/coupon', 'Api\ClientController@getCoupon');

    Route::get('/add-new-service', 'Api\ClientController@addNewService');

    Route::get('/pay-new-service', 'Api\ClientController@payNewService');

    Route::get('/{id}/new-service-success', 'Api\ClientController@newServiceSuccess');

    Route::get('/company-information/{id}/edit', 'Api\ClientController@getCompanyInformation');

    Route::get('/save-company-information', 'Api\ClientController@saveCompanyInformation');

    Route::get('/save-new-account', 'Api\ClientController@saveNewAccount');

    Route::get('/service/{id}/details', 'Api\ClientController@serviceDetails');

    Route::get('/save-token', 'Api\ClientController@saveToken');

});
