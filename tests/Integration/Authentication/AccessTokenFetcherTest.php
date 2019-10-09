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

class AccessTokenFetcherTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_fetch()
    {
        $credentials = [
            'client_id' => '21',
            'client_secret' => 'aksus73j37sh363hsjs83h37sh363hsjksmde',
            'username' => 'service-account@ethicaljobs.com.au',
            'password' => 'slipery-squid-legs',
        ];

        $response = ResponseFactory::response(200, ResponseFactory::authentication());

        $client = Mockery::mock(Client::class)
            ->shouldReceive('request')
            ->once()
            ->withArgs([
                'POST',
                'https://api.ethicalstaging.com.au/oauth/token',
                [
                    'json' => [
                        'grant_type' => 'password',
                        'scope' => '*',
                        'client_id' => $credentials['client_id'],
                        'client_secret' => $credentials['client_secret'],
                        'username' => $credentials['username'],
                        'password' => $credentials['password'],
                    ],
                ],
            ])
            ->andReturn($response)
            ->getMock();

        $accessTokenFetcher = new AccessTokenFetcher($client, $credentials);

        $token = $accessTokenFetcher->fetchToken();

        $this->assertEquals(ResponseFactory::token(), $token);
    }

    /**
     * @test
     */
    public function it_throws_correct_exception_on_401()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Unauthorized SDK Request');

        $clientException = $this->createClientException(401, 'Unauthorized');

        $client = Mockery::mock(Client::class)
            ->shouldReceive('request')
            ->once()
            ->andThrow($clientException)
            ->getMock();

        $accessTokenFetcher = new AccessTokenFetcher($client, []);

        $accessTokenFetcher->fetchToken();
    }

    /**
     * @test
     */
    public function it_throws_correct_exception_on_403()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Unauthorized SDK Request');

        $clientException = $this->createClientException(403, 'Unauthorized');

        $client = Mockery::mock(Client::class)
            ->shouldReceive('request')
            ->once()
            ->andThrow($clientException)
            ->getMock();

        $accessTokenFetcher = new AccessTokenFetcher($client, []);

        $accessTokenFetcher->fetchToken();
    }

    /**
     * @test
     */
    public function it_does_not_modify_non_auth_exceptions()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Not Found');

        $clientException = $this->createClientException(404, 'Not Found');

        $client = Mockery::mock(Client::class)
            ->shouldReceive('request')
            ->once()
            ->andThrow($clientException)
            ->getMock();

        $accessTokenFetcher = new AccessTokenFetcher($client, []);

        $accessTokenFetcher->fetchToken();
    }

    protected function createClientException($statusCode, $message) {
        $request = new Request('GET', 'https://github.com/stars');

        $response = ResponseFactory::response($statusCode, '');

        return new ClientException($message, $request, $response);
    }

}
