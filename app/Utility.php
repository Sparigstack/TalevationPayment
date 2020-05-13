<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

use App\Invoice;
use App\InvoiceItem;
use App\DemoTable;
use App\QbToken;

/**
 * Description of Utility
 *
 * @author admin
 */
class Utility {

    //put your code here

    public function createPaymentAPI($totalPrice, $invoice_id, $customerRef, $appId, $token) {


        $data = (object) array('TotalAmt' => $totalPrice, 'CustomerRef' => (object) array('value' => $customerRef));
        $data_json = json_encode($data);
        $curl = curl_init(); // URL of the call
        // Disable SSL verification
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, env('QB_API_URL') . $appId . "/payment?minorversion=40");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json', 'Authorization: Bearer ' . $token));
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
        $result = curl_exec($curl);
        $response = json_decode($result, true);
//        return $response;
//        return $response['Payment']['Id'];
        if (isset($response['Payment']['Id'])) {
            $Invoice = new Invoice;
            $Invoice->exists = true;
            $Invoice->id = $invoice_id;
            $Invoice->QB_transaction_id = $response['Payment']['Id'];
            $Invoice->save();
        }
    }

    public function projectBaseUrl() {
        $urlString = $_SERVER["HTTP_HOST"];
        $httpString = "http://";
        $domainString = "/TalevationPayment";
        if (strpos(strtolower($urlString), 'talevation.com') !== false) {
            // $httpString = "http://";
            $httpString = "https://";
            $domainString = "/payments";
        }

        $fullBaseURL = $httpString . $urlString . $domainString;

        return $fullBaseURL;
    }

    public function createSalesReceiptAPI($totalPrice, $invoice_id, $memo, $customerRef, $appId, $token) {
        $tax = '';

        $invoice_items = InvoiceItem::where("invoice_id", $invoice_id)->get();
        foreach ($invoice_items as $items) {
            if ($items->is_taxable == 1) {
                $tax = 'TAX';
            } else {
                $tax = 'NON';
            }
            $arr[] = (object) array("Description" => $items->discription, "DetailType" => "SalesItemLineDetail",
                        "SalesItemLineDetail" => (object) array("TaxCodeRef" => (object) array("value" => $tax),
                            "Qty" => $items->quantity, "UnitPrice" => $items->rate, "ItemRef" => (object) array("name" => $items->part_number, "value" => 1)), "Amount" => $items->quantity * $items->rate, "Id" => 0);
        }

        $data = (object) array("TotalAmt" => $totalPrice, "CustomerRef" => (object) array("value" => $customerRef), "CustomerMemo" => (object) array("value" => $memo), "Line" => $arr);
        $data_json = json_encode($data);
//        var_dump($arr);
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
    }

    public function createDepositAPI($totalPrice, $invoice_id, $customerRef, $appId, $token){
        // $demoTable = new DemoTable();
        // $demoTable->name = "deposit";
        // $demoTable->role = $webRequest;
        // $demoTable->save();

        // $QbToken = QbToken::first();
        // $appId = $QbToken->realm_id;
        $invoice_items = InvoiceItem::where("invoice_id", $invoice_id)->get();

        try {
            // (object)array('Line' => (object)array('DetailType' => 'DepositLineDetail', 'Amount'=>20.0, 'DepositLineDetail'=>(object)array('AccountRef' => (object)array('name'=>'Unapplied Cash Payment Income', 'value' => "87") )))
            foreach ($invoice_items as $items) {
            $arr[] = (object)array('DetailType' => 'DepositLineDetail', 'Amount'=>$items->quantity * $items->rate, 'DepositLineDetail'=>(object)array('AccountRef' => (object)array('name'=>'Billable Expense Income', 'value' => "85")));
            }
            $data = (object) array("TotalAmt" => $totalPrice, 'Line' => $arr, 'DepositToAccountRef'=>(object)array('name'=>'Checking','value'=>'35'));
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
            $response = json_decode($result, true);
            var_dump($response);
           // return $response;

        } catch (Exception $e) {
//            return response()->json([
//                        'error' => $e
//                            ], 200);
        }
    }

}
