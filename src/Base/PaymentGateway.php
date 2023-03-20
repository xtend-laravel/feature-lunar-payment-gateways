<?php

namespace XtendLunar\Features\PaymentGateways\Base;

use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use Lunar\Base\DataTransferObjects\PaymentCapture;
use Lunar\Base\DataTransferObjects\PaymentRefund;
use Lunar\Models\Transaction;
use Lunar\PaymentTypes\AbstractPayment;

class PaymentGateway extends AbstractPayment
{
    protected static string $name;

    protected static bool $showInMenu = false;

    protected static string $route;

    public function authorize(): PaymentAuthorize
    {
        // TODO: Implement authorize() method.
    }

    public function refund(Transaction $transaction, int $amount, $notes = null): PaymentRefund
    {
        // TODO: Implement refund() method.
    }

    public function capture(Transaction $transaction, $amount = 0): PaymentCapture
    {
        // TODO: Implement capture() method.
    }
}
