<?php

namespace Tests\Integration\Repositories\ApiRepository;

use Mockery;
use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\ApiRepository;

class SearchTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_has_fluent_interface()
    {
        $api = Mockery::mock(ApiClient::class);

        $repository = new ApiRepository($api);

        $isFluent = $repository->search('cats and dogs');

        $this->assertInstanceOf(ApiRepository::class, $isFluent);
    }   

    /**
     * @test
     * @group Unit
     */
    public function it_can_add_a_search_term_query()
    {
        $expected = new Collection(['entities' => 'jobs']);

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('get')
            ->once()
            ->with('/invoices', [
                'q' => 'cats and dogs',
            ])
            ->andReturn($expected)
            ->getMock();

        $repository = new ApiRepository($api, 'invoices');

        $repository
            ->search('cats and dogs')
            ->find();
    } 
}
