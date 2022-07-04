<?php

declare(strict_types=1);

namespace Tests\Integration\Repositories\TaxonomyApiRepository;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Repositories\TaxonomyApiRepository;
use EthicalJobs\SDK\Testing\ResponseFactory;
use Illuminate\Support\Arr;
use Mockery;
use Tests\TestCase;

class FindTest extends TestCase
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

        $expected = Arr::get(ResponseFactory::taxonomies(), 'data.taxonomies.categories');

        $this->assertEquals($terms->toArray(), $expected);
    }
}
