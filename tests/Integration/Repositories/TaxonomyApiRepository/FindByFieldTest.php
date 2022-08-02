<?php

declare(strict_types=1);

namespace Tests\Integration\Repositories\TaxonomyApiRepository;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Repositories\TaxonomyApiRepository;
use EthicalJobs\SDK\Testing\ResponseFactory;
use Mockery;
use Tests\TestCase;

class FindByFieldTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_find_by_a_field()
    {
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('appData')
            ->withNoArgs()
            ->andReturn(ResponseFactory::taxonomies())
            ->getMock();

        $repository = new TaxonomyApiRepository($api);

        $term = $repository
            ->taxonomy('categories')
            ->findByField('title', 'Alcohol and Other Drugs');

        $this->assertEquals($term['id'], 4);
        $this->assertEquals($term['slug'], 'alcoholandotherdrugs');
        $this->assertEquals($term['title'], 'Alcohol and Other Drugs');
        $this->assertTrue(is_numeric($term['job_count']));
    }
}
