<?php

namespace Tests\Fixtures;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use Illuminate\Support\Facades\App;

/**
 * Mocks guzzle http response stacks
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class MockResponseStack
{
	/**
	 * Mocks a response stack
	 * 
	 * @param array $responses
	 * @return void
	 */
	public static function mock(array $responses): void
	{
        $responseStack = new MockHandler($responses);

        $guzzle = new Client(['handler' => HandlerStack::create($responseStack)]);            

        App::instance(Client::class, $guzzle);
	}
}