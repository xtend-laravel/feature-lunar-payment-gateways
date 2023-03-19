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
            ['name' => 'PayPal'],
            ['name' => 'Stripe'],
            ['name' => 'Bank Transfer'],
            ['name' => 'Cash on Delivery'],
        ])->each(function ($gateway) {
            PaymentGateway::create($gateway);
        });
    }
}
