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
     * @group Unit
     */
    public function it_authenticates_requests()
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

        $http->request('GET', '/jobs');
    }    
}
