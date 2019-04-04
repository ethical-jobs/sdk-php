<?php

namespace Tests;

use EthicalJobs\SDK\Laravel\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        putenv('API_HOST=api.ethicalstaging.com.au'); // don't use production in case a test mutates data
        putenv('API_SCHEME=https');
    }

    /**
     * Inject package service provider
     *
     * @param Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
        ];
    }
}