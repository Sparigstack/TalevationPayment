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
use Redirect;
use Illuminate\Support\Facades\Auth;
use QuickBooksOnline\API\DataService\DataService;
use App\Http\Controllers\OAuth2LoginHelper;

class StripePaymentController extends Controller {

    private $OAuth2LoginHelper;

    public function __construct() {

//        $this->middleware('auth');
        $utility = new \App\Utility;
        $ClientID = env('QB_APP_ID');
        $ClientSecretKey = env('QB_APP_SECRET');
        $dataService = DataService::Configure(array(
                    'auth_mode' => 'oauth2',
                    'ClientID' => $ClientID,
                    'ClientSecret' => $ClientSecretKey,
                    'RedirectURI' => $utility->projectBaseUrl() . "/public/qbauth",
//dev                    'RedirectURI' => "http://dev.sprigstack.com/TalevationPayment/public/qbauth",
//live                    'RedirectURI' => "https://talevation.com/payments/public/qbauth",
                    'scope' => "com.intuit.quickbooks.accounting",
                    'baseUrl' => "Development"
        ));
        $this->OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
    }

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
        $PaymentMethodBank = '';
        $deleteSource = '';
        $error_message = '';

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
            }

            if (isset($customer->stripe_customer_id) && $customer->stripe_customer_id != '' && $customer->isAchVerified != 0) {
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                $retrieveCustomer = \Stripe\Customer::retrieve($customer->stripe_customer_id);

                $PaymentMethodBank = \Stripe\Customer::retrieveSource(
                                $retrieveCustomer->id, $customer->stripe_source_id
                );
            }
//
////return $PaymentMethod." 2424 ".$currentPath." 2424 ".$invoiceData." 2424 ".$stripePaymentId." 2424 ".$Invoice;
////return view('test', compact('PaymentMethod', 'currentPath', 'invoiceData', 'stripePaymentId', 'Invoice'));
            return view('Client/stripePayment', compact('PaymentMethod', 'PaymentMethodBank', 'deleteSource', 'currentPath', 'invoiceData', 'stateTaxes', 'stripePaymentId', 'Invoice', 'error_message'));
            //return view('Client/mansiTest', compact('PaymentMethod', 'currentPath', 'invoiceData', 'stateTaxes', 'stripePaymentId', 'Invoice'));
        }
    }

    public function paymentPlan(Request $request) {        
        $flash_msg = "";
        $customerEmail = '';
        $customer_id = '';
        $appId = '';
        $token = '';
        $qb_api_url = env('QB_API_URL');

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

                if ($request->ccType == 1) {
                    $customer = \Stripe\Customer::retrieve($customer_id);
                    $card = $customer->sources->create(array(
                        "source" => $request->stripeSource  // token created by Checkout or Elements
                    ));
                }


                $charge = \Stripe\Charge::create(array(
                            'customer' => $customer_id,
                            "amount" => $request->totalPrice * 100,
                            "currency" => "usd",
                            "description" => "Talevation new payment from " . $Invoice->customer->name,
                            "source" => $source_id
                ));

                $Invoice->exists = true;
                $Invoice->id = $request->invoice_id;
                $Invoice->stripe_payment_id = $charge->id;
                $Invoice->IsRecurringAgreed = $request->recurValue;
                $Invoice->status = 1;
                $Invoice->save();

                $customer = new Customer;
                $customer->exists = true;
                $customer->id = $Invoice->customer_id;
                $customer->stripe_customer_id = $customer_id;
                $customer->stripe_source_id = $source_id;
                $customer->save();
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

                $Invoice->exists = true;
                $Invoice->id = $request->invoice_id;
                $Invoice->stripe_payment_id = $charge->id;
                $Invoice->IsRecurringAgreed = $request->recurValue;
                $Invoice->status = 1;
                $Invoice->save();

                $customer = new Customer;
                $customer->exists = true;
                $customer->id = $Invoice->customer_id;
                $customer->stripe_customer_id = $customer_id;
                $customer->stripe_source_id = $request->stripeSource;
                $customer->save();
            }

//\Stripe\Stripe::setApiKey("sk_test_YWrmxxCNxfB5ZHsKxbFeQzrv");
//
//$payment_method = \Stripe\PaymentMethod::retrieve('pm_1FIhaG2eZvKYlo2CuhOuIrG7');
//$payment_method->attach(['customer' => 'cus_Fq2eHKmW5CvSBi']);
            //$Invoice = new Invoice;



            $Amount = $request->totalPrice;
            $flash_msg .= " 7";

            $QbTokenFirst = QbToken::first();
            $QbTokenDate = date($QbTokenFirst->updated_at);
            $Date = date("Y-m-d H:i:s");
            $totalTime = round(abs(strtotime($QbTokenDate) - strtotime($Date)) / 60);
//           echo round(abs(strtotime($QbTokenDate) - strtotime($Date)) / 60)." minute"; return;
            if ($totalTime >= 59) {
                $OAuth2Login_Helper = $this->OAuth2LoginHelper;
                //if (isset($QbToken) && !empty($QbToken)) {
                if ($QbTokenFirst) {
                    $accessTokenObj = $OAuth2Login_Helper->refreshAccessTokenWithRefreshToken($QbTokenFirst->refresh_token);
                    $accessTokenValue = $accessTokenObj->getAccessToken();
                    $refreshTokenValue = $accessTokenObj->getRefreshToken();
                    $QbTokenFirst->exists = true;
                    $QbTokenFirst->id = $QbTokenFirst->id;
                    $QbTokenFirst->access_token = $accessTokenValue;
                    $QbTokenFirst->refresh_token = $refreshTokenValue;
                    $QbTokenFirst->save();
                    
                } else {
                    $authorizationCodeUrl = $OAuth2Login_Helper->getAuthorizationCodeURL();
                    return Redirect::to($authorizationCodeUrl);
                }
            }
//            echo "qbid=" . $Invoice->customer->qb_customerId;
            if (isset($Invoice->customer->qb_customerId)) {
                $flash_msg .= " 8";
                $totalPrice = $request->totalPrice;
                $invoice_id = $request->invoice_id;
                $customerRef = $Invoice->customer->qb_customerId;
                $memo = '';
                if(!is_null($Invoice->memo)){
                    $memo = $Invoice->memo;
                }
                else{
                    $memo = '';
                }
                
//                echo $totalPrice."~~~~".$invoice_id."~~~~~~".$customerRef."--".$token.'--'.$memo;
//                echo $appId;
                $utility = new Utility;
//                $response1 = $utility->createPaymentAPI($totalPrice, $invoice_id, $customerRef, $appId, $token);
                $response1 = $utility->createSalesReceiptAPI($totalPrice, $invoice_id, $memo, $customerRef, $appId, $token);
                
//                var_dump($response1);
//                return;
                $flash_msg .= " 8";
            } else {
                $flash_msg .= " 9";
//                    ************** Query Customer Api ****************//
                $curl = curl_init();
                $query = "select * from Customer Where PrimaryEmailAddr like '%" . $request->email . "%'";
                $query_enc = urlencode($query);
                $url = $qb_api_url . $appId . "/query?query=" . $query_enc . "&minorversion=40";
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
                    curl_setopt($curl, CURLOPT_URL, $qb_api_url . $appId . "/customer?minorversion=40");
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', 'Authorization: Bearer ' . $token));
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
                    $result = curl_exec($curl);
                    $response = json_decode($result, true);
                    // var_dump($response); return;
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
                $memo = '';
                if(!is_null($Invoice->memo)){
                    $memo = $Invoice->memo;
                }
                else{
                    $memo = '';
                }
                $memo = $Invoice->memo;
                $utility = new Utility;
//                $utility->createPaymentAPI($totalPrice, $invoice_id, $customerRef, $appId, $token);
                $utility->createSalesReceiptAPI($totalPrice, $invoice_id, $memo, $customerRef, $appId, $token);
                $flash_msg .= " 14";
            }
            $stripePaymentId = $charge->id;
            $Invoice = $Invoice;
            $Amount = $Amount;
            $flash_msg .= " 15";
            //Session::flash('log_message', $flash_msg);
            //return " here " . $flash_msg;
            return view('Client/paymentReceipt', compact('stripePaymentId', 'Invoice', 'Amount'));
        } catch (Exception $e) {
            Session::flash('fail_message', "Error! Please Try again.");

            return redirect()->back()->with('stripePaymentId', "Blank");
        }
    }

    public function bankPayment(Request $request) {
        //email & card holder name add when customer is create    
        $Invoice = Invoice::find($request->invoice_id_verify);
        $PaymentMethodBank = '';
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        if ($Invoice->customer->stripe_customer_id != '') {
            if ($Invoice->customer->isAchVerified == 2) {
                //retrieve stripe customer id for verification
                $retrieveCustomer = \Stripe\Customer::retrieve($Invoice->customer->stripe_customer_id);

                //get the existing bank account & check its status verified or new
                $bank_account = \Stripe\Customer::retrieveSource(
                                $retrieveCustomer->id, $request->paymentMethodIdBank
                );

                //charge create
                $charge = \Stripe\Charge::create([
                            'amount' => $request->totalPrice * 100,
                            'currency' => 'usd',
                            'customer' => $retrieveCustomer->id,
                            "description" => "Talevation new payment from " . $Invoice->customer->name,
                            'source' => $request->paymentMethodIdBank
                ]);

                $Invoice = Invoice::find($request->invoice_id_verify);
                $Invoice->exists = true;
                $Invoice->id = $request->invoice_id_verify;
                $Invoice->stripe_payment_id = $charge->id;
                $Invoice->IsRecurringAgreed = $request->recurValue;
                $Invoice->status = 1;
                $Invoice->save();

                $customer = new Customer;
                $customer->exists = true;
                $customer->id = $Invoice->customer_id;
                $customer->stripe_customer_id = $retrieveCustomer->id;
                $customer->stripe_source_id = $bank_account->id;
                $customer->save();

                $stripePaymentId = $charge->id;
                $Invoice = $Invoice;
                $Amount = $request->totalPrice;
                return view('Client/paymentReceipt', compact('stripePaymentId', 'Invoice', 'Amount'));
            }
            if ($Invoice->customer->isAchVerified == 1 || $Invoice->customer->isAchVerified == 0) {
                $Invoice->exists = true;
                $Invoice->id = $request->invoice_id_verify;
//            $Invoice->stripe_payment_id = $charge->id;
                $Invoice->save();

                $customer = new Customer;
                $customer->exists = true;
                $customer->id = $Invoice->customer_id;
                $customer->stripe_customer_id = $Invoice->customer->stripe_customer_id;
                $customer->isAchVerified = 1;
                $customer->save();

                if (strpos($Invoice->customer->stripe_source_id, 'ba_') == false) {
                    $retrieveCustomer = \Stripe\Customer::retrieve($Invoice->customer->stripe_customer_id);
                    $bank = \Stripe\Customer::createSource(
                                    $retrieveCustomer->id, ['source' => $request->stripeToken]
                    );
                    $customer = new Customer;
                    $customer->exists = true;
                    $customer->id = $Invoice->customer_id;
                    $customer->stripe_customer_id = $Invoice->customer->stripe_customer_id;
                    $customer->stripe_source_id = $bank->id;
                    $customer->isAchVerified = 1;
                    $customer->save();
                }

                //mail sent
                $mail_content = new MailContent();
                $mail_content->invoiceToken = request('invoiceToken');
                $mail_content->email = request('email');
                $mail_content->price = $request->totalPrice;
                $data = ['view' => 'mails.verifyAch', 'mail_content' => $mail_content, 'bcc' => 'team.sprigstack@gmail.com', 'bccName' => 'Ronak Shah', 'subject' => 'Talevation Payment - verify your bank account'];

                $emailOb = new Email($data);
                Mail::to('team.sprigstack@gmail.com')->send($emailOb); //need to make this ID dynamic once testing is done
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
                $Invoice->save();

                $customer = new Customer;
                $customer->exists = true;
                $customer->id = $Invoice->customer_id;
                $customer->stripe_customer_id = $customer_json->id;
                $customer->stripe_source_id = $customer_json->default_source;
                $customer->isAchVerified = 1;
                $customer->save();

                //mail sent
                $mail_content = new MailContent();
                $mail_content->invoiceToken = request('invoiceToken');
                $mail_content->email = request('email');
                $mail_content->price = $request->totalPrice;
                $data = ['view' => 'mails.verifyAch', 'mail_content' => $mail_content, 'bcc' => 'team.sprigstack@gmail.com', 'bccName' => 'Ronak Shah', 'subject' => 'Talevation Payment - verify your bank account'];
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
                        $retrieveCustomer->id, $request->stripe_source_id_verify
        );
        $status = $bank_account->status;
//        echo $status;
        if ($status == "new") {
            //verify the account 32,45
            try {
                $bank_account_verify = $bank_account->verify(['amounts' => [$request->amount1, $request->amount2]]);
//                var_dump($bank_account_verify);
                //after verification, verified status change to 2
                $invoiceAchVerified = Invoice::find($request->invoiceId);
                $invoiceAchVerified->customer->isAchVerified = 2;
                $invoiceAchVerified->customer->save();

                //charge create
                $charge = \Stripe\Charge::create([
                            'amount' => $request->price * 100,
                            'currency' => 'usd',
                            'customer' => $retrieveCustomer->id,
                            'description' => "Talevation new payment from " . $invoiceAchVerified->customer->name,
                            'source' => $request->stripe_source_id_verify
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
                $customer->stripe_source_id = $request->stripe_source_id_verify;
                $customer->save();

                $stripePaymentId = $charge->id;
                $Invoice = $Invoice;
                $Amount = $request->price;
                return $request->invoiceId . "~" . $stripePaymentId . "~" . $Amount;
                //return view('Client/paymentReceipt', compact('stripePaymentId', 'Invoice', 'Amount'));
            } catch (\Stripe\Error\Base $e) {
                $error_message = $e->getMessage();
//                return redirect()->back()->with('error_message');
//                return view('Client/stripePayment',compact('error_message'));
//                return redirect()->back()->with('error_message', $error_message);
//                return redirect()->back();
                return "error";
            }
        } else {
            $invoiceAchVerified = Invoice::find($request->invoiceId);
            $invoiceAchVerified->customer->isAchVerified = 2;
            $invoiceAchVerified->customer->save();

            //charge create
            $charge = \Stripe\Charge::create([
                        'amount' => $request->price * 100,
                        'currency' => 'usd',
                        'customer' => $retrieveCustomer->id,
                        'description' => "Talevation new payment from " . $invoiceAchVerified->customer->name,
                        'source' => $request->stripe_source_id_verify
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
            $customer->stripe_source_id = $request->stripe_source_id_verify;
            $customer->save();

            $stripePaymentId = $charge->id;
            $Invoice = $Invoice;
            $Amount = $request->price;
            return view('Client/paymentReceipt', compact('stripePaymentId', 'Invoice', 'Amount'));
        }
    }

    public function deleteBankAccount(Request $request) {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $Invoice = Invoice::find($request->invoice_id_verify);

        //delete bank account id
        $deleteSource = \Stripe\Customer::deleteSource(
                        $request->stripe_customer_id, $request->paymentMethodIdBank
        );

        //change isAchVerified 0 & stripe_source_id blank
        $Customer = Customer::where('stripe_customer_id', $request->stripe_customer_id)->first();
        $Customer->isAchVerified = 0;
        $Customer->stripe_source_id = '';
        $Customer->save();

        return $Customer;
    }
    
    function showReceipt($invoice_id, $stripe_payment_id, $amount){
        $Invoice = Invoice::find($invoice_id);
        $stripePaymentId = $stripe_payment_id;
        $Amount = $amount;
        return view('Client/paymentReceipt', compact('stripePaymentId', 'Invoice', 'Amount'));
    }

    public function createDepositAPI(Request $request) {
        $appId = '';
        $token = '';

        // $QbToken = QbToken::all();
        // for ($i = 0; $i < count($QbToken); $i++) {
        //     $id = $QbToken[$i]->id;
        //     $token = $QbToken[$i]->access_token;
        //     $appId = $QbToken[$i]->realm_id;
        // }

        $QbTokenFirst = QbToken::first();
        $QbTokenDate = date($QbTokenFirst->updated_at);
        $appId = $QbTokenFirst->realm_id;
        $Date = date("Y-m-d H:i:s");
        $totalTime = round(abs(strtotime($QbTokenDate) - strtotime($Date)) / 60);

        if ($totalTime >= 59) {

            $ClientID = env('QB_APP_ID');
            $ClientSecretKey = env('QB_APP_SECRET');
            $dataService = DataService::Configure(array(
                        'auth_mode' => 'oauth2',
                        'ClientID' => $ClientID,
                        'ClientSecret' => $ClientSecretKey,
                        'RedirectURI' => $this->projectBaseUrl() . "/public/qbauth",
//dev                    'RedirectURI' => "http://dev.sprigstack.com/TalevationPayment/public/qbauth",
//live                    'RedirectURI' => "https://talevation.com/payments/public/qbauth",
                        'scope' => "com.intuit.quickbooks.accounting",
                        'baseUrl' => "Development"
            ));
            $OAuth2Login_Helper = $dataService->getOAuth2LoginHelper();



            //$this->OAuth2LoginHelper;
            //if (isset($QbToken) && !empty($QbToken)) {
            if ($QbTokenFirst) {
                $accessTokenObj = $OAuth2Login_Helper->refreshAccessTokenWithRefreshToken($QbTokenFirst->refresh_token);
                $accessTokenValue = $accessTokenObj->getAccessToken();
                $refreshTokenValue = $accessTokenObj->getRefreshToken();
                $QbTokenFirst->exists = true;
                $QbTokenFirst->id = $QbTokenFirst->id;
                $QbTokenFirst->access_token = $accessTokenValue;
                $QbTokenFirst->refresh_token = $refreshTokenValue;
                $QbTokenFirst->save();
                
                $token = $accessTokenObj->getAccessToken();
                
                //return redirect()->route('invoice');
            } 
        }
        else{
            $token = $QbTokenFirst->access_token;
        }

        $curl = curl_init();
        // 2020-05-04
        $txnQueryDate = date('Y-m-d', strtotime(now()));
        $query = "select * from SalesReceipt where TxnDate='" . $txnQueryDate."'";
        // $query = "select * from SalesReceipt where TxnDate='2020-05-04'";
        $query_enc = urlencode($query);
        $url = env('QB_API_URL') . $appId . "/query?query=" . $query_enc . "&minorversion=47";
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
        // var_dump($response);return;
        $err = curl_error($curl);
        $response = json_decode($response, true);
        

        try {
            // (object)array('Line' => (object)array('DetailType' => 'DepositLineDetail', 'Amount'=>20.0, 'DepositLineDetail'=>(object)array('AccountRef' => (object)array('name'=>'Unapplied Cash Payment Income', 'value' => "87") )))
            // $data = (object) array("TotalAmt" => 20.0, 'Line' => $arr, 'DepositToAccountRef'=>(object)array('name'=>'Checking','value'=>'35'));
            $subTotalAmount = 0;
            $salesReceiptData = $response['QueryResponse']['SalesReceipt'];
            foreach ($salesReceiptData as $receiptData) {
                $lineItemDetail = $receiptData['TotalAmt'];
                $salesReceiptId = $receiptData['Id'];
                $subTotalAmount = $subTotalAmount + $lineItemDetail;
                // $arr[] = (object)array('DetailType' => 'DepositLineDetail', 'Amount'=>$lineItemDetail, 'LinkedTxn' => [(object)array('TxnId'=>$salesReceiptId, 'TxnType'=>'SalesReceipt')] , 'DepositLineDetail'=>(object)array('AccountRef' => (object)array('name'=>'Billable Expense Income', 'value' => "85")));
                $arr[] = (object) array('Amount' => $lineItemDetail, 'LinkedTxn' => [(object) array('TxnLineId'=> 0, 'TxnId' => $salesReceiptId, 'TxnType' => 'SalesReceipt')]);
            }
            // return $lineItemDetail . ' ' . $salesReceiptId . ' ' . $subTotalAmount;
            
            $totalAmount =  $subTotalAmount - 1100;
            
            $arr1[] = (object)array('DetailType' => 'DepositLineDetail', 'Amount'=> $totalAmount, 'DepositLineDetail'=>(object)array('AccountRef' => (object)array('name'=>'Stripe Processing Fees', 'value' => '5')));
            
            // $arr1 = (object) array('Amount' => $subTotalAmount - $webhookRequest['data']['object']['amount'], 'LinkedTxn' => [(object) array('TxnLineId'=> 0, 'TxnId' => 0, 'TxnType' => 'SalesReceipt')]);
            // $data = (object) array('Line' => $arr, 'DepositToAccountRef' => (object) array('name' => 'Savings', 'value' => '36'));
            $data = (object) array('TotalAmt'=>$arr1, 'Line' => $arr, 'DepositToAccountRef' => (object) array('name' => 'Savings', 'value' => '36'));
            // var_dump($data);return;
            

            // $data = (object) array('TotalAmt'=>$webhookRequest['data']['object']['amount'], 'Line' => $arr, 'DepositToAccountRef' => (object) array('name' => 'Savings', 'value' => '36'));

            $data_json = json_encode($data);
            $curl = curl_init(); // URL of the call
            // Disable SSL verification
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            // Will return the response, if false it print the response
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, env('QB_API_URL') . $appId . "/deposit?minorversion=47");
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', 'Authorization: Bearer ' . $token));
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
            $result = curl_exec($curl);
            // return $result;
            $response = json_decode($result, true);
            // var_dump($response);return;
        } catch (Exception $e) {
            // return response()->json([
            //             'error' => $e
            //                 ], 200);
        }
        return "success";
    }

    public function salesreceipt(Request $request){
        $appId = '';
        $token = '';

        $QbToken = QbToken::all();
        for ($i = 0; $i < count($QbToken); $i++) {
            $id = $QbToken[$i]->id;
            $token = $QbToken[$i]->access_token;
            $appId = $QbToken[$i]->realm_id;
        }

        $QbTokenFirst = QbToken::first();
            $QbTokenDate = date($QbTokenFirst->updated_at);
            $Date = date("Y-m-d H:i:s");
            $totalTime = round(abs(strtotime($QbTokenDate) - strtotime($Date)) / 60);

            if ($totalTime >= 59) {
                $OAuth2Login_Helper = $this->OAuth2LoginHelper;
                //if (isset($QbToken) && !empty($QbToken)) {
                if ($QbTokenFirst) {
                    $accessTokenObj = $OAuth2Login_Helper->refreshAccessTokenWithRefreshToken($QbTokenFirst->refresh_token);
                    $accessTokenValue = $accessTokenObj->getAccessToken();
                    $refreshTokenValue = $accessTokenObj->getRefreshToken();
                    $QbTokenFirst->exists = true;
                    $QbTokenFirst->id = $QbTokenFirst->id;
                    $QbTokenFirst->access_token = $accessTokenValue;
                    $QbTokenFirst->refresh_token = $refreshTokenValue;
                    $QbTokenFirst->save();
                    return redirect()->route('invoice');
                } else {
                    $authorizationCodeUrl = $OAuth2Login_Helper->getAuthorizationCodeURL();
                    return Redirect::to($authorizationCodeUrl);
                }
            }


            $curl = curl_init();
        $query = "select * From TaxCode";
        $query_enc = urlencode($query);
        $url = env('QB_API_URL') . $appId . "/query?query=" . $query_enc . "&minorversion=47";
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
        // return $response;
        $err = curl_error($curl);
        $response = json_decode($response, true);

        $tax = '';

        $invoice = Invoice::where("id", 48)->first();
        if (isset($invoice->state_tax_id)) {
            $stateTaxes = StateTax::find($invoice->state_tax_id);
        }

        $invoice_items = InvoiceItem::where("invoice_id", 48)->get();
        $totalTax = 0;
        foreach ($invoice_items as $items) {
            if ($items->is_taxable == 1) {

                $tax = 'TAX';
                // $unitPrice = number_format($items->rate + ($items->rate * $stateTaxes->tax_rate/100),2);
                $totalTax += round($items->rate * $items->quantity * $stateTaxes->tax_rate/100, 2);
                // $tax = 'NON';
                $arr[] = (object) array("Description" => $items->discription . " State Tax: ". $stateTaxes->state_name . '(' . $stateTaxes->tax_rate . '%)', "DetailType" => "SalesItemLineDetail",
                        "SalesItemLineDetail" => (object) array("TaxCodeRef" => (object) array("value" => $tax),
                            "Qty" => $items->quantity, "UnitPrice" => $items->rate, "ItemRef" => (object) array("name" => $items->part_number, "value" => 1)), "Amount" => $items->quantity * $items->rate , "Id" => 0);
                // $arr1[] = (object) array("DetailType" => "TaxLineDetail", "TaxLineDetail" => (object) array("PercentBased" => "True", "TaxPercent" => $stateTaxes->tax_rate));
                // $arr1[] = (object) array("DetailType" => "TaxLineDetail", "TaxLineDetail" => (object) array("TaxRateRef" => (object) array("value" => 4, "name" => "Sales Tax 1 Percent"), "PercentBased" => "True", "TaxPercent" => $stateTaxes->tax_rate));
                // var_dump(number_format($items->rate + ($items->rate * $stateTaxes->tax_rate/100),2));return;
                // number_format(($items->quantity * $items->rate) + ($items->quantity * $items->rate * $stateTaxes->tax_rate/100),2)
            } else {
                $tax = 'NON';
                $arr[] = (object) array("Description" => $items->discription, "DetailType" => "SalesItemLineDetail",
                        "SalesItemLineDetail" => (object) array("TaxCodeRef" => (object) array("value" => $tax),
                            "Qty" => $items->quantity, "UnitPrice" => $items->rate, "ItemRef" => (object) array("name" => $items->part_number, "value" => 1)), "Amount" => $items->quantity * $items->rate, "Id" => 0);
                // $arr1[] = (object) array("DetailType" => "TaxLineDetail", "TaxLineDetail" => (object) array("PercentBased" => "True", "TaxPercent" => $stateTaxes->tax_rate));
                // $arr1[] = (object) array("DetailType" => "TaxLineDetail", "TaxLineDetail" => (object) array("TaxRateRef" => (object) array("value" => 4, "name" => "Sales Tax 1 Percent"), "PercentBased" => "True", "TaxPercent" => $stateTaxes->tax_rate));
            }
        }
        // return $totalTax;

        // $data = (object) array("TotalAmt" => 69.88, "CustomerRef" => (object) array("value" => 12), "CustomerMemo" => (object) array("value" => "abc"), "Line" => $arr);
        // $data = (object) array("TotalAmt" =>  1245.4, "CustomerRef" => (object) array("value" => 1), "TxnTaxDetail" => (object) array("TxnTaxCodeRef" =>(object) array("value" => 3)) , "CustomerMemo" => (object) array("value" => "test"), "Line" => $arr);
        $data = (object) array("TotalAmt" => 1245.4, "CustomerRef" => (object) array("value" => 1), "TxnTaxDetail" => (object) array("TxnTaxCodeRef" =>(object) array("value" => $stateTaxes->qb_tax_code)) , "CustomerMemo" => (object) array("value" => 'test'), "Line" => $arr);
        $data_json = json_encode($data);
       // var_dump($arr);return;
       // return $data_json;

        try {
            $curl = curl_init(); // URL of the call
            // Disable SSL verification
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            // Will return the response, if false it print the response
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, env('QB_API_URL') . $appId . "/salesreceipt?minorversion=45");
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', 'Authorization: Bearer ' . $token));
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
            $result = curl_exec($curl);
            $response = json_decode($result, true);
           return $response;

            if (isset($response['SalesReceipt']['Id'])) {
                $Invoice = new Invoice;
                $Invoice->exists = true;
                $Invoice->id = $invoice_id;
                $Invoice->QB_transaction_id = $response['SalesReceipt']['Id'];
                $Invoice->save();
            }
        } catch (Exception $e) {
//            return response()->json([
//                        'error' => $e
//                            ], 200);
        }

        // $data = (object) array("TotalAmt" => $totalPrice, "CustomerRef" => (object) array("value" => $customerRef), "CustomerMemo" => (object) array("value" => $memo), "Line" => $arr);
        // $data_json = json_encode($data);
       // var_dump($arr);
//        return $data_json;
}

}
