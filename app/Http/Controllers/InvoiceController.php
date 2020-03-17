<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp;
//use Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;
use App\Term;
use App\Invoice;
use DB;
use App\Customer;
use App\PresetLineItems;
use App\StateTax;

class InvoiceController extends Controller {

    //add new Invoice
    public function addInvoice(Request $request) {

//        $termsList = Term::all();
//        return view('Client/addInvoice', compact('termsList'));
    }

    public function fetch(Request $request) {

        $email = $request->email;
        $data_json = ['Value' => $email, 'ValueID' => 9578];
        $curl = curl_init(); // URL of the call
        // Disable SSL verification
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_URL, "http://netdev2.addresstwo.com/api/OnDemandSearch");
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'SuperTokenAuthentication: AddressTwoSuperToken123'));
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_json));

        $result = curl_exec($curl);

        $response = json_decode($result, true);
        return $response;
    }

    public function InsertInvoice(Request $request) {
        $due_date = $request->inv_due_date;
        $InvoiceId = $request->InvoiceIdFromEditIcon;
        $invoice = new Invoice();
        if (isset($InvoiceId)) {
            $invoice->exists = true;
            $invoice->id = $request->InvoiceIdFromEditIcon;
        }
        $invoice->name = $request->companyName_Invoice;
        $invoice->first_name = $request->inv_firstname;
        $invoice->last_name = $request->inv_lastname;
        $invoice->email = $request->Email;
        $invoice->address1 = $request->inv_add1;
        $invoice->address2 = $request->inv_add2;
        $invoice->city_name = $request->inv_city;
        $invoice->state_name = $request->inv_state;
        $invoice->zipcode = $request->inv_zip;

        if ($due_date == "due on receipt") {
            $invoice->due_date = null;
        } else {
            $due_date = date("Y-m-d", strtotime($due_date));
            $invoice->due_date = $due_date;
        }

        $invoice_created_date = date("Y-m-d", strtotime($request->invoice_created_date));
        $invoice->invoice_date = $invoice_created_date;
        $invoice->terms = $request->inv_terms;
        $invoice->state_tax_id = $request->state_tax_id == -1 ? null : $request->state_tax_id;
        $invoice->RecurringOption = $request->RecurringOption;
        $invoice->GUID = $request->inv_GUID;
        $invoice->memo = $request->memo;
        $invoice->status = 0;
        $customerId_fromcreateInvoice = $request->customerId_fromcreateInvoice;
        if (isset($customerId_fromcreateInvoice)) {
            $invoice->customer_id = $customerId_fromcreateInvoice;
        } else {
            $invoice->customer_id = $request->customerDb_id;
        }
//        return $invoice;
        $invoice->save();
//return $request->InvoiceIdFromEditIcon." :InvoiceIdFromEditIcon  ".$request->companyName_Invoice." :companyName_Invoice "
//                .$request->inv_firstname." :inv_firstname  ".$request->inv_lastname." :inv_lastname  ".$request->Email.
//                " Email  ".$request->inv_add1." :inv_add1 ".$request->inv_add2." :inv_add2 ".$request->inv_city.
//                " inv_city ".$request->inv_state." :inv_state ".$request->inv_zip." :inv_zip ".$due_date.": due date".
//                $invoice_created_date." :invoice_created_date  ". $request->inv_terms.": inv_terms ".$request->inv_GUID.
//                " inv_GUID ".$request->memo." :memo ".$request->customerId_fromcreateInvoice." :customerId_fromcreateInvoice ".
//        $invoice->customer_id." :customer_id ";



        return $invoice->id;
    }

    public function markInvoicePaid(Request $request) {
        $invoice = Invoice::find($request->invoiceId);
        $invoice->status = 1;
        $invoice->save();
    }

    public function InvoiceByCustomer($id) {
        //$GUID = $_GET['id'];
        $GUID = $id;
        if (isset($GUID))
            $Customer = Customer::where('GUID', $GUID)->first();
        $Invoices = $Customer->customer_has_invoices;
        $termsList = Term::all();
        return view('Client/invoiceByCustomer', compact('Invoices', 'termsList'));
    }

    public function myInvoices($id) {
        //$GUID = $_GET['id'];
        $GUID = $id;
        if (isset($GUID))
            $Customer = Customer::where('GUID', $GUID)->first();
        $Invoices = $Customer->customer_has_invoices;
        //$termsList = Term::all();
        return view('Client/myInvoices', compact('Invoices'));
    }

    public function preset_line_items(Request $request) {
        $preset_line_items = PresetLineItems::all();
        $state_taxes = StateTax::all();
        $response = \Illuminate\Support\Facades\Response::json(array('preset_line_items' => $preset_line_items, 'state_taxes' => $state_taxes));
        return $response;
    }

}
