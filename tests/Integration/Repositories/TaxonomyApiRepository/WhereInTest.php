<?php

namespace Tests\Integration\Repositories\TaxonomyApiRepository;

use Mockery;
use EthicalJobs\SDK\Repositories\TaxonomyApiRepository;
use EthicalJobs\SDK\ApiClient;
<<<<<<< HEAD
use Tests\Fixtures\ResponseFactory;
=======
use EthicalJobs\Tests\SDK\Fixtures;
use EthicalJobs\SDK\Testing\ResponseFactory;
>>>>>>> release/v1.2.0

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

<<<<<<< HEAD
        $terms = (new TaxonomyApiRepository($api))
            ->taxonomy('locations')
            ->whereIn('id', [1,17,14,10])
            ->find();

        $slugs = $terms->pluck('slug')->toArray();

        $this->assertEquals($slugs, [
            'VIC','REGSA','REGNT','INTERNATIONAL'
        ]);
=======
        $repository = new TaxonomyApiRepository($api);

        $terms = $repository
            ->taxonomy('locations')
            ->whereIn('id', [2,4,6])
            ->find();

        $slugs = $terms
            ->pluck('slug')
            ->toArray();

        $this->assertEquals($slugs, ['REGVIC','REGNSW','REGQLD']);
>>>>>>> release/v1.2.0
    }    
}

