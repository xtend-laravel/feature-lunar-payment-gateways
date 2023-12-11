<?php

namespace XtendLunar\Features\PaymentGateways\Controllers;

use Binaryk\LaravelRestify\Http\Requests\ActionRequest;
use Illuminate\Http\Request;
use XtendLunar\Features\PaymentGateways\Models\PaymentGateway;
use XtendLunar\Features\PaymentGateways\Restify\Actions\AuthorizePaymentAction;

class PaymentGatewayIpnController
{
    public function __invoke(Request $request, AuthorizePaymentAction $action)
    {
        $request = ActionRequest::createFrom($request);
        dd($request->all());

        $paymentGateways = PaymentGateway::all()->collect();

        return $action->handle($request, $paymentGateways);
    }
}
