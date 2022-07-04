<?php

declare(strict_types=1);

namespace Tests\Integration\Repositories\ApiRepository;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Repositories\ApiRepository;
use Mockery;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_can_update_an_entity_and_return_it()
    {
        $expected = new Collection(['entities' => 'invoices']);

        $api = Mockery::mock(ApiClient::class)
            ->shouldReceive('patch')
            ->once()
            ->with('/invoices/245', [
                'amount' => 123.34,
                'payment' => 'cc',
            ])
            ->andReturn($expected)
            ->getMock();

        $repository = new ApiRepository($api, 'invoices');

        $result = $repository->update(245, [
            'amount' => 123.34,
            'payment' => 'cc',
        ]);

        $this->assertEquals($expected, $result);
    }
}
