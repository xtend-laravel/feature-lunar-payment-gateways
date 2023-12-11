<?php

namespace XtendLunar\Features\PaymentGateways\Restify\Actions;

use Binaryk\LaravelRestify\Actions\Action;
use Binaryk\LaravelRestify\Http\Requests\ActionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use Lunar\Facades\Payments;
use Xtend\Extensions\Lunar\Core\Models\Order;
use XtendLunar\Addons\RestifyApi\Notifications\OrderCompletedAdminNotification;
use XtendLunar\Addons\RestifyApi\Notifications\OrderFailedAdminNotification;
use XtendLunar\Features\PaymentGateways\Base\AbstractPaymentGateway;
use XtendLunar\Features\PaymentGateways\Models\PaymentGateway;

class AuthorizePaymentAction extends Action
{
    public function handle(ActionRequest $request, PaymentGateway $models): JsonResponse
    {
        $paymentGateway = $models;

        /** @var Order $order */
        $order = Order::find($request->orderId);
        if (!$order) {
            return response()->json([
                'error' => 'No order found so cannot authorize payment',
            ], 404);
        }

        if (!$cart = $order->cart) {
            return response()->json([
                'error' => 'Cart not found',
            ], 404);
        }

        // if (!$paymentGateway = $models->firstWhere('driver', $request->paymentGateway)) {
        //     return response()->json([
        //         'error' => 'Payment gateway not valid',
        //     ], 422);
        // }

        /** @var AbstractPaymentGateway $paymentDriver */
        $paymentDriver = Payments::driver($paymentGateway->driver);
        $paymentDriver
            ->cart($cart)
            ->order($order)
            ->withData($request->all());

        try {
            $paymentDriver->init();
            $paymentStatus = $paymentDriver->authorize();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        $paymentStatus->success
            ? $this->notifyPaymentSuccess($order)
            : $this->notifyPaymentFailure($order);

        return data([
            'paymentStatus' => $paymentStatus,
        ]);
    }

    protected function notifyPaymentSuccess(Order $order): void
    {
        // $order->user->notify(new OrderStatusPaymentReceived($order, nl2br(request('notes'))));

        Notification::route('mail', config('mail.from.address'))
            ->notify(new OrderCompletedAdminNotification($order));
    }

    protected function notifyPaymentFailure(Order $order): void
    {
        // $order->user->notify(new OrderStatusPaymentError($order));

        Notification::route('mail', config('mail.from.address'))
            ->notify(new OrderFailedAdminNotification($order));
    }
}
