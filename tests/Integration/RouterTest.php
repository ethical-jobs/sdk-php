<?php

declare(strict_types=1);

namespace EthicalJobs\Tests\SDK;

use EthicalJobs\SDK\Router;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class RouterTest extends TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function testTestEnvironmentUrlCorrect()
    {
        self::assertEquals('http://fail-connection-plox/jobs', Router::getRouteUrl('jobs'));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_returns_correct_route_with_or_without_slash()
    {
        App::shouldReceive('environment')->andReturn('production');

        $this->assertEquals(
            'http://fail-connection-plox/route/to/jobs',
            Router::getRouteUrl('route/to/jobs')
        );
        $this->assertEquals(
            'http://fail-connection-plox/route/to/jobs',
            Router::getRouteUrl('/route/to/jobs')
        );
    }

    /**
     * @test
     * @group Unit
     */
    public function it_can_return_resource_routes()
    {
        App::shouldReceive('environment')->andReturn('production');

        $this->assertEquals('/invoices/drafts', Router::getResourceRoute('invoices', 'drafts'));
        $this->assertEquals('/invoices/drafts', Router::getResourceRoute('/invoices', '/drafts'));
    }
}
