<?php

namespace XtendLunar\Features\PaymentGateways;

use Binaryk\LaravelRestify\Traits\InteractsWithRestifyRepositories;
use CodeLabX\XtendLaravel\Base\XtendFeatureProvider;
use Illuminate\Foundation\Events\LocaleUpdated;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Lunar\Hub\Facades\Menu;
use XtendLunar\Features\PaymentGateways\Livewire\Components\PaymentGatewaysTable;
use XtendLunar\Features\PaymentGateways\Models\PaymentGateway;
use XtendLunar\Features\PaymentGateways\Policies\PaymentGatewayPolicy;

class PaymentGatewaysProvider extends XtendFeatureProvider
{
    use InteractsWithRestifyRepositories;

    protected $policies = [
        PaymentGateway::class => PaymentGatewayPolicy::class,
    ];

    public function register(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/hub.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/ipn.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'adminhub');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadRestifyFrom(__DIR__.'/Restify', __NAMESPACE__.'\\Restify\\');
    }

    public function boot(): void
    {
        Livewire::component('hub.components.payment-providers.table', PaymentGatewaysTable::class);

        // $this->registerWithSidebarMenu();

        // PaymentGateway::truncate();
        // collect([
        //     ['name' => 'PayPal', 'driver' => 'paypal'],
        //     ['name' => 'Stripe', 'driver' => 'stripe'],
        //     ['name' => 'Bank Transfer', 'driver' => 'bank-transfer'],
        //     ['name' => 'Cash on Delivery', 'driver' => 'cod'],
        // ])->each(function ($gateway) {
        //     PaymentGateway::create($gateway);
        // });
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
