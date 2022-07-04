<?php

declare(strict_types=1);

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

        putenv('API_HOST=fail-connection-plox'); // don't rely on live external services for tests
        putenv('API_SCHEME=http');
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
