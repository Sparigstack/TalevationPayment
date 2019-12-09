<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Invoice;
use App\InvoiceItem;
use Session;
use Stripe;
use App\Utility;
use App\QbToken;
use Illuminate\Support\Facades\Route;

class StripePaymentController extends Controller {

    public function payment() {
        $currentPath = '';
        $currentRoute = Route::getFacadeRoot()->current()->uri();
        if ($currentRoute == 'previewInvoice') {
            $currentPath = Route::getFacadeRoot()->current()->uri();
        }
        $invoice_by_GUID = $_GET['token'];
        $stripePaymentId = "Blank";
        $Invoice = "";
        $PaymentMethod = '';
        if (isset($_GET['token'])) {
            $invoiceData = Invoice::where('GUID', '=', $_GET['token'])->first();
            if ($invoiceData) {
                if (!isset($invoiceData->due_date)) {
                    $due_date = date("Y-m-d", strtotime(date('m/d/Y')));
                    $invoiceData->due_date = $due_date;
                    $invoiceData->save();
                }
            }

            $customer = Customer::find($invoiceData->customer_id);

            Stripe\Stripe::setApiKey("sk_test_YWrmxxCNxfB5ZHsKxbFeQzrv");
//            Stripe\Stripe::setApiKey("sk_live_8msRoMMmI8U5Ex6OCICpyOj200Ckjd3cNw");

            if (isset($customer->stripe_customer_id)) {
                $PaymentMethod = \Stripe\PaymentMethod::all([
                            'customer' => $customer->stripe_customer_id,
                            'type' => 'card',
                ]);
            }

//return $PaymentMethod." 2424 ".$currentPath." 2424 ".$invoiceData." 2424 ".$stripePaymentId." 2424 ".$Invoice;
//return view('test', compact('PaymentMethod', 'currentPath', 'invoiceData', 'stripePaymentId', 'Invoice'));
            return view('Client/stripePayment', compact('PaymentMethod', 'currentPath', 'invoiceData', 'stripePaymentId', 'Invoice'));
        }
    }

    public function paymentPlan(Request $request) {
        $flash_msg = "";
        $customerEmail = '';
        $customer_id = '';
        $appId = '';$token='';

        $QbToken = QbToken::all();
     for($i=0;$i<count($QbToken);$i++){
         $id=$QbToken[$i]->id;
         $token=$QbToken[$i]->access_token;
         $appId=$QbToken[$i]->realm_id;
         
     }
//        $token = QbToken::pluck('access_token')->first();

        Stripe\Stripe::setApiKey("sk_test_YWrmxxCNxfB5ZHsKxbFeQzrv");
//        Stripe\Stripe::setApiKey("sk_live_8msRoMMmI8U5Ex6OCICpyOj200Ckjd3cNw");
        try {
            $flash_msg .= " 1";
            $Invoice = Invoice::find($request->invoice_id);
            //$customer = Customer::find($Invoice->customer_id);

            if (!is_null($Invoice->customer->stripe_customer_id)) {
                $flash_msg .= " 2";
                $customer_id = $Invoice->customer->stripe_customer_id;
                $charge = \Stripe\Charge::create(array(
                            'customer' => $customer_id,
                            "amount" => $request->totalPrice * 100,
                            "currency" => "usd",
                            "description" => "Test payment New Created.",
                            "source" => $request->paymentMethodId
                ));
            } else {
                $flash_msg .= " 3";
                $customerDetails = \Stripe\Customer::all(['email' => $request->email]);

                if (isset($customerDetails->data[0]->email)) {
                    $flash_msg .= " 4";
                    $customerEmail = $customerDetails->data[0]->email;
                    $customer_id = $customerDetails->data[0]->id;
                } else {
                    $flash_msg .= " 5";
                    //add customer to stripe
                    $s_customer = \Stripe\Customer::create(array(
                                'email' => $request->email,
                                'name' => $request->name_on_card,
                                'source' => $request->stripeToken
                    ));
                    $customer_id = $s_customer->id;
                }
                $flash_msg .= " 6";
                $charge = \Stripe\Charge::create(array(
                            'customer' => $customer_id,
                            "amount" => $request->totalPrice * 100,
                            "currency" => "usd",
                            "description" => "Test payment."
                ));
            }







//\Stripe\Stripe::setApiKey("sk_test_YWrmxxCNxfB5ZHsKxbFeQzrv");
//
//$payment_method = \Stripe\PaymentMethod::retrieve('pm_1FIhaG2eZvKYlo2CuhOuIrG7');
//$payment_method->attach(['customer' => 'cus_Fq2eHKmW5CvSBi']);
            //$Invoice = new Invoice;

            $Invoice->exists = true;
            $Invoice->id = $request->invoice_id;
            $Invoice->stripe_payment_id = $charge->id;
            $Invoice->status = 1;
            $Invoice->save();

            $customer = new Customer;
            $customer->exists = true;
            $customer->id = $Invoice->customer_id;
            $customer->stripe_customer_id = $customer_id;
            $customer->save();

            $Amount = $request->totalPrice;
            $flash_msg .= " 7";
//            $success = "Invoice paid successfully! ";
//            Session::put('success', $success);


            if (isset($Invoice->customer->qb_customerId)) {
                $flash_msg .= " 8";
                $totalPrice = $request->totalPrice;
                $invoice_id = $request->invoice_id;
                $customerRef = $Invoice->customer->qb_customerId;
                $utility = new Utility;
                $response1 = $utility->createPaymentAPI($totalPrice, $invoice_id, $customerRef, $appId, $token);
                $flash_msg .= " 8";
            } else {
                $flash_msg .= " 9";
                //**************  Query Customer Api ****************//
                $curl = curl_init();
                $query = "select * from Customer Where PrimaryEmailAddr like '%" . $request->email . "%'";
                $query_enc = urlencode($query);
                $url = "https://sandbox-quickbooks.api.intuit.com/v3/company/" . $appId . "/query?query=" . $query_enc . "&minorversion=40";
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "Accept: application/json",
                        "Authorization: Bearer " . $token,
                        "Cache-Control: no-cache",
                        "Content-Type: application/json"
                    ),
                ));
                $response = curl_exec($curl);
                $err = curl_error($curl);
                $response = json_decode($response, true);
                //var_dump($response);
//                $QB_CustomerId = $response;
//                return $QB_CustomerId;
                if (isset($response['QueryResponse']['Customer']['0']['Id'])) {
                    $flash_msg .= " 10";
                    $QB_CustomerId = $response['QueryResponse']['Customer']['0']['Id'];
                    $Customer = new Customer;
                    $Customer->exists = true;
                    $Customer->id = $Invoice->customer_id;
                    $Customer->qb_customerId = $QB_CustomerId;
                    $Customer->save();
                    $totalPrice = $request->totalPrice;
                    $invoice_id = $request->invoice_id;
                    $customerRef = $QB_CustomerId;
                } else {
                    $flash_msg .= " 11";
                    //**************  Create Customer Api ****************//
                    //$email = array('PrimaryEmailAddr' => (object) array('Address' => $Invoice->email));
                    //$data =(object) array('DisplayName' => $Invoice->first_name . " " . $Invoice->last_name, $email);
                    $data = (object) array('DisplayName' => $request->name_on_card, 'PrimaryEmailAddr' => (object) array('Address' => $request->email));
                    $data_json = json_encode($data);

//return $data_json;

                    $curl = curl_init(); // URL of the call
                    // Disable SSL verification
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                    // Will return the response, if false it print the response
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_URL, "https://sandbox-quickbooks.api.intuit.com/v3/company/" . $appId . "/customer?minorversion=40");
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', 'Authorization: Bearer ' . $token));
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
                    $result = curl_exec($curl);
                    $response = json_decode($result, true);
//                   
                    $totalPrice = $request->totalPrice;
                    $invoice_id = $request->invoice_id;
                    $customerRef = $response['Customer']['Id'];
                    $flash_msg .= " 12";
                    $Customer = new Customer;
                    $Customer->exists = true;
                    $Customer->id = $Invoice->customer_id;
                    $Customer->qb_customerId = $customerRef;
                    $Customer->save();
                }
                $flash_msg .= " 13";
                $utility = new Utility;
                $utility->createPaymentAPI($totalPrice, $invoice_id, $customerRef, $appId, $token);
                $flash_msg .= " 14";
            }
            $stripePaymentId = $charge->id;
            $Invoice = $Invoice;
            $Amount = $Amount;
            $flash_msg .= " 15";
            //Session::flash('log_message', $flash_msg);
//            return $response1 . " bansari " . $flash_msg;
            return view('Client/paymentReceipt', compact('stripePaymentId', 'Invoice', 'Amount'));
        } catch (Exception $e) {
//            $invoiceData="";

            Session::flash('fail_message', "Error! Please Try again.");

            return redirect()->back()->with('stripePaymentId', "Blank");
        }
    }

}
