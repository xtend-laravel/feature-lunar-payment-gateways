<?php

namespace XtendLunar\Features\PaymentGateways\Restify\Actions;

use Binaryk\LaravelRestify\Actions\Action;
use Binaryk\LaravelRestify\Http\Requests\ActionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Lunar\Facades\Payments;
use Lunar\Models\Cart;
use XtendLunar\Features\PaymentGateways\Base\AbstractPaymentGateway;

class CreatePaymentAction extends Action
{
    public function handle(ActionRequest $request, Collection $models): JsonResponse
    {
        /** @var Cart $cart */
        $cart = Cart::find($request->cartId);
        if (!$cart) {
            return response()->json([
                'error' => 'Cart not found',
            ], 404);
        }

        $paymentGateway = $models->firstWhere('driver', $request->paymentGateway);

        if (!$paymentGateway) {
            return response()->json([
                'error' => 'Payment gateway not valid',
            ], 422);
        }

        /** @var AbstractPaymentGateway $paymentDriver */
        $paymentDriver = Payments::driver($paymentGateway->driver);
        $paymentDriver->cart($cart->calculate())->withData($request->all());

        $paymentDriver->init();
        $paymentRequest = $paymentDriver->create();

        return data([
            ...$paymentRequest,
        ]);
    }
}
