<?php

namespace EthicalJobs\SDK\Authentication;

use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Cache\Repository;

/**
 * Token Authenticator
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class TokenAuthenticator implements Authenticator
{
    /**
     * Auth token cache key
     *
     * @var string
     */
    protected $tokenKey = 'ej:pkg:sdk:token';

    /**
     * Auth token cache lifespan (minutes)
     *
     * @var string
     */
    protected $tokenTTL = 45; // refresh the token every 45 minutes (accounts for token expiring after 1 hour)

    /**
     * @var AccessTokenFetcher $accessTokenFetcher
     */
    protected $accessTokenFetcher;

    /**
     * Cache instance
     *
     * @var Repository
     */
    protected $cache;

    /**
     * Object constructor
     *
     * @param AccessTokenFetcher $accessTokenFetcher
     * @param Repository $cache
     */
    public function __construct(AccessTokenFetcher $accessTokenFetcher, Repository $cache)
    {
        $this->accessTokenFetcher = $accessTokenFetcher;

        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(Request $request)
    {
        $token = $this->getToken();

        return $request->withAddedHeader('Authorization', "Bearer $token");
    }

    /**
     * Gets the token
     *
     * @return string
     */
    public function getToken(): string
    {
        return $this->cache->remember($this->tokenKey, $this->tokenTTL, function () {
            return $this->accessTokenFetcher->fetchToken();
        });
    }

}