<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('GetContacts/{fname}','talevationSyncController@GetContactData');
Route::post('PostContacts','talevationSyncController@PostContactData');
Route::get('InvoiceData/{customer_id}','talevationSyncController@GetInvoiceData');
Route::post('PutContactData','talevationSyncController@PutContactData');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('testInvoice', 'ApiTestController@createSalesReceiptAPI');
Route::get('shlorder/{contactId}', 'talevationSyncController@getContactId');

Route::get('stripePayout', 'StripePayoutController@stripePayout');
