<?php

namespace EthicalJobs\Tests\SDK;

use Illuminate\Support\Facades\App;
use EthicalJobs\SDK\Router;

class RouterTest extends \Tests\TestCase
{
    /**
     * @test
     * @group Unit
     */
    public function it_returns_correct_urls_for_environments()
    {
        App::shouldReceive('environment')->once()->andReturn('production');
        $this->assertEquals('https://api.ethicaljobs.com.au/jobs', Router::getRouteUrl('jobs'));

        App::shouldReceive('environment')->once()->andReturn('staging');
        $this->assertEquals('https://api.ethicalstaging.com.au/jobs', Router::getRouteUrl('jobs'));

        App::shouldReceive('environment')->once()->andReturn('testing');
        $this->assertEquals('http://api-app/jobs', Router::getRouteUrl('jobs'));

        App::shouldReceive('environment')->once()->andReturn('development');
        $this->assertEquals('http://api-app/jobs', Router::getRouteUrl('jobs'));                                
    }

    /**
     * @test
     * @group Unit
     */
    public function it_returns_correct_route_with_or_without_slash()
    {
        App::shouldReceive('environment')->andReturn('production');

        $this->assertEquals(
            'https://api.ethicaljobs.com.au/route/to/jobs', 
            Router::getRouteUrl('route/to/jobs')
        );
        $this->assertEquals(
            'https://api.ethicaljobs.com.au/route/to/jobs', 
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
