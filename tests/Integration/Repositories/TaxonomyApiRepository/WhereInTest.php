<?php

namespace Tests\Integration\Repositories\TaxonomyApiRepository;

use Mockery;
use EthicalJobs\SDK\Repositories\TaxonomyApiRepository;
use EthicalJobs\SDK\ApiClient;
use Tests\Fixtures\ResponseFactory;

class WhereInTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $api = Mockery::mock(ApiClient::class)
            ->shouldIgnoreMissing();

        $repository = new TaxonomyApiRepository($api);

        $isFluent = $repository
            ->whereIn('locations', [1,28,298,23,7]);

        $this->assertInstanceOf(TaxonomyApiRepository::class, $isFluent);
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_whereIn_query()
    {
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('appData')
            ->withNoArgs()
            ->andReturn(ResponseFactory::taxonomies())
            ->getMock();

        $terms = (new TaxonomyApiRepository($api))
            ->taxonomy('locations')
            ->whereIn('id', [1,17,14,10])
            ->find();

        $slugs = $terms->pluck('slug')->toArray();

        $this->assertEquals($slugs, [
            'VIC','REGSA','REGNT','INTERNATIONAL'
        ]);
    }    
}
