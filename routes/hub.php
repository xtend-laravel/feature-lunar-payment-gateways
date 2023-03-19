<?php

use Illuminate\Support\Facades\Route;
use Lunar\Hub\Http\Middleware\Authenticate;
use XtendLunar\Features\PaymentGateways\Livewire\Pages\PaymentGatewaysIndex;

/**
 * Payment Gateways routes.
 */
Route::group([
    'prefix' => config('lunar-hub.system.path', 'hub'),
    'middleware' => ['web', Authenticate::class, 'can:settings:core'],
], function () {
    Route::get('/payment-gateways', PaymentGatewaysIndex::class)->name('hub.payment-gateways.index');
});
