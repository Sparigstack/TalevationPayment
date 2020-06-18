<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

//Route::get('/test','StripePaymentController@payment');


Route::get('/', 'HomeController@invoicePage');
Route::get('/test2', function(){
    return view('test_2');
});

Auth::routes();

//Route::get('InvoiceByCustomer/{id}','InvoiceController@InvoiceByCustomer');
Route::get('InvoiceByCustomer/{id}','InvoiceController@InvoiceByCustomer');
Route::get('myInvoices/{id}','InvoiceController@myInvoices');

//Route for Invoice Page
//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('invoice2', 'HomeController@invoicePage')->name('filterInvoice');


Route::get('qbrefresh', 'HomeController@qbrefresh');
Route::post('/invoice', 'HomeController@invoicePage')->name('filterInvoice');
Route::get('invoice','HomeController@invoicePage')->name('invoice');
//Route::post('invoice','HomeController@filterInvoices')->name('invoice');

//Route for Add Invoice Page
Route::get('/addInvoice', 'InvoiceController@addInvoice');
Route::post('InsertInvoice', 'InvoiceController@InsertInvoice');
Route::post('getEmail', 'InvoiceController@fetch')->name('autocomplete.fetch');

//Route for Add Customer Page
Route::get('customer', 'CustomerController@customer');
Route::post('addCustomer', 'CustomerController@addCustomer');
Route::post('checkDuplicateEmail', 'CustomerController@checkDuplicateEmail');
Route::post('getCustomerFromdb', 'CustomerController@getCustomerFromdb');

//Route for Logout Page
Route::get('logout', 'HomeController@logout');

//Route for stripe Payment Page
Route::get('payment', 'StripePaymentController@payment');
Route::post('paymentPlan', 'StripePaymentController@paymentPlan')->name('stripe.post');
Route::post('bankPayment', 'StripePaymentController@bankPayment')->name('stripe.post1');
Route::post('achVerification', 'StripePaymentController@achVerification');
Route::post('deleteBankAccount', 'StripePaymentController@deleteBankAccount');

Route::get('verifiedBank', function (){
    return view('verifiedBank');
});
//Route::get('achVerification', function () {
//    return view('mails.mansiTestVerify1');
//});


Route::post('createPaymentAPI', 'StripePaymentController@createPaymentAPI')->name('createPaymentAPI');
Route::post('createSalesReceiptAPI', 'StripePaymentController@createSalesReceiptAPI')->name('createSalesReceiptAPI');

//Route for  saveInvoiceItems 
Route::post('saveInvoiceItems', 'InvoiceItemController@saveInvoiceItems');

//post call for marking invoice paid
Route::post('markInvoicePaid', 'InvoiceController@markInvoicePaid');

//post call for delete invoice
Route::post('deleteInvoiceWithItems', 'InvoiceController@deleteInvoice');

Route::get('qbauth', 'HomeController@qbauth');
Route::get('previewInvoice','StripePaymentController@payment');

    
Route::post('preset_line_items','InvoiceController@preset_line_items');
Route::get('invoiceReceipt/{invoice_id}/{stripe_payment_id}/{amount}', 'StripePaymentController@showReceipt');

Route::get('testInvoice', 'ApiTestController@createSalesReceiptAPI');

Route::post('sslIntegration1', 'CustomerController@sendEmail')->name('sslIntegration');
//Route::get('sslIntegration', function (){
//    return view('sslIntegration');
//});

Route::get('shlorder/{contactId}', 'talevationSyncController@shlorder');
// Route::post('croneJob', 'InvoiceController@croneJob')->name('croneJob');
// Route::get('croneJob', function (){
//    return view('croneJobPage');
// });
Route::get('recurInvoices', 'InvoiceController@recurInvoices');
// Route::get('stripePayout', 'StripePayoutController@stripePayout');
// Route::get('stripePayout', function (){
//    return view('stripePayout');
// });
Route::stripeWebhooks('stripePayout');
Route::get('payoutcheck', 'StripePaymentController@createDepositAPI');

Route::get('mansi', 'StripePaymentController@salesreceipt');
// Route::get('payoutcheck', function (){
//    return view('stripePayout');
// });