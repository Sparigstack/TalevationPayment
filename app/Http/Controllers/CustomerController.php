<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Invoice;
use App\Term;
use Redirect;
use Illuminate\Support\Facades\Auth;
use DB;

class CustomerController extends Controller {

    //
    public function customer() {
        if (!Auth::check()) {
            return redirect('/');
        }
        $customers = Customer::all();
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
        $customers->GUID = $request->cus_GUID;
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

}
