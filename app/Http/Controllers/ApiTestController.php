<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\QbToken;
use App\Invoice;
use App\InvoiceItem;
use Illuminate\Support\Facades\Auth;
use QuickBooksOnline\API\DataService\DataService;
use App\Http\Controllers\OAuth2LoginHelper;

class ApiTestController extends Controller {

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

    public function login() {

        return response()->json([
                    "message" => "student record created"
                        ], 200);
    }

    public function createSalesReceiptAPI() {
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

//        $arr[] = (object)array("Description"=>"From Lccal Test", "DetailType"=>"SalesItemLineDetail", "SalesItemLineDetail"=>(object)array("TaxCodeRef"=>(object)array("value"=>"NON"),"Qty"=>1,"UnitPrice"=>25,
//            "ItemRef"=>(object)array("name"=>"From Lccal Test","value"=>"10")),"LineNum"=>1, "Amount"=> 25.0, "Id"=>1);
//        $data = (object)array("Line" => $arr);
//        $arr[] = (object) array("Description" => "From Lccal Test", "DetailType" => "SalesItemLineDetail", "SalesItemLineDetail" => (object) array("Qty" => 1, "UnitPrice" => 20), "Amount" => 20.0, "Id" => 0);
//        $data = (object) array("Line" => $arr, "CustomerRef" => (object) array("value" => 110));

        $Invoice = Invoice::where('id', 11)->first();
        $customerRef = $Invoice->customer->qb_customerId;
        $memo = $Invoice->memo;
        $tax = '';
        
        $invoice_items = InvoiceItem::where("invoice_id",$Invoice->id)->get();
        foreach($invoice_items as $items){
            if($items->is_taxable == 1){
                $tax = 'TAX';
            }
            else{
                $tax = 'NON';
            }
             $arr[] = (object) array("Description" => $items->discription, "DetailType" => "SalesItemLineDetail",
                    "SalesItemLineDetail" => (object) array("TaxCodeRef" => (object) array("value" => $tax),
                        "Qty" => 1, "UnitPrice" => 20, "ItemRef" => (object) array("name" => $items->part_number, "value" => 1)), "Amount" => 20.0, "Id" => 0);
//            $arr[] = (object) array("Description" => $items->discription, "DetailType" => "SalesItemLineDetail",
//                    "SalesItemLineDetail" => (object) array("TaxCodeRef" => (object) array("value" => $tax),
//                        "Qty" => 1, "UnitPrice" => 2, "ItemRef" => (object) array("name" => $items->part_number)), "Amount" => 2.0, "Id" => 0);
        }

//        $arr[] = (object) array("Description" => "Custom Design", "DetailType" => "SalesItemLineDetail",
//                    "SalesItemLineDetail" => (object) array("TaxCodeRef" => (object) array("value" => "NON"),
//                        "Qty" => 1, "UnitPrice" => 20, "ItemRef" => (object) array("name" => "design", "value" => 4)), "Amount" => 20.0, "Id" => 0);
        $data = (object) array("CustomerRef" => (object) array("value" => $customerRef), "CustomerMemo" => (object) array("value" => $memo), "Line" => $arr);
        $data_json = json_encode($data);
//        return $data_json;

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
//            return $response;
        } catch (Exception $e) {
//            return response()->json([
//                        'error' => $e
//                            ], 200);
        }
    }

}
