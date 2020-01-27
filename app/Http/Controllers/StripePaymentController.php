<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Customer;
use App\Invoice;
use App\InvoiceItem;
use App\StateTax;
use Session;
use Stripe;
use App\Utility;
use App\QbToken;
use Illuminate\Support\Facades\Route;
use App\Mail\Email;
use Mail;
use App\CustomClass\MailContent;

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

        $stateTaxes = new StateTax;
        $stateTaxes->state_name = 'N/A';
        $stateTaxes->tax_rate = 0;

        if (isset($_GET['token'])) {
            $invoiceData = Invoice::where('GUID', '=', $_GET['token'])->first();
            if ($invoiceData) {
                if (!isset($invoiceData->due_date)) {
                    $due_date = date("Y-m-d", strtotime(date('m/d/Y')));
                    $invoiceData->due_date = $due_date;
                    $invoiceData->save();
                }

                if (isset($invoiceData->state_tax_id)) {
                    $stateTaxes = StateTax::find($invoiceData->state_tax_id);
                }
            }
//
            $customer = Customer::find($invoiceData->customer_id);
//            var_dump($customer);
////            $stateTaxes = DB::table('state_taxes AS st')
////                    ->leftJoin('invoices AS i', 'st.id', '=', 'i.state_tax_id')
////                    ->select('st.id', 'i.state_tax_id', 'st.state_name', 'st.tax_rate')
////                    ->where('st.id', '=', $invoiceData->state_tax_id)
////                    ->first();
//
//

            if ((isset($customer->stripe_customer_id) && $customer->stripe_customer_id != '')) {
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $PaymentMethod = \Stripe\PaymentMethod::all([
                            'customer' => $customer->stripe_customer_id,
                            'type' => 'card',
                ]);
//                var_dump($PaymentMethod);
//                return;
            }
//
////return $PaymentMethod." 2424 ".$currentPath." 2424 ".$invoiceData." 2424 ".$stripePaymentId." 2424 ".$Invoice;
////return view('test', compact('PaymentMethod', 'currentPath', 'invoiceData', 'stripePaymentId', 'Invoice'));
            return view('Client/stripePayment', compact('PaymentMethod', 'currentPath', 'invoiceData', 'stateTaxes', 'stripePaymentId', 'Invoice'));
            //return view('Client/mansiTest', compact('PaymentMethod', 'currentPath', 'invoiceData', 'stateTaxes', 'stripePaymentId', 'Invoice'));
        }
    }

    public function paymentPlan(Request $request) {

        $flash_msg = "";
        $customerEmail = '';
        $customer_id = '';
        $appId = '';
        $token = '';

        $QbToken = QbToken::all();
        for ($i = 0; $i < count($QbToken); $i++) {
            $id = $QbToken[$i]->id;
            $token = $QbToken[$i]->access_token;
            $appId = $QbToken[$i]->realm_id;
        }
//        echo $token."<br/>";
//        echo $appId;
//                return;
//        $token = QbToken::pluck('access_token')->first();

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $flash_msg .= " 1";
            $Invoice = Invoice::find($request->invoice_id);
            //$customer = Customer::find($Invoice->customer_id);

            if (!is_null($Invoice->customer->stripe_customer_id)) {
                $flash_msg .= " 2";
                $customer_id = $Invoice->customer->stripe_customer_id;
                $source_id = $request->ccType == 1 ? $request->stripeSource : $request->paymentMethodId;
                $charge = \Stripe\Charge::create(array(
                            'customer' => $customer_id,
                            "amount" => $request->totalPrice * 100,
                            "currency" => "usd",
                            "description" => "Talevation new payment from " . $Invoice->customer->name,
                            "source" => $source_id
                ));
            } else {
                $flash_msg .= " 3";
                $customerDetails = \Stripe\Customer::all(['email' => $request->email]);

                //$customer_source = $request->stripeToken;

                if (isset($customerDetails->data[0]->email)) {
                    $flash_msg .= " 4";
                    $customerEmail = $customerDetails->data[0]->email;
                    $customer_id = $customerDetails->data[0]->id;

                    $card = \Stripe\Customer::createSource(
                                    $customer_id, [
                                'source' => $request->stripeSource,
                                    ]
                    );
                } else {
                    $flash_msg .= " 5";
                    //add customer to stripe
                    $s_customer = \Stripe\Customer::create(array(
                                'email' => $request->email,
                                'name' => $request->name_on_card,
                                'source' => $request->stripeSource
                    ));
                    $customer_id = $s_customer->id;
                }
                $flash_msg .= " 6";
                $charge = \Stripe\Charge::create(array(
                            'customer' => $customer_id,
                            'amount' => $request->totalPrice * 100,
                            'currency' => "usd",
                            'description' => "Talevation new payment from " . $Invoice->customer->name,
                            'source' => $request->stripeSource
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


//            echo "qbid=" . $Invoice->customer->qb_customerId;
            if (isset($Invoice->customer->qb_customerId)) {
//                echo "in createpaymentapi";
//                return;
                $flash_msg .= " 8";
                $totalPrice = $request->totalPrice;
                $invoice_id = $request->invoice_id;
                $customerRef = $Invoice->customer->qb_customerId;
//                echo $totalPrice."~~~~".$invoice_id."~~~~~~".$customerRef;
                $utility = new Utility;
                $response1 = $utility->createPaymentAPI($totalPrice, $invoice_id, $customerRef, $appId, $token);
//                var_dump($response1);
//                return;
                $flash_msg .= " 8";
            } else {
                   
                $flash_msg .= " 9";
//                    ************** Query Customer Api ****************//
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
            Session::flash('fail_message', "Error! Please Try again.");

            return redirect()->back()->with('stripePaymentId', "Blank");
        }
    }

    public function bankPayment(Request $request) {
        //email & card holder name add when customer is create    
        //$Test = $request->stripeToken;
        $Invoice = Invoice::find($request->invoice_id_verify);
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        if (!is_null($Invoice->customer->stripe_customer_id)) {
            if ($Invoice->isAchVerified == 2) {
                //retrieve stripe customer id for verification
                $retrieveCustomer = \Stripe\Customer::retrieve($Invoice->customer->stripe_customer_id);

                //get the existing bank account & check its status verified or new
                $bank_account = \Stripe\Customer::retrieveSource(
                                $retrieveCustomer->id, $retrieveCustomer->default_source
                );

                //charge create
                $charge = \Stripe\Charge::create([
                            'amount' => $request->totalPrice * 100,
                            'currency' => 'usd',
                            'customer' => $retrieveCustomer->id,
                            'source' => $retrieveCustomer->default_source
                ]);

                $Invoice = Invoice::find($request->invoice_id_verify);
                $Invoice->exists = true;
                $Invoice->id = $request->invoice_id_verify;
                $Invoice->stripe_payment_id = $charge->id;
                $Invoice->status = 1;
                $Invoice->save();

                $customer = new Customer;
                $customer->exists = true;
                $customer->id = $Invoice->customer_id;
                $customer->stripe_customer_id = $retrieveCustomer->id;
                $customer->save();

                $stripePaymentId = $charge->id;
                $Invoice = $Invoice;
                $Amount = $request->totalPrice;
                return view('Client/paymentReceipt', compact('stripePaymentId', 'Invoice', 'Amount'));
            }
            if ($Invoice->isAchVerified == 1 || $Invoice->isAchVerified == 0) {
                $Invoice->exists = true;
                $Invoice->id = $request->invoice_id_verify;
//            $Invoice->stripe_payment_id = $charge->id;
                $Invoice->isAchVerified = 1;
                $Invoice->save();

                $customer = new Customer;
                $customer->exists = true;
                $customer->id = $Invoice->customer_id;
                $customer->stripe_customer_id = $Invoice->customer->stripe_customer_id;
                $customer->save();
//                
                //mail sent
                $mail_content = new MailContent();
                $mail_content->invoiceToken = request('invoiceToken');
                $mail_content->email = request('email');
                $mail_content->price = $request->totalPrice;
                $data = ['view' => 'mails.verifyAch', 'mail_content' => $mail_content, 'bcc' => 'team.sprigstack@gmail.com', 'bccName' => 'Ronak Shah', 'subject' => 'Verify Link'];

                $emailOb = new Email($data);
//                Mail::to('team.sprigstack@gmail.com')->send($emailOb); //need to make this ID dynamic once testing is done
                return view('Client/mailNotification');
            }
        } else {
            try {
                $customerCreate = \Stripe\Customer::create([
                            'description' => $request->bankHolderName,
                            'email' => $request->email,
                            'source' => $request->stripeToken,
                ]);

                $customer_json = $customerCreate->__toJSON();
                $customer_json = json_decode($customer_json);

                $Invoice = Invoice::find($request->invoice_id_verify);
                $Invoice->exists = true;
                $Invoice->id = $request->invoice_id_verify;
//            $Invoice->stripe_payment_id = $charge->id;
                $Invoice->isAchVerified = 1;
                $Invoice->save();

                $customer = new Customer;
                $customer->exists = true;
                $customer->id = $Invoice->customer_id;
                $customer->stripe_customer_id = $customer_json->id;
                $customer->save();

                //mail sent
                $mail_content = new MailContent();
                $mail_content->invoiceToken = request('invoiceToken');
                $mail_content->email = request('email');
                $mail_content->price = $request->totalPrice;
                $data = ['view' => 'mails.verifyAch', 'mail_content' => $mail_content, 'bcc' => 'team.sprigstack@gmail.com', 'bccName' => 'Ronak Shah', 'subject' => 'Verify Link'];
                $emailOb = new Email($data);
                Mail::to('team.sprigstack@gmail.com')->send($emailOb); //need to make this ID dynamic once testing is done
                return view('Client/mailNotification');
            } catch (\Stripe\Error\Base $e) {
                echo($e->getMessage());
            }
        }
    }

    public function achVerification(Request $request) {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        //retrieve stripe customer id for verification
        $retrieveCustomer = \Stripe\Customer::retrieve($request->stripe_customer_id_verify);

        //get the existing bank account & check its status verified or new
        $bank_account = \Stripe\Customer::retrieveSource(
                        $retrieveCustomer->id, $retrieveCustomer->default_source
        );
        $status = $bank_account->status;
        if ($status == "new") {
            //verify the account 32,45
            try {
                $bank_account_verify = $bank_account->verify(['amounts' => [$request->amount1, $request->amount2]]);
            } catch (\Stripe\Error\Base $e) {
                return;
            }

            //after verification, verified status change to 2
            $invoiceAchVerified = Invoice::find($request->invoiceId);
            $invoiceAchVerified->isAchVerified = 2;
            $invoiceAchVerified->save();

            //charge create
            $charge = \Stripe\Charge::create([
                        'amount' => $request->price * 100,
                        'currency' => 'usd',
                        'customer' => $retrieveCustomer->id,
                        'source' => $retrieveCustomer->default_source
            ]);

            $Invoice = Invoice::find($request->invoiceId);
            $Invoice->exists = true;
            $Invoice->id = $request->invoiceId;
            $Invoice->stripe_payment_id = $charge->id;
            $Invoice->status = 1;
            $Invoice->save();

            $customer = new Customer;
            $customer->exists = true;
            $customer->id = $Invoice->customer_id;
            $customer->stripe_customer_id = $retrieveCustomer->id;
            $customer->save();

            $stripePaymentId = $charge->id;
            $Invoice = $Invoice;
            $Amount = $request->price;
            return view('Client/paymentReceipt', compact('stripePaymentId', 'Invoice', 'Amount'));
        } else {
            $invoiceAchVerified = Invoice::find($request->invoiceId);
            $invoiceAchVerified->isAchVerified = 2;
            $invoiceAchVerified->save();

            //charge create
            $charge = \Stripe\Charge::create([
                        'amount' => $request->price * 100,
                        'currency' => 'usd',
                        'customer' => $retrieveCustomer->id,
                        'source' => $retrieveCustomer->default_source
            ]);

            $Invoice = Invoice::find($request->invoiceId);
            $Invoice->exists = true;
            $Invoice->id = $request->invoiceId;
            $Invoice->stripe_payment_id = $charge->id;
            $Invoice->status = 1;
            $Invoice->save();

            $customer = new Customer;
            $customer->exists = true;
            $customer->id = $Invoice->customer_id;
            $customer->stripe_customer_id = $retrieveCustomer->id;
            $customer->save();

            $stripePaymentId = $charge->id;
            $Invoice = $Invoice;
            $Amount = $request->price;
            return view('Client/paymentReceipt', compact('stripePaymentId', 'Invoice', 'Amount'));
        }
    }

}
