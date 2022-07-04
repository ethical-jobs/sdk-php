<?php

declare(strict_types=1);

namespace Tests\Integration\HttpClient;

use EthicalJobs\SDK\Authentication\NullAuthenticator;
use EthicalJobs\SDK\HttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Mockery;
use Tests\TestCase;

class HttpAuthenticationTest extends TestCase
{
    /**
     * @test
     * @group Integration
     */
    public function it_authenticates_requests_when_authenticate_is_true()
    {
        $client = Mockery::mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->withAnyArgs()
            ->andReturn(new Response)
            ->getMock();

        $auth = Mockery::mock(NullAuthenticator::class)
            ->shouldReceive('authenticate')
            ->once()
            ->andReturn(new Request('GET', 'http://github.com'))
            ->getMock();

        $http = new HttpClient($client, $auth);

        $http->authenticate()->request('GET', '/jobs');
    }

    /**
     * @test
     * @group Integration
     */
    public function it_does_not_authenticate_requests_by_default()
    {
        $client = Mockery::mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->withAnyArgs()
            ->andReturn(new Response)
            ->getMock();

        $auth = Mockery::mock(NullAuthenticator::class)
            ->shouldReceive('authenticate')
            ->never()
            ->getMock();

        $http = new HttpClient($client, $auth);

        $http->request('GET', '/jobs');
    }

    /**
     * @test
     * @group Integration
     */
    public function it_authenticates_all_requests_once_authenticated()
    {
        $client = Mockery::mock(Client::class)
            ->shouldReceive('send')
            ->times(3)
            ->withAnyArgs()
            ->andReturn(new Response)
            ->getMock();

        $auth = Mockery::mock(NullAuthenticator::class)
            ->shouldReceive('authenticate')
            ->times(3)
            ->andReturn(new Request('GET', 'http://github.com'))
            ->getMock();

        $http = new HttpClient($client, $auth);

        $http->authenticate()->request('GET', '/jobs');

        $http->request('GET', '/jobs');

        $http->request('GET', '/jobs');
    }

    /**
     * @test
     * @group Integration
     */
    public function it_fetches_new_token_and_replays_request_when_request_fails_due_to_invalid_token()
    {
        $clientException = $this->createClientException(401, 'Unauthenticated.');

        $client = Mockery::mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andThrow($clientException)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response)
            ->getMock();

        $auth = Mockery::mock(NullAuthenticator::class)
            ->shouldReceive('reset')
            ->times(1)
            ->shouldReceive('authenticate')
            ->times(2)
            ->andReturn(new Request('GET', 'http://github.com'))
            ->getMock();

        $http = new HttpClient($client, $auth);

        $http->authenticate()->request('GET', '/jobs');
    }

    /**
     * @test
     * @group Integration
     */
    public function it_does_not_fetch_new_token_to_replace_invalid_token_when_authenticate_not_called()
    {
        $clientException = $this->createClientException(401, 'Unauthenticated.');

        $client = Mockery::mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andThrow($clientException)
            ->getMock();

        $auth = Mockery::mock(NullAuthenticator::class)
            ->shouldReceive('authenticate')
            ->never()
            ->getMock();

        $this->expectException(ClientException::class);

        $http = new HttpClient($client, $auth);

        $http->request('GET', '/jobs');
    }

    /**
     * @test
     * @group Integration
     */
    public function it_only_attempts_fetching_new_token_once_when_request_fails_due_to_401()
    {
        $clientException = $this->createClientException(401, 'Unauthenticated.');

        $client = Mockery::mock(Client::class)
            ->shouldReceive('send')
            ->twice()
            ->andThrow($clientException)
            ->getMock();

        $auth = Mockery::mock(NullAuthenticator::class)
            ->shouldReceive('reset')
            ->times(1)
            ->shouldReceive('authenticate')
            ->times(2)
            ->andReturn(new Request('GET', 'http://github.com'))
            ->getMock();

        $this->expectException(ClientException::class);

        $http = new HttpClient($client, $auth);

        $http->authenticate()->request('GET', '/jobs');
    }
}
