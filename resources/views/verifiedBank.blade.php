<?php
//use Stripe;
// Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
require_once('../vendor/stripe/stripe-php/init.php');
require_once('../vendor/stripe/stripe-php/lib/Subscription.php');
Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
//Stripe\Stripe::setApiKey('sk_test_YWrmxxCNxfB5ZHsKxbFeQzrv');
$body = @file_get_contents('php://input');
$jsonData = json_decode($body);
var_dump($jsonData);
?>