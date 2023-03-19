<?php

namespace XtendLunar\Features\PaymentGateways;

use CodeLabX\XtendLaravel\Base\XtendFeatureProvider;
use Illuminate\Foundation\Events\LocaleUpdated;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Lunar\Facades\Payments;
use Lunar\Hub\Facades\Menu;
use XtendLunar\Features\PaymentGateways\Livewire\Components\PaymentGatewaysTable;

class PaymentGatewaysProvider extends XtendFeatureProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/hub.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adminhub');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function boot(): void
    {
        Livewire::component('hub.components.payment-providers.table', PaymentGatewaysTable::class);
        Payments::extend('cod', fn ($app) => $app->make(COD::class));

        // @todo Move this to XtendFeatureProvider to check if method exists
        $this->registerWithSidebarMenu();
    }

    protected function registerWithSidebarMenu(): void
    {
        Event::listen(LocaleUpdated::class, function () {
            Menu::slot('sidebar')
                ->group('hub.configure')
                ->section('hub.payment-gateways')
                ->name('Payment')
                ->route('hub.payment-gateways.index')
                ->icon('credit-card');
        });
    }
}
