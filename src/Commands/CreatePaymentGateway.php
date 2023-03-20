<?php

namespace XtendLunar\Features\PaymentGateways\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\PackageManifest;
use Illuminate\Support\Composer;

class CreatePaymentGateway extends Command
{
    protected $signature = 'xtend-lunar:payment-gateway 
        {name : The name of the payment gateway}
        {--force : Overwrite existing files}';

    protected $description = 'Create a new payment gateway';

    public function __construct(
        protected Filesystem $filesystem,
        protected Composer $composer)
    {
        parent::__construct();
    }

    public function handle(PackageManifest $packageManifest): int
    {
        $this->packageManifest = $packageManifest;

        return self::SUCCESS;
    }
}
