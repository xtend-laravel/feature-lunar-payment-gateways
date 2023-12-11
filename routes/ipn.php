<?php

use Illuminate\Support\Facades\Route;
use XtendLunar\Features\PaymentGateways\Controllers\PaymentGatewayIpnController;

/**
 * Payment Gateways IPN route.
 */
Route::post('/payment-gateway/{payment_gateway:driver}/ipn', PaymentGatewayIpnController::class)->name('payment-gateway.ipn');
