<?php

namespace XtendLunar\Features\PaymentGateways;

use CodeLabX\XtendLaravel\Base\XtendFeatureProvider;
use Illuminate\Foundation\Events\LocaleUpdated;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Lunar\Facades\Payments;
use Lunar\Hub\Facades\Menu;

class PaymentGatewaysProvider extends XtendFeatureProvider
{
    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/hub.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adminhub');
    }

    public function boot(): void
    {
        Payments::extend('cod', fn ($app) => $app->make(COD::class));

        // @todo Move this to XtendFeatureProvider to check if method exists
        $this->registerWithSidebarMenu();
    }

    protected function registerWithSidebarMenu(): void
    {
        // Note: We listen to LocaleUpdated event to make sure translations are loaded and menu items are all available
        Event::listen(LocaleUpdated::class, function () {
            Menu::slot('sidebar')->section('payment')->addItem(function ($item) {
                $item->name('Gateways')
                     ->handle('hub.payment-gateways')
                     ->route('hub.payment-gateways.index')
                     ->gate('settings:core')
                     ->icon('payments');
            });
        });
    }
}
