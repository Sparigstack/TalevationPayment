<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Customer;
use DB;

class talevationSyncController extends Controller {

    public function GetContactData(request $request) {

        $token = $request->header('SuperToken');
        if ($token == null || $token != "TalevationSuperToken99") {
            return response()->json([
                        "TalevationCustomerId" => "Unauthorized"
                            ], 401);
        }
        try {
            $fname = '';
            $lname = '';
            $IncomingData = explode(" ", $request->fname);

            //$fname = $IncomingData[0];
            $counter = 0;
            if (isset($IncomingData) && count($IncomingData) > 1) {
                foreach ($IncomingData as $data) {
                    if ($counter == 0) {
                        $fname = $data;
                    } else {
                        $lname = $data;
                    }
                    $counter++;
                }
                $customers = DB::table('customers')->where('first_name', 'LIKE', '%' . $fname . '%')->where('last_name', 'LIKE', '%' . $lname . '%')->get();
            } else {
                $fname = $request->fname;
                $customers = DB::table('customers')->where('first_name', 'LIKE', '%' . $fname . '%')->orWhere('last_name', 'LIKE', '%' . $fname . '%')->orWhere('email', 'LIKE', '%' . $fname . '%')->get();
                //$customers = DB::table('customers')->where('first_name', 'LIKE', '%' . $fname . '%')->orWhere('last_name', 'LIKE', '%' . $fname . '%')->get();
            }
        } catch (Exception $ex) {
            return response()->json([
                        "Error" => $ex->getMessage()
                            ], 400);
        }
        return $customers;
    }

    public function PostContactData(request $request) {
        $token = $request->header('SuperToken');
        if ($token == null || $token != "TalevationSuperToken99") {
            return response()->json([
                        "TalevationCustomerId" => "Unauthorized"
                            ], 401);
        }
        try {
            $customers = new Customer;
            $customers->name = $request->companyName;
            $customers->email = $request->emailAddress;
            $customers->first_name = $request->first_name;
            $customers->last_name = $request->last_name;
            $customers->address1 = $request->Street1;
            $customers->address2 = $request->Street2;
            $customers->state_name = $request->state;
            $customers->city_name = $request->city;
            $customers->zipcode = $request->zipcode;
            $customers->GUID = uniqid();
            $customers->a2_accountId = $request->a2_accountId;
            $customers->a2_contactId = $request->a2_contactId;
            $customers->note = $request->note;



            //$siteNumber = $request->siteNumber;
            if ($request->siteNumber) {
                $customers->site_number = $request->siteNumber;
            } else {
                $customers->site_number = "";
            }

            //$anniversary_Date = $request->anniversary_Date;
            try {
                if ($request->anniversary_Date) {
                    $date = date_create($request->anniversary_Date);
                    $customers->anniversary_date = date_format($date, "Y-m-d");
                } else {
                    $customers->anniversary_date = null;
                }
            } catch (Exception $ex) {
                //do nothing in case of error in anniversary date
            }


            //$qb_customerId = $request->qb_customerId;
            if ($request->qb_customerId == "null") {
                $customers->qb_customerId = null;
            } else {
                $customers->qb_customerId = $request->qb_customerId;
            }

            $customers->save();

            return response()->json([
                        "TalevationCustomerId" => $customers->id
                            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                        "Error" => $ex->getMessage()
                            ], 400);
        }
    }

    public function GetInvoiceData(request $request) {
        $token = $request->header('SuperToken');
        if ($token == null || $token != "TalevationSuperToken99") {
            return response()->json([
                        "TalevationCustomerId" => "Unauthorized"
                            ], 401);
        }
        $customerId = $request->customer_id;
        $getInvoiceByCustomer = DB::table('invoices')->where('customer_id', '=', $customerId)->get();

        return $getInvoiceByCustomer;
    }

    public function PutContactData(request $request) {
        $token = $request->header('SuperToken');
        if ($token == null || $token != "TalevationSuperToken99") {
            return response()->json([
                        "TalevationCustomerId" => "Unauthorized"
                            ], 401);
        }
        $a2Customers = new Customer;
        $a2Customers->exists = true;
        $a2Customers->id = $request->TalevationCustomerId;
        $a2Customers->a2_accountId = $request->a2_accountId;
        $a2Customers->a2_contactId = $request->a2_contactId;

        $a2Customers->save();

        return response()->json([
                    "TalevationCustomerId" => $a2Customers->id
                        ], 200);
    }

    public function shlorder($contactId) {
//        http://netdev2.addresstwo.com/api/Contact?id=26290
//        $data = (object) array('id' => $totalPrice);
//        $data_json = json_encode($data);
        $curl = curl_init(); // URL of the call
        // Disable SSL verification
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // Will return the response, if false it print the response
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, "http://netdev2.addresstwo.com/api/Contact?id=" . $contactId);
        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('SuperTokenAuthentication: AddressTwoSuperToken123'));
//        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_json);
        $result = curl_exec($curl);
        $response = json_decode($result, true);
//        return $response;
        
        
            $com_name = $response['Account']['Name'];

            $street1 = $response['Account']['Address'][0]['Street1'];
            $street2 = $response['Account']['Address'][0]['Street2'];
            $street3 = $response['Account']['Address'][0]['Street3'];
            $state = $response['Account']['Address'][0]['State'];
            $city = $response['Account']['Address'][0]['City'];
            $country = $response['Account']['Address'][0]['Country'];
            $zip = $response['Account']['Address'][0]['Zip'];
            $address = (empty($street1) ? '' : $street1 . ', ') . (empty($street2) ? '' : $street2 . ', ') . (empty($street3) ? '' : $street3 . ', ') . (empty($city) ? '' : $city . ', ') . (empty($state) ? '' : $state . ', ') . (empty($country) ? '' : $country . ', ') . (empty($zip) ? '' : $zip);

            $contactName = $response['FirstName'] . ' ' . $response['LastName'];
            $email_add = '';
            foreach ($response['EmailAddress'] as $emailData) {
                if ($emailData['EntityID'] == $contactId) {
                    $email_add = $emailData['Email'];
                }
            }

            $mob_no = '';
            foreach ($response['PhoneNumber'] as $data) {
                if ($data['EntityId'] == $contactId) {
                    $mob_no = $data['Number'];
                }
            }
            return view('sslIntegration', compact('com_name', 'address', 'country', 'contactName', 'email_add', 'mob_no', 'state', 'city', 'zip'));
        }


//        $counter = 0;
//        if (count($response['PhoneNumber'] >= 1)) {
//        }

        
//        26290 1621747

}
