<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\StateTax;
use App\Term;
use App\Invoice;
use App\InvoiceItem;
use App\Customer;
use App\QbToken;
use Redirect;
use Illuminate\Support\Facades\Auth;
use QuickBooksOnline\API\DataService\DataService;
use App\Http\Controllers\OAuth2LoginHelper;
use Artisan;
use App\Mail\Email;
use Mail;
use App\CustomClass\MailContent;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index(Request $request) {
//        if (!Auth::check()) {
//            return view('auth.login');
//        }
////         else {
////             return view('test');
//////            return redirect()->route('qbrefresh');
////        }
//    }

    public function qbrefresh() {

        $QbToken = QbToken::first();

        $OAuth2Login_Helper = $this->OAuth2LoginHelper;
        //if (isset($QbToken) && !empty($QbToken)) {
        if ($QbToken) {

            $accessTokenObj = $OAuth2Login_Helper->refreshAccessTokenWithRefreshToken($QbToken->refresh_token);
            $accessTokenValue = $accessTokenObj->getAccessToken();
            $refreshTokenValue = $accessTokenObj->getRefreshToken();
            $QbToken->exists = true;
            $QbToken->id = $QbToken->id;
            $QbToken->access_token = $accessTokenValue;
            $QbToken->refresh_token = $refreshTokenValue;
            $QbToken->save();
            return redirect()->route('invoice');
        } else {

            $authorizationCodeUrl = $OAuth2Login_Helper->getAuthorizationCodeURL();
            return Redirect::to($authorizationCodeUrl);
        }
    }

//    public function filterInvoices(Request $request){
//        
//    }

//    public function sendEmail() {
//
//        $mail_content = new MailContent();
//
//        $mail_content->invoiceToken = 'something here';
//        $mail_content->email = 'something@sss.com';
//        $mail_content->price = 111;
//
//        $data = ['view' => 'mails.mansiTestVerify', 'mail_content' => $mail_content, 'bcc' => 'ronak@protocrm.com', 'bccName' => 'Ronak Shah', 'subject' => 'Talevation test email!'];
//        
//        $emailOb = new Email($data);
////        Mail::to('team.sprigstack@gmail.com')->send($emailOb); //need to make this ID dynamic once testing is done
////        echo 'done sent';
////        return;
//    }

    public function invoicePage(Request $request) {
//        Artisan::call('config:clear');
//        Artisan::call('cache:clear');
        
        //$data[] = (object)array("Line" => (object)array("Description"=>"Postman Test"));
        
//        $array = array(
//  2 => array_values(array("Afghanistan", 32, 13)),
//  4 => array("Albania", 32, 12)
//);

// array_values() removes the original keys and replaces
// with plain consecutive numbers
//$out = array_values($array);
//$final = json_encode($array);
        
        if (!Auth::check()) {
            return view('auth.login');
        }
        $startDate;
        $endDate;
        $dbstartDate;
        $dbendDate;
        $search;
        $search_query;
        $date = date('Y-m-d'); //current date
        if (isset($request->start_date)) {
            $dbstartDate = date("Y-m-d", strtotime($request->start_date));
            $startDate = date("m/d/Y", strtotime($request->start_date));
        } else {
            //            $first_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", first day of this month");
            $curr_date_find = strtotime(date("Y-m-d", strtotime($date)));
            $dbstartDate = date("Y-m-d", $curr_date_find);
            $startDate = date("m/d/Y", $curr_date_find);
        }

        if (isset($request->end_date)) {
            $dbendDate = date("Y-m-d", strtotime($request->end_date));
            $endDate = date("m/d/Y", strtotime($request->end_date));
        } else {
            //            $last_date_find = strtotime(date("Y-m-d", strtotime($date)) . ", last day of this month");
            $last_date_find = strtotime(date("Y-m-d", strtotime('+30 days', strtotime($date))));
            $dbendDate = date("Y-m-d", $last_date_find);
            $endDate = date("m/d/Y", $last_date_find);
        }

//        if (isset($request->search)) {
//            $search = $request->search;
//            $search_query = " AND (name LIKE '$search%' OR 'first_name' LIKE '$search%')";
//        } else {
//            $search = "";
//            $search_query = "";
//        }
//        $invoiceList = Invoice::whereBetween('due_date', [$dbstartDate, $dbendDate])->get();        
        //$invoiceList = $invoiceList->where('email', 'LIKE', '%ban%');
//                ->orWhere('name', 'LIKE', $search . '%')->orWhere('first_name', 'LIKE', $search . '%')
//                ->get();
//        return $invoiceList;
//        $invoiceList = DB::select(DB::raw("SELECT * FROM invoices WHERE (due_date BETWEEN '$dbstartDate' AND '$dbendDate') $search_query "));
//        return $invoiceList;

        $search = $request->search;
        $invoiceList = Invoice::whereBetween('due_date', [$dbstartDate, $dbendDate])
                        ->where(function ($query) use ($search) {
                            $query->where('name', 'LIKE', '%' . $search . '%')
                            ->orWhere('email', 'LIKE', '%' . $search . '%')
                            ->orWhere('first_name', 'LIKE', '%' . $search . '%')
                            ->orWhere('last_name', 'LIKE', '%' . $search . '%');
                        })->orderBy('id', 'DESC')->get();
//        return $invoiceList;

        $termsList = Term::all();
        $taxList = StateTax::all();
        return view('Masters/invoice_2', compact('invoiceList', 'termsList', 'taxList', 'startDate', 'endDate', 'search'));
//        return view('Client/invoice', compact('invoiceList', 'termsList', 'startDate', 'endDate'));
    }

    public function searchList(Request $request) {
        //$searchList = Customer::all();

        $email = $request->email;
        $data_json = ['Value' => $email, 'ValueID' => 9578];
        $curl = curl_init(); // URL of the call
        // Disable SSL verification
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        //curl_setopt($curl, CURLOPT_URL, "http://netdev2.addresstwo.com/api/OnDemandSearch");
        curl_setopt($curl, CURLOPT_URL, env('A2_BASE_URL') . "/api/OnDemandSearch");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'SuperTokenAuthentication: AddressTwoSuperToken123'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_json));

        $result = curl_exec($curl);

        $response = json_decode($result, true);

        return $response;

        //return $searchList;
    }

    public function logout(Request $request) {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }

    public function qbauth(Request $request) {
        $OAuth2Login_Helper = $this->OAuth2LoginHelper;
        $accessTokenObj = $OAuth2Login_Helper->exchangeAuthorizationCodeForToken($request->code, $request->realmId);
        $accessTokenValue = $accessTokenObj->getAccessToken();
        $refreshTokenValue = $accessTokenObj->getRefreshToken();
//        return $accessTokenValue . "<br><br>" . $refreshTokenValue;
        //refreshTokenValue QbToken Save in DB
        $QbToken = new QbToken;
        //$QbToken->exists = true;
        //$QbToken->id = 1;
        $QbToken->access_token = $accessTokenValue;
        $QbToken->refresh_token = $refreshTokenValue;
        $QbToken->realm_id = $request->realmId;
        $QbToken->save();
        return redirect()->route('invoice');
    }

}

