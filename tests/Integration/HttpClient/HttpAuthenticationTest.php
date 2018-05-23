<?php

namespace Tests\Integration\HttpClient;

use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use EthicalJobs\SDK\Authentication\NullAuthenticator;
use EthicalJobs\SDK\HttpClient;

class HttpAuthenticationTest extends \Tests\TestCase
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
}
