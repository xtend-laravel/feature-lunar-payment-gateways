<?php

namespace XtendLunar\Features\PaymentGateways\Livewire\Components;

use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Lunar\Hub\Http\Livewire\Traits\Notifies;
use XtendLunar\Features\PaymentGateways\Models\PaymentGateway;

class PaymentGatewaysTable extends Component implements Tables\Contracts\HasTable
{
    use Notifies;
    use Tables\Concerns\InteractsWithTable;

    /**
     * {@inheritDoc}
     */
    protected function getTableQuery(): Builder
    {
        return PaymentGateway::query();
    }

    /**
     * {@inheritDoc}
     */
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
            Tables\Columns\IconColumn::make('is_enabled')
                ->label('Enabled')
                ->boolean()
                ->trueIcon('heroicon-o-badge-check')
                ->falseIcon('heroicon-o-x-circle'),
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getTableActions(): array
    {
        return [
             Tables\Actions\ActionGroup::make([
                 Tables\Actions\Action::make('Test Integration')->url(fn (PaymentGateway $record): string => route('hub.payment-gateway.show', ['paymentGateway' => $record])),
             ]),
        ];
    }

    /**
     * Render the livewire component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('adminhub::livewire.components.tables.base-table')
            ->layout('adminhub::layouts.base');
    }
}
