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

        // @todo Get payment driver instance from payment gateway
        $paymentGateway = $models->firstWhere(
            fn ($model) => $model->id == $request->paymentGatewayId,
        );

        if (!$paymentGateway) {
            return response()->json([
                'error' => 'Payment gateway not valid',
            ], 422);
        }

        /** @var AbstractPaymentGateway $paymentDriver */
        $paymentDriver = Payments::driver($paymentGateway->driver);

        $paymentDriver->cart($cart->calculate())->withData($request->all());
        // @todo Optimise calculate() method takes too long to execute

        try {
            $paymentDriver->init();
            $paymentRequest = $paymentDriver->create();
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 422);
        }

        return data([
            ...$paymentRequest,
        ]);
    }
}
