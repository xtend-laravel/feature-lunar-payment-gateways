<?php

namespace XtendLunar\Features\PaymentGateways\Livewire\Pages;

use Illuminate\View\View;
use Livewire\Component;
use Lunar\Hub\Http\Livewire\Traits\Notifies;
use Lunar\Hub\Http\Livewire\Traits\WithLanguages;

class PaymentGatewaysIndex extends Component
{
    use Notifies;
    use WithLanguages;

    public function render(): View
    {
        return view('adminhub::livewire.pages.payment-gateways')
            ->layout('adminhub::layouts.app', [
                'title' => __('Shipping Providers'),
            ]);
    }
}
