<?php

declare(strict_types=1);

namespace Tests\Integration\HttpClient;

use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\HttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Mockery;
use Tests\TestCase;

class HttpResponseTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_get_the_last_response()
    {
        $expected = new Response(201);

        $client = Mockery::mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn($expected)
            ->getMock();

        $http = new HttpClient($client);

        $http->request('GET', '/jobs');

        $actual = $http->getResponse();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_get_the_last_response_even_on_404_exception()
    {
        $expected = new Response(404);

        $client = Mockery::mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn($expected)
            ->getMock();

        $http = new HttpClient($client);

        $http->request('GET', '/jobs');

        $actual = $http->getResponse();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_always_returns_a_collection_on_success()
    {
        $response = new Response(
            201,
            ['Content-Type' => 'application/json', 'Accept' => 'application/json',],
            json_encode(['foo' => 'bar'])
        );

        $client = Mockery::mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn($response)
            ->getMock();

        $http = new HttpClient($client);

        $result = $http->request('GET', '/jobs');

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertEquals($result->toArray(), ['foo' => 'bar']);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_always_returns_an_empty_collection_on_404()
    {
        $response = new Response(
            404,
            ['Content-Type' => 'application/json', 'Accept' => 'application/json',]
        );

        $client = Mockery::mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn($response)
            ->getMock();

        $http = new HttpClient($client);

        $result = $http->request('GET', '/jobs');

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertTrue($result->isEmpty());
    }
}
