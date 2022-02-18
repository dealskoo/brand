<?php

namespace Dealskoo\Brand\Tests;

use Dealskoo\Brand\Providers\BrandServiceProvider;

abstract class TestCase extends \Dealskoo\Admin\Tests\TestCase
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
}
