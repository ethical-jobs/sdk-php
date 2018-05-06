<?php

namespace Tests\Integration\Repositories\TaxonomyApiRepository;

use Mockery;
use EthicalJobs\SDK\Repositories\TaxonomyApiRepository;
use EthicalJobs\SDK\ApiClient;
use Tests\Fixtures\ResponseFactory;

class FindByIdTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_find_by_id()
    {
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('appData')
            ->withNoArgs()
            ->andReturn(ResponseFactory::taxonomies())
            ->getMock();

        $repository = new TaxonomyApiRepository($api);

        $term = $repository
            ->taxonomy('categories')
            ->findById(7);

        $this->assertEquals($term, [
            'id'        => 7,
            'slug'      => 'careandsupportservices',
            'title'     => 'Care and Support Work',
            'job_count' => 79,
        ]);
    }        
}
