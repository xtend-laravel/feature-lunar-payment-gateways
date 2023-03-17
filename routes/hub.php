<?php

use Illuminate\Support\Facades\Route;
use Lunar\Hub\Http\Middleware\Authenticate;

/**
 * Payment Gateways routes.
 */
Route::group([
    'prefix' => config('lunar-hub.system.path', 'hub'),
    'middleware' => ['web', Authenticate::class, 'can:settings:core'],
], function () {

});
