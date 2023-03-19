<?php

namespace XtendLunar\Features\PaymentGateways\Base;

use Lunar\PaymentTypes\AbstractPayment;

abstract class PaymentGateway extends AbstractPayment
{
    protected static string $name;

    protected static bool $showInMenu = false;

    protected static string $route;
}
