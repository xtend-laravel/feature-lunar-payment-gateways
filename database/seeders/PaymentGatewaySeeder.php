<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use XtendLunar\Features\PaymentGateways\Models\PaymentGateway;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            ['name' => 'PayPal', 'driver' => 'paypal'],
            ['name' => 'Stripe', 'driver' => 'stripe'],
            ['name' => 'Bank Transfer', 'driver' => 'bank-transfer'],
            ['name' => 'Cash on Delivery', 'driver' => 'cod'],
        ])->each(function ($gateway) {
            PaymentGateway::create($gateway);
        });
    }
}
