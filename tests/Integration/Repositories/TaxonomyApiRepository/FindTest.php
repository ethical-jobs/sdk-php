<?php

namespace Tests\Integration\Repositories\TaxonomyApiRepository;

use Mockery;
use EthicalJobs\SDK\Repositories\TaxonomyApiRepository;
use EthicalJobs\SDK\ApiClient;
use Tests\Fixtures\ResponseFactory;

class FindTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_execute_the_query()
    {
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('appData')
            ->withNoArgs()
            ->andReturn(ResponseFactory::taxonomies())
            ->getMock();

        $repository = new TaxonomyApiRepository($api);

        $terms = $repository
            ->taxonomy('categories')
            ->find();

        $expected = array_get(ResponseFactory::taxonomies(), 'data.taxonomies.categories');

        $this->assertEquals($terms->toArray(), $expected);
    }     
}
