<?php

namespace Dealskoo\Brand\Tests;

use Dealskoo\Brand\Providers\BrandServiceProvider;

abstract class TestCase extends \Dealskoo\Billing\Tests\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            BrandServiceProvider::class
        ];
    }

    protected function getPackageAliases($app)
    {
        return [];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
    }
}
