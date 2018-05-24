<?php

namespace Tests\Integration\HttpClient;

use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\HttpClient;

class HttpVerbTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_all_http_verb_functions()
    {
        $verbs = ['get','post','put','patch','delete'];

        $http = new HttpClient(new Client);

        foreach ($verbs as $verb) {
        	$this->assertTrue(method_exists($http, $verb));
        }
    }

    /**
     * @test
     * @group Unit
     */
    public function its_verb_functions_generate_valid_requests()
    {
        $verbs = ['post','put','patch','delete']; // See below for GET verb

        foreach ($verbs as $verb) {

            $expected = new Request(
                strtoupper($verb), 
                'http://api-app/jobs', 
                [
                    'Content-Type' => 'application/json',
                    'Accept'       => 'application/json',
                    'X-Custom' => 'foo',
                ],
                json_encode(['foo' => 'bar'])
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
            $this->assertEquals((string) $expected->getBody(), (string) $actual->getBody());
        }
    }

    /**
     * @test
     * @group Unit
     */
    public function its_GET_verb_function_generate_valid_requests()
    {
        $params = [
            'username' => 'andrewmclagan',
            'forks'     => 0,
            'repos'     => 1,
        ];

        $expected = new Request(
            'GET',
            'http://api-app/repos?username=andrewmclagan&forks=0&repos=1',
            [
                'Content-Type'  => 'application/json',
                'Accept'        => 'application/json',
                'X-Custom'      => 'foo',
            ],
            json_encode($params)
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
