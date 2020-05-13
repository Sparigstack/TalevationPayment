<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use EllipseSynergie\ApiResponse\Contracts\Response;
use App\Customer;
use App\DemoTable;
use DB;
use Stripe;

class StripePayoutController extends Controller {

    public function stripePayout(request $request){
        require_once('../vendor/stripe/stripe-php/init.php');
        require_once('../vendor/stripe/stripe-php/lib/Subscription.php');
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        // $stripePayout = \Stripe\Payout::all(['limit' => 3]);
        $body = @file_get_contents('php://input');
        $jsonData = json_decode($body);
        // http_response_code(200);
        $demoTable = new DemoTable();
        $demoTable->name = "mansi";
        $demoTable->role = "test role";
        $demoTable->save();
        return $jsonData;
        // return view('stripePayout');
    }

}