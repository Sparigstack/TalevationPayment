<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Invoice;
use App\Term;
use Redirect;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Mail\Email;
use Mail;
use App\CustomClass\sslContent;

class CustomerController extends Controller {

    //
    public function customer() {
        if (!Auth::check()) {
            return redirect('/');
        }
        $customers = Customer::orderBy('id', 'DESC')->get();
//        $customers = DB::select(DB::raw("SELECT c.*,i1.GUID as invGUID,i1.terms,i1.customer_id as customerId,
//(select count(i.id) from invoices i where i.customer_id=c.id) as count
//FROM customers c left JOIN invoices i1 on i1.customer_id=c.id;"));
//        return $customers;
//        SELECT c.*,(select count(i.id) from invoices i where i.customer_id=c.id) as count FROM customers c  ;
//        SELECT c.*,i1.GUID,
//(select count(i.id) from invoices i where i.customer_id=c.id) as count
//FROM customers c left JOIN invoices i1 on i1.customer_id=c.id;



        $invoiceList = Invoice::all();
        $termsList = Term::all();
        return view('Client/customer', compact('customers', 'invoiceList', 'termsList'));
    }

    public function addCustomer(Request $request) {
        $customers = new Customer;
        $customers->name = $request->companyName;
        $customers->email = $request->emailAddress;
        $customers->first_name = $request->first_name;
        $customers->last_name = $request->last_name;
        $customers->address1 = $request->add1;
        $customers->address2 = $request->add2;
        $customers->state_name = $request->state;
        $customers->city_name = $request->city;
        $customers->zipcode = $request->zipcode;
        $customers->GUID = uniqid();
        $customers->a2_accountId = $request->a2_accountId;
        $customers->a2_contactId = $request->a2_contactId;
        $customers->note = $request->note;

        $date = date_create($request->anniversary_Date);

        $siteNumber = $request->siteNumber;
        if ($siteNumber) {
            $customers->site_number = $request->siteNumber;
        } else {
            $customers->site_number = "";
        }
        if ($request->anniversary_Date) {
            $customers->anniversary_date = date_format($date, "Y-m-d");
        } else {
            $customers->anniversary_date = null;
        }




        if ($request->qb_customerId == "null") {
            $customers->qb_customerId = null;
        } else {
            $customers->qb_customerId = $request->qb_customerId;
        }
        $customers->save();




        if ($request->from == "saveCreateInvoice") {
            return $customers;
        } else {
            return redirect('customer');
        }
    }

    public function checkDuplicateEmail(Request $request) {
        $existEmail = DB::table('customers')->where('email', '=', $request->emailAddress)->get();

        return $existEmail;
    }

    public function getCustomerFromdb(Request $request) {
        $customers = Customer::all();

        return $customers;
    }

    public function sendEmail(Request $request) {
        $mail_content = new sslContent();
        $mail_content->reseller = request('reseller');
        $mail_content->order_date = request('order_date');
        $mail_content->com_name = request('com_name');
        $mail_content->add = request('add');
        $mail_content->country = request('country');
        $mail_content->contact = request('contact');
        $mail_content->email_add = request('email_add');
        $mail_content->mob_no = request('mob_no');
        $mail_content->exist = request('exist');
        $platform_details = $request->platform_details;
        $product_details = $request->product_details;

        $platform_details4 = array();
        $dataPoints = '';
        if ($platform_details != null && count($platform_details) > 0) {
            for ($i = 0; $i < count($platform_details); $i++) {
                $dataPoints .= "<tr><td align='right' width='30%'><label>" . $platform_details[$i]['label'] . " </label></td><td align='center' width='45%'>  " . $platform_details[$i]['platform_data'] . " </td><td align='center' width='32%'> " . $platform_details[$i]['amount'] . "</td></tr>";
            }
        }
//        return($dataPoints);
        $mail_content->platform_details = $dataPoints;

        $dataPoints2 = '';
        if ($product_details != null && count($product_details) > 0) {
            for ($i = 0; $i < count($product_details); $i++) {
                $dataPoints2 .= "<tr><td align='right' width='30%'><label>" . $product_details[$i]['label'] . " </label></td><td align='center' width='20%'>  " . $product_details[$i]['product_site'] . " </td><td align='center' width='26%'> " . $product_details[$i]['block_size'] . "</td><td align='center' width='30%'> " . $product_details[$i]['pro_amount'] . "</td></tr>";
            }
        }

        $mail_content->product_details = $dataPoints2;
        $mail_content->amount = request('amount');

        $mail_content->product_site = request('product_site');
        $mail_content->block_size = request('block_size');
        $mail_content->pro_amount = request('pro_amount');

//        $data = ['view' => 'mails.sslMail', 'mail_content' => $mail_content, 'bcc' => 'ronak@protocrm.com', 'bccName' => 'Ronak Shah', 'subject' => 'New Order Request from CRM'];
        $data = ['view' => 'mails.sslMail', 'mail_content' => $mail_content, 'bcc' => 'ronak@protocrm.com', 'bccName' => 'Ronak Shah', 'subject' => 'New Order Request from CRM'];
        $emailOb = new Email($data);
//
        Mail::to('team.sprigstack@gmail.com')->send($emailOb); //need to make this ID dynamic once testing is done
//        return view('sslIntegration1');
    }

}
