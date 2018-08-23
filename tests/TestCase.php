<?php

namespace Tests;

use EthicalJobs\SDK\Laravel\ServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
	/**
	 * Setup the test environment.
	 * 
	 * @return void
	 */
	protected function setUp()
	{
	    parent::setUp();

	    putenv('API_HOST=https://api.ethicaljobs.com.au');
	}

	/**
	 * Inject package service provider
	 * 
	 * @param  Application $app
	 * @return Array
	 */
	protected function getPackageProviders($app)
	{
	    return [
	    	ServiceProvider::class,
	   	];
	}
}