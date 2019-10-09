<?php

namespace Tests\Integration\Authentication;

use EthicalJobs\SDK\ApiClient;
use EthicalJobs\SDK\Authentication\AccessTokenFetcher;
use EthicalJobs\SDK\Authentication\TokenAuthenticator;
use EthicalJobs\SDK\Testing\ResponseFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Illuminate\Contracts\Cache\Repository;
use Mockery;
use Tests\TestCase;

class TokenAuthenticatorTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_set_its_credentials_and_get_its_token_from_cache()
    {
        $accessTokenFetcher = Mockery::mock(AccessTokenFetcher::class)
            ->shouldReceive('fetchToken')
            ->once()
            ->andReturn('my token :)')
            ->getMock();

        $cache = Mockery::mock(Repository::class)
            ->shouldReceive('remember')
            ->once()
            ->withArgs([
                'ej:pkg:sdk:token',
                1080,
                Mockery::on(function ($callback) {
                    $this->assertEquals('my token :)', $callback());

                    return true;
                }),
            ])
            ->andReturn('mock-token-aks-sjs-38w')
            ->getMock();

        $token = (new TokenAuthenticator($accessTokenFetcher, $cache))->getToken();

        $this->assertEquals('mock-token-aks-sjs-38w', $token);
    }

    /**
     * @test
     */
    public function it_sets_an_authorization_bearer_header()
    {
        $accessTokenFetcher = Mockery::mock(AccessTokenFetcher::class)
            ->shouldReceive('fetchToken')
            ->once()
            ->andReturn('hi-i-am-a-very-secure-access-token-ok-bye')
            ->getMock();

        $cache = resolve(Repository::class);

        $original = new Request('GET', 'https://github.com/stars');

        $authenticated = (new TokenAuthenticator($accessTokenFetcher, $cache))
            ->authenticate($original);

        $expected = [
            'Host' => ['github.com'],
            'Authorization' => ['Bearer hi-i-am-a-very-secure-access-token-ok-bye'],
        ];

        $this->assertEquals($expected, $authenticated->getHeaders());
    }

}
