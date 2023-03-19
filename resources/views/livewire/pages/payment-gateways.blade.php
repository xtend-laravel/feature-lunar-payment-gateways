<div class="flex-col space-y-4">
    <div class="flex items-center justify-between">
        <strong class="text-lg font-bold md:text-2xl">
            {{ __('Payment Gateways') }}
        </strong>
    </div>

    @livewire('hub.components.payment-providers.table')
</div>
