<?php

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
    public function it_returns_correct_urls_for_host()
    {
        putenv('API_HOST'); // omitting value removes the env var
        putenv('API_SCHEME');
        $this->assertEquals('https://api.ethicaljobs.com.au/jobs', Router::getRouteUrl('jobs'));

        putenv('API_HOST');
        putenv('API_SCHEME=https');
        $this->assertEquals('https://api.ethicaljobs.com.au/jobs', Router::getRouteUrl('jobs'));

        putenv('API_HOST=api.ethicaljobs.com.au');
        putenv('API_SCHEME');
        $this->assertEquals('https://api.ethicaljobs.com.au/jobs', Router::getRouteUrl('jobs'));

        putenv('API_HOST=api.ethicaljobs.com.au');
        putenv('API_SCHEME=https');
        $this->assertEquals('https://api.ethicaljobs.com.au/jobs', Router::getRouteUrl('jobs'));

        putenv('API_HOST=api.ethicalstaging.com.au');
        putenv('API_SCHEME=https');
        $this->assertEquals('https://api.ethicalstaging.com.au/jobs', Router::getRouteUrl('jobs'));

        putenv('API_HOST=api-local');
        putenv('API_SCHEME=http');
        $this->assertEquals('http://api-local/jobs', Router::getRouteUrl('jobs'));
    }

    /**
     * @test
     * @group Unit
     */
    public function it_returns_correct_route_with_or_without_slash()
    {
        App::shouldReceive('environment')->andReturn('production');

        $this->assertEquals(
            'https://api.ethicalstaging.com.au/route/to/jobs',
            Router::getRouteUrl('route/to/jobs')
        );
        $this->assertEquals(
            'https://api.ethicalstaging.com.au/route/to/jobs',
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
