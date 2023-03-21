<?php

namespace XtendLunar\Addons\PaymentGateways\Restify;

use XtendLunar\Addons\RestifyApi\Restify\Repository;
use XtendLunar\Features\PaymentGateways\Models\PaymentGateway;

class PaymentGatewayRepository extends Repository
{
    public static string $model = PaymentGateway::class;

    public static bool|array $public = false;
}
