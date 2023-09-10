<?php

namespace XtendLunar\Features\PaymentGateways\Base;

use Lunar\Base\DataTransferObjects\PaymentAuthorize;
use Lunar\Base\DataTransferObjects\PaymentCapture;
use Lunar\Base\DataTransferObjects\PaymentRefund;
use Lunar\Models\Transaction;
use Lunar\PaymentTypes\AbstractPayment;

class AbstractPaymentGateway extends AbstractPayment
{
    public function create(): mixed
    {
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function authorize(): PaymentAuthorize
    {
        return new PaymentAuthorize(success: true);
    }

    /**
     * {@inheritDoc}
     */
    public function refund(Transaction $transaction, int $amount, $notes = null): PaymentRefund
    {
        return new PaymentRefund(success: true);
    }

    /**
     * {@inheritDoc}
     */
    public function capture(Transaction $transaction, $amount = 0): PaymentCapture
    {
        return new PaymentCapture(success: true);
    }
}
