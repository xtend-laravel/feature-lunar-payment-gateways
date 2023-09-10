<?php

namespace XtendLunar\Features\PaymentGateways\Restify;

use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use XtendLunar\Addons\RestifyApi\Restify\Repository;
use XtendLunar\Features\PaymentGateways\Models\PaymentGateway;
use XtendLunar\Features\PaymentGateways\Restify\Actions\AuthorizePaymentAction;
use XtendLunar\Features\PaymentGateways\Restify\Actions\CapturePaymentAction;
use XtendLunar\Features\PaymentGateways\Restify\Actions\CreatePaymentAction;

class PaymentGatewayRepository extends Repository
{
    public static string $model = PaymentGateway::class;

    public static bool|array $public = false;

    public function actions(RestifyRequest $request): array
    {
        return [
            CreatePaymentAction::new()->onlyOnIndex(),
            CapturePaymentAction::new()->onlyOnIndex(),
            AuthorizePaymentAction::new()->onlyOnIndex(),
        ];
    }
}
