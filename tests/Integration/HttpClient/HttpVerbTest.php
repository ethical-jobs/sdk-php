<?php

declare(strict_types=1);

namespace Tests\Integration\HttpClient;

use EthicalJobs\SDK\HttpClient;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Mockery;
use Tests\TestCase;

class HttpVerbTest extends TestCase
{
    /** @group Unit */
    public function testProvidesMethodsForExpectedHttpVerbs(): void
    {
        $verbs = ['get', 'post', 'put', 'patch', 'delete'];

        $http = new HttpClient(new Client);

        foreach ($verbs as $verb) {
            $this->assertTrue(method_exists($http, $verb));
        }
    }

    /** @group Unit */
    public function testVerbMethodsGenerateValidRequestsWithJsonBody(): void
    {
        $verbs = ['post', 'put', 'patch'];

        foreach ($verbs as $verb) {

            $expected = new Request(
                strtoupper($verb),
                'https://api.ethicalstaging.com.au/jobs',
                [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'X-Custom' => 'foo',
                ],
                json_encode(['foo' => 'bar'], JSON_THROW_ON_ERROR)
            );

            $client = Mockery::mock(Client::class)
                ->shouldReceive('send')
                ->once()
                ->andReturn(new Response)
                ->getMock();

            $http = new HttpClient($client);

            $http->$verb('/jobs', ['foo' => 'bar'], ['X-Custom' => 'foo']);

            $actual = $http->getRequest();

            $this->assertEquals($expected->getMethod(), $actual->getMethod());
            $this->assertEquals($expected->getUri(), $actual->getUri());
            $this->assertEquals($expected->getHeaders(), $actual->getHeaders());
            $this->assertEquals((string)$expected->getBody(), (string)$actual->getBody());
        }
    }

    /** @group Unit */
    public function testDeleteMethodGeneratesValidRequestWithNoBody(): void
    {
        $params = [
            'username' => 'andrewmclagan',
            'forks' => 18,
            'repos' => 6,
        ];

        $expected = new Request(
            'DELETE',
            'https://api.ethicalstaging.com.au/jobs/33?username=andrewmclagan&forks=18&repos=6',
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'X-Custom' => 'foo',
            ]
        );

        $client = Mockery::mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response)
            ->getMock();

        $http = new HttpClient($client);

        $http->delete('/jobs/33', $params, ['X-Custom' => 'foo']);

        $actual = $http->getRequest();

        self::assertSame($expected->getMethod(), $actual->getMethod());
        self::assertEquals($expected->getUri(), $actual->getUri());
        self::assertSame($expected->getHeaders(), $actual->getHeaders());
        self::assertSame((string)$expected->getBody(), (string)$actual->getBody());
    }

    /** @group Unit */
    public function testGetMethodGeneratesValidRequestWithNoBody(): void
    {
        $params = [
            'username' => 'andrewmclagan',
            'forks' => 0,
            'repos' => 1,
        ];

        $expected = new Request(
            'GET',
            'https://api.ethicalstaging.com.au/repos?username=andrewmclagan&forks=0&repos=1',
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'X-Custom' => 'foo',
            ]
        );

        $client = Mockery::mock(Client::class)
            ->shouldReceive('send')
            ->once()
            ->andReturn(new Response)
            ->getMock();

        $http = new HttpClient($client);

        $http->get('/repos', $params, ['X-Custom' => 'foo']);

        $actual = $http->getRequest();

        $this->assertEquals($expected->getMethod(), $actual->getMethod());
        $this->assertEquals($expected->getUri(), $actual->getUri());
        $this->assertEquals($expected->getHeaders(), $actual->getHeaders());
        $this->assertEquals((string)$expected->getBody(), (string)$actual->getBody());
    }
}
