<?php

namespace EthicalJobs\Tests\SDK;

use Mockery;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\HttpClient;
use EthicalJobs\SDK\Repositories;
use EthicalJobs\SDK\ApiClient;

class ApiClientTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_correct_resource_properties()
    {
        $api = App::make(ApiClient::class);

        $this->assertInstanceOf(Repositories\JobApiRepository::class, $api->jobs);
        
        // Taxonomy repository has a HTTP call in its constructor.
        Cache::shouldReceive('remember')->once()->andReturn([]);

        $this->assertInstanceOf(Repositories\TaxonomyApiRepository::class, $api->taxonomies);
    }

    /**
     * @test
     * @group Unit
     */
    public function it_has_http_verb_methods()
    {
        foreach (['get','post','put','patch','delete'] as $verb) {

            $http = Mockery::mock(HttpClient::class)
                ->shouldReceive($verb)
                ->once()
                ->withAnyArgs(['/jobs', ['status' => 'APPROVED']])
                ->andReturn('success')
                ->getMock();

            $client = new ApiClient($http);

            $result = $client->$verb('/jobs', ['status' => 'APPROVED']);

            $this->assertEquals('success', $result);
        }
    }      

    /**
     * @test
     * @group Unit
     */
    public function it_has_request_method()
    {
        $response = new Collection;

        $http = Mockery::mock(HttpClient::class)
            ->shouldReceive('request')
            ->once()
            ->withAnyArgs(['GET', '/jobs', ['status' => 'APPROVED']])
            ->andReturn($response)
            ->getMock();

        $client = new ApiClient($http);

        $result = $client->request('GET', '/jobs', ['status' => 'APPROVED']);

        $this->assertInstanceOf(Collection::class, $result);
    } 

   /**
     * @test
     * @group Unit
     */
    public function it_can_retrieve_app_data()
    {
        $http = Mockery::mock(HttpClient::class)
            ->shouldReceive('get')
            ->once()
            ->with('/')
            ->andReturn(new Collection(['data' => []]))
            ->getMock();

        $client = new ApiClient($http);

        $results = $client->appData();

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($results->toArray(), ['data' => []]);
    }                 

   /**
     * @test
     * @group Unit
     */
    public function it_can_cache_app_data()
    {
        $returnValue = new Collection(['data' => []]);

        $valudateCacheClosure = Mockery::on(function ($colsure) {
            $colsure();
            return true;
        });

        Cache::shouldReceive('remember')
            ->once()
            ->with('ej:sdk:app-data', 120, $valudateCacheClosure)
            ->andReturn($returnValue);

        $http = Mockery::mock(HttpClient::class)
            ->shouldReceive('get')
            ->once()
            ->with('/')
            ->andReturn($returnValue)
            ->getMock();

        $client = new ApiClient($http);

        $results = $client->appData();

        $this->assertInstanceOf(Collection::class, $results);
        $this->assertEquals($results->toArray(), $returnValue->toArray());
    }       
}
