<?php

namespace XtendLunar\Addons\PaymentGateways\Restify\Presenters;

use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use XtendLunar\Addons\RestifyApi\Restify\Contracts\Presentable;
use XtendLunar\Addons\RestifyApi\Restify\Presenters\PresenterResource;

class PaymentGatewayPresenter extends PresenterResource implements Presentable
{
    public function transform(RestifyRequest $request): array
    {
        return $this->data;
    }
}
