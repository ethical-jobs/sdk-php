<?php

namespace Tests\Integration\Repositories\TaxonomyApiRepository;

use Mockery;
use EthicalJobs\SDK\Repositories\TaxonomyApiRepository;
use EthicalJobs\SDK\ApiClient;
use Tests\Fixtures\ResponseFactory;

class WhereTest extends \Tests\TestCase
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
            ->where('status', '=', 'APPROVED');

        $this->assertInstanceOf(TaxonomyApiRepository::class, $isFluent);
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_an_eq_where_query()
    {
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('appData')
            ->withNoArgs()
            ->andReturn(ResponseFactory::taxonomies())
            ->getMock();

        $terms = (new TaxonomyApiRepository($api))
            ->taxonomy('categories')
            ->where('job_count', '=', 50)
            ->find();

        $terms->pluck('job_count')->each(function($jobCount) {
            $this->assertTrue($jobCount == 50);
        });
    } 

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_an_neq_where_query()
    {
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('appData')
            ->withNoArgs()
            ->andReturn(ResponseFactory::taxonomies())
            ->getMock();

        $terms = (new TaxonomyApiRepository($api))
            ->taxonomy('categories')
            ->where('job_count', '!=', 50)
            ->find();

        $terms->pluck('job_count')->each(function($jobCount) {
            $this->assertTrue($jobCount != 50);
        });
    }     

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_an_lte_where_query()
    {
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('appData')
            ->withNoArgs()
            ->andReturn(ResponseFactory::taxonomies())
            ->getMock();

        $terms = (new TaxonomyApiRepository($api))
            ->taxonomy('categories')
            ->where('job_count', '<=', 50)
            ->find();

        $terms->pluck('job_count')->each(function($jobCount) {
            $this->assertTrue($jobCount <= 50);
        });
    }         

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_an_gte_where_query()
    {
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('appData')
            ->withNoArgs()
            ->andReturn(ResponseFactory::taxonomies())
            ->getMock();

        $terms = (new TaxonomyApiRepository($api))
            ->taxonomy('categories')
            ->where('job_count', '>=', 50)
            ->find();

        $terms->pluck('job_count')->each(function($jobCount) {
            $this->assertTrue($jobCount >= 50);
        });
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_an_gt_where_query()
    {
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('appData')
            ->withNoArgs()
            ->andReturn(ResponseFactory::taxonomies())
            ->getMock();

        $terms = (new TaxonomyApiRepository($api))
            ->taxonomy('categories')
            ->where('job_count', '>', 50)
            ->find();

        $terms->pluck('job_count')->each(function($jobCount) {
            $this->assertTrue($jobCount > 50);
        });
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_an_lt_where_query()
    {
        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('appData')
            ->withNoArgs()
            ->andReturn(ResponseFactory::taxonomies())
            ->getMock();

        $terms = (new TaxonomyApiRepository($api))
            ->taxonomy('categories')
            ->where('job_count', '<', 50)
            ->find();

        $terms->pluck('job_count')->each(function($jobCount) {
            $this->assertTrue($jobCount < 50);
        });
    }                                
}
