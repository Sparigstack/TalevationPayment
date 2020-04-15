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
use App\InvoiceItem;
use App\Mail\Email;
use Mail;
use App\CustomClass\MailContent;
use App\DemoTable;

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

    public function deleteInvoice(Request $request) {
        // $invoice_items = InvoiceItem::where('invoice_id','=',$request->invoiceDeleteId);
        // $invoice_items->is_taxable = 1;
        // $invoice_items->save();
        
        $invoice_items = InvoiceItem::where('invoice_id',$request->invoiceDeleteId)->delete();
        $invoice = Invoice::find($request->invoiceDeleteId)->delete();
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

    public function croneJob(Request $request){
        // $invoiceDetails = "SELECT * FROM `invoices` 
        // WHERE (invoice_date = date_sub(curdate(),INTERVAL 30 day) AND RecurringOption= 1)
        // OR
        // (invoice_date = date_sub(curdate(),INTERVAL 90 day) AND RecurringOption= 2)
        // OR
        // (invoice_date = date_sub(curdate(),INTERVAL 365 day) AND RecurringOption= 3)";
        // $invoiceResults = DB::select(DB::raw($invoiceDetails));
        // //$date_add = Date('Y-m-d', strtotime("+3 days"));
        // //return $date_add;
        // foreach ($invoiceResults as $invoiceResult) {
        //     $invoice = new Invoice();
        //     // $invoice->id = $invoiceResult->id;
        //     $invoice->customer_id = $invoiceResult->customer_id;
        //     $invoice->name = $invoiceResult->name;
        //     $invoice->first_name = $invoiceResult->first_name;
        //     $invoice->last_name = $invoiceResult->last_name;
        //     $invoice->email = $invoiceResult->email;
        //     $invoice->address1 = $invoiceResult->address1;
        //     $invoice->address2 = $invoiceResult->address2;
        //     $invoice->city_name = $invoiceResult->city_name;
        //     $invoice->state_name = $invoiceResult->state_name;
        //     $invoice->zipcode = $invoiceResult->zipcode;
        //     $terms = $invoiceResult->terms;
        //     if ($terms == "Net10")
        //         $invoice->due_date = Date('Y-m-d', strtotime("+10 days"));
        //     if ($terms == "Net30")
        //         $invoice->due_date = Date('Y-m-d', strtotime("+30 days"));
        //     if ($terms == "Net90")
        //         $invoice->due_date = Date('Y-m-d', strtotime("+90 days"));
        //     if ($terms == "Due On Receipt") {
        //         $invoice->due_date = "";
        //     }
        //     if ($terms == "Due On or Before") {
        //         $invoice->due_date = $invoiceResult->due_date;
        //     }
        //     // $invoice->due_date = $invoiceResult->due_date;
        //     $invoice_created_date = date("Y-m-d", strtotime(date('Y-m-d')));
        //     $invoice->invoice_date = date("Y-m-d", strtotime(date('Y-m-d')));
        //     $invoice->terms = $invoiceResult->terms;
        //     $invoice->state_tax_id = $invoiceResult->state_tax_id;
        //     $invoice->RecurringOption = $invoiceResult->RecurringOption;
        //     $invoice->GUID = $invoiceResult->GUID;
        //     $invoice->memo = $invoiceResult->memo;
        //     $invoice->status = $invoiceResult->status;
        //     $invoice->customer_id = $invoiceResult->customer_id;
        //     $invoice->save();

        //     $invoiceItemDetails = "SELECT * FROM invoice_items where invoice_id = ".$invoiceResult->id."";
        //     $invoiceItemResults = DB::select(DB::raw($invoiceItemDetails));
        //   // var_dump($invoiceItemResults);
        //     foreach ($invoiceItemResults as $invoiceItemResult) {
        //         $InvoiceItem = new InvoiceItem();
        //         $InvoiceItem->invoice_id = $invoice->id;
        //         $InvoiceItem->preset_line_item_id = $invoiceItemResult->preset_line_item_id;
        //         $InvoiceItem->part_number = $invoiceItemResult->part_number;
        //         $InvoiceItem->discription = $invoiceItemResult->discription;
        //         $InvoiceItem->quantity = $invoiceItemResult->quantity;
        //         $InvoiceItem->rate = $invoiceItemResult->rate;
        //         $InvoiceItem->is_taxable= $invoiceItemResult->is_taxable;
        //         $InvoiceItem->save();
        //     }
        // }
        
        // $mail_content = new MailContent();
        // // $mail_content->email = request('email');
        // $data = ['view' => 'mails.croneJobMail', 'mail_content' => $mail_content, 'bcc' => 'team.sprigstack@gmail.com', 'bccName' => 'Ronak Shah', 'subject' => 'Crone job test email'];
        // $emailOb = new Email($data);
        // Mail::to('team.sprigstack@gmail.com')->send($emailOb);

        // return 'mansi';
        $demoTable = new DemoTable();
        $demoTable->name = $request->full_name;
        $demoTable->role = $request->role;
        // $demoTable->save();
        return view('croneJobPage');
    }

    public function recurInvoices(){
        $demoTable = new DemoTable();
        $demoTable->name = 'mansi';
        $demoTable->role = 'php developer';
        // $demoTable->save();
        // return $demoTable->id;
        // return 'check invoice';
    }

}
