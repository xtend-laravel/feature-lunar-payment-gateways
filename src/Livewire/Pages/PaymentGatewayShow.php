<?php

namespace XtendLunar\Features\PaymentGateways\Livewire\Pages;

use Illuminate\View\View;
use Livewire\Component;
use Lunar\Facades\Payments;
use Lunar\Hub\Http\Livewire\Traits\Notifies;
use Lunar\Models\Cart;
use Lunar\Models\Product;
use Lunar\Models\ProductVariant;
use Lunar\PaymentTypes\AbstractPayment;
use XtendLunar\Features\PaymentGateways\Models\PaymentGateway;

class PaymentGatewayShow extends Component
{
    use Notifies;

    public PaymentGateway $paymentGateway;

    public function mount(PaymentGateway $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;

        if ($this->paymentGateway->name === 'PayPal') {
            $this->testPaypal();
        }
    }

    public function render(): View
    {
        return view('adminhub::livewire.pages.payment-gateway-show')
            ->layout('adminhub::layouts.app', [
                'title' => __('Payment Providers'),
            ]);
    }

    protected function testPaypal()
    {
        $cart = $this->dummyCart();
        $cart->calculate();

        /** @var AbstractPayment $paymentDriver */
        $paymentDriver = Payments::driver('paypal');
        $paymentDriver->cart($cart)->withData(request()->all());

        try {
            $paymentStatus = $paymentDriver->init()->authorize();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return data([
            'paymentStatus' => $paymentStatus,
        ]);
    }

    protected function dummyCart(): Cart
    {
        $products = Product::all()->take(5);

        /** @var Cart $cart */
        $cart = Cart::query()->first();

        foreach ($products as $product) {
            $cart->lines()->updateOrCreate([
                'purchasable_type' => ProductVariant::class,
                'purchasable_id' => $product->variants->first()->id,
            ], [
                'quantity' => 1,
            ]);
        }

        // create shipping address
        $cart->shippingAddress()->updateOrCreate([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'line_one' => '123 Main St',
            'line_two' => 'Apt 1',
            'city' => 'New York',
            'state' => 'NY',
            'postcode' => '10001',
            'country_id' => 233,
        ]);

        return $cart;
    }
}
