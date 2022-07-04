<?php

declare(strict_types=1);

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
     * @param Request $request
     * @return Request
     */
    public function authenticate(Request $request);

    /**
     * Forgets cached auth token
     *
     */
    public function reset();
}
