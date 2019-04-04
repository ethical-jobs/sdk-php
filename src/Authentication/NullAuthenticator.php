<?php

namespace EthicalJobs\SDK\Authentication;

use GuzzleHttp\Psr7\Request;

/**
 * Null Authenticator (mainly used for testing)
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class NullAuthenticator implements Authenticator
{
    /**
     * {@inheritdoc}
     */
    public function authenticate(Request $request)
    {
        return $request;
    }
}