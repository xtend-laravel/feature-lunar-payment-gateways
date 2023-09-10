<?php

namespace XtendLunar\Features\PaymentGateways\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use XtendLunar\Features\PaymentGateways\Models\PaymentGateway;

class PaymentGatewayPolicy
{
    use HandlesAuthorization;

    public function allowRestify(User $user = null): bool
    {
        return true;
    }

    public function show(User $user = null, PaymentGateway $model): bool
    {
        return true;
    }

    public function store(User $user): bool
    {
        return false;
    }

    public function storeBulk(User $user): bool
    {
        return false;
    }

    public function update(User $user, PaymentGateway $model): bool
    {
        return false;
    }

    public function updateBulk(User $user, PaymentGateway $model): bool
    {
        return false;
    }

    public function deleteBulk(User $user, PaymentGateway $model): bool
    {
        return false;
    }

    public function delete(User $user, PaymentGateway $model): bool
    {
        return false;
    }
}
