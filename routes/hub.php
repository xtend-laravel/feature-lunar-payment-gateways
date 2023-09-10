<?php

use Illuminate\Support\Facades\Route;
use Lunar\Hub\Http\Middleware\Authenticate;
use XtendLunar\Features\PaymentGateways\Livewire\Pages\PaymentGatewayIndex;
use XtendLunar\Features\PaymentGateways\Livewire\Pages\PaymentGatewayShow;

/**
 * Payment Gateways routes.
 */
Route::group([
    'prefix' => config('lunar-hub.system.path', 'hub'),
    'middleware' => ['web', Authenticate::class, 'can:settings:core'],
], function () {
    Route::get('/payment-gateways', PaymentGatewayIndex::class)->name('hub.payment-gateways.index');
    Route::get('/payment-gateway/{paymentGateway}', PaymentGatewayShow::class)->name('hub.payment-gateway.show');
});
