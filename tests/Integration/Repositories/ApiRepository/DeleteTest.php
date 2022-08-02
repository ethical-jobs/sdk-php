<?php

declare(strict_types=1);

namespace Tests\Integration\Repositories\ApiRepository;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\ApiRepository;
use Mockery;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_delete_an_entity_and_return_it()
    {
        $expected = new Collection(['entities' => 'invoices']);

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('delete')
            ->once()
            ->with('/invoices/245')
            ->andReturn($expected)
            ->getMock();

        $repository = new ApiRepository($api, 'invoices');

        $result = $repository->delete(245);

        $this->assertEquals($expected, $result);
    }
}
