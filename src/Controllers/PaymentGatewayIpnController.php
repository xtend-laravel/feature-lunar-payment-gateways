<?php

namespace XtendLunar\Features\PaymentGateways\Controllers;

use Binaryk\LaravelRestify\Http\Requests\ActionRequest;
use Illuminate\Http\Request;
use XtendLunar\Features\PaymentGateways\Models\PaymentGateway;
use XtendLunar\Features\PaymentGateways\Restify\Actions\AuthorizePaymentAction;

class PaymentGatewayIpnController
{
    protected string $tempPassword = 'Jx0hHSIcsE4YqR8VJXvJ1KG9IadumXusbI3rchic6XvDK';

    public function __invoke(Request $request, PaymentGateway $paymentGateway, AuthorizePaymentAction $action)
    {
        // $request = ActionRequest::createFrom($request);
        // $request->merge([
        //     'paymentGateway' => $paymentGateway->driver,
        // ]);
        //
        // $paymentGateways = PaymentGateway::all()->collect();
        //
        // return $action->handle($request, $paymentGateways);


        // STEP 1 : check the signature with the password
        if (!$this->checkHash($request->all(), $this->tempPassword)) {
           return data([
               'error' => 'Invalid signature',
               'data' => $request->all(),
           ], 422);
        }

        $answer = array();
        $answer['kr-hash'] = $_POST['kr-hash'];
        $answer['kr-hash-algorithm'] = $_POST['kr-hash-algorithm'];
        $answer['kr-answer-type'] = $_POST['kr-answer-type'];
        $answer['kr-answer'] = json_decode($_POST['kr-answer'], true);

        /* STEP 2 : get some parameters from the answer */
        $orderStatus = $answer['kr-answer'] ['orderStatus'];
        $orderId = $answer['kr-answer']['orderDetails']['orderId'];
        $transactionUuid = $answer['kr-answer']['transactions'][0]['uuid'];

        return data([
            'orderStatus' => $orderStatus,
            'orderId' => $orderId,
            'transactionUuid' => $transactionUuid,
        ]);
    }

    protected function checkHash($data, $key)
    {
       $supported_sign_algos = array('sha256_hmac');
       if (!in_array($data['kr-hash-algorithm'], $supported_sign_algos)) {
           return false;
       }
       $kr_answer = str_replace('\/', '/', $data['kr-answer']);
       $hash = hash_hmac('sha256', $kr_answer, $key);
       return ($hash == $data['kr-hash']);
    }
}
