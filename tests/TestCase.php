<?php

namespace Tests;

use EthicalJobs\SDK\Laravel\ServiceProvider;
use EthicalJobs\SDK\Testing\ResponseFactory;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Foundation\Application;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
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

    protected function createClientException($statusCode, $message) {
        $request = new Request('GET', 'https://github.com/stars');

        $response = ResponseFactory::response($statusCode, '');

        return new ClientException($message, $request, $response);
    }
}
