<?php

namespace XtendLunar\Features\PaymentGateways\Restify;

use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Xtend\Extensions\Lunar\Core\Models\ProductVariant;
use XtendLunar\Addons\RestifyApi\Restify\Repository;
use XtendLunar\Features\PaymentGateways\Models\PaymentGateway;
use XtendLunar\Features\PaymentGateways\Restify\Actions\AuthorizePaymentAction;
use XtendLunar\Features\PaymentGateways\Restify\Actions\CapturePaymentAction;
use XtendLunar\Features\PaymentGateways\Restify\Actions\CreatePaymentAction;

class PaymentGatewayRepository extends Repository
{
    public static string $model = PaymentGateway::class;

    public static bool|array $public = false;

    protected static function booting(): void
    {
        $repositoryId = request()->route()->parameter('repositoryId');
        if (is_string($repositoryId)) {
            if ($repository = PaymentGateway::query()->firstWhere('driver', $repositoryId)) {
                request()->route()->setParameter('repositoryId', $repository->id);
            }
        }
    }

    public function actions(RestifyRequest $request): array
    {
        return [
            CreatePaymentAction::new()->onlyOnIndex(),
            CapturePaymentAction::new()->onlyOnIndex(),
            AuthorizePaymentAction::new()->onlyOnShow(),
        ];
    }
}
