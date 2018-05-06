<?php

namespace EthicalJobs\SDK\Authentication;

use GuzzleHttp\Psr7\Request;

/**
 * Request authenticator contract
 *
 * @author  Andrew McLagan <andrew@ethicaljobs.com.au>
 */

interface Authenticator
{
	/**
	 * Authenticates a request instance
	 * 
	 * @param  GuzzleHttp\Psr7\Request $request
	 * @return GuzzleHttp\Psr7\Request
	 */
	public function authenticate(Request $request);
}