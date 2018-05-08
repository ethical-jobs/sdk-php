<?php

namespace Tests\Integration\Repositories\TaxonomyApiRepository;

use Mockery;
use EthicalJobs\SDK\Repositories\TaxonomyApiRepository;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Testing\ResponseFactory;

class OrderByTest extends \Tests\TestCase
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
            ->orderBy('approved_at', 'DESC');

        $this->assertInstanceOf(TaxonomyApiRepository::class, $isFluent);
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_orderBy_desc_query()
    {
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('appData')
            ->withNoArgs()
            ->andReturn(ResponseFactory::taxonomies())
            ->getMock();

        $terms = (new TaxonomyApiRepository($api))
            ->taxonomy('locations')
            ->orderBy('slug', 'DESC')
            ->find();

        $this->assertEquals($terms->pluck('slug')->toArray(), [
            'WA',
            'VIC',
            'TAS',
            'SA',
            'REGWA',
            'REGVIC',
            'REGTAS',
            'REGSA',
            'REGQLD',
            'REGNT',
            'REGNSW',
            'QLD',
            'NT',
            'NSW',
            'INTERNATIONAL',
            'AUSTRALIAWIDE',
            'ACT',
        ]);
    }    

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_orderBy_asc_query()
    {
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('appData')
            ->withNoArgs()
            ->andReturn(ResponseFactory::taxonomies())
            ->getMock();

        $terms = (new TaxonomyApiRepository($api))
            ->taxonomy('locations')
            ->orderBy('slug', 'ASC')
            ->find();

        $this->assertEquals($terms->pluck('slug')->toArray(), [
            'ACT',
            'AUSTRALIAWIDE',
            'INTERNATIONAL',
            'NSW',
            'NT',
            'QLD',
            'REGNSW',
            'REGNT',
            'REGQLD',
            'REGSA',
            'REGTAS',
            'REGVIC',
            'REGWA',
            'SA',
            'TAS',
            'VIC',
            'WA',
        ]);
    }        
}
