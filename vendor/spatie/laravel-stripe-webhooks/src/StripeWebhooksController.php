<?php

namespace Spatie\StripeWebhooks;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\StripeWebhooks\Middlewares\VerifySignature;
use App\DemoTable;
use App\QbToken;

class StripeWebhooksController extends Controller
{
    public function __construct()
    {
        $this->middleware(VerifySignature::class);
    }

    public function __invoke(Request $request)
    {
        $webhookRequest = $request;
        // $demoTable = new DemoTable();
        // $demoTable->name = "webhook2.3";
        // $demoTable->role = $webhookRequest['data']['object']['amount'];
        // $demoTable->save();
        
        $utility = new \App\Utility;
        $utility->createDepositAPI($webhookRequest);
        $eventPayload = $request->input();

        $modelClass = config('stripe-webhooks.model');

        $stripeWebhookCall = $modelClass::create([
            'type' =>  $eventPayload['type'] ?? '',
            'payload' => $eventPayload,
        ]);

        try {
            $stripeWebhookCall->process();
        } catch (Exception $exception) {
            $stripeWebhookCall->saveException($exception);

            throw $exception;
        }

        return response()->json(['message' => 'ok']);
    }
}
