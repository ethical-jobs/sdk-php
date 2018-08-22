<?php

namespace Tests\Integration\Authentication;

use Mockery;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Cache\Repository;
use EthicalJobs\SDK\Authentication\TokenAuthenticator;
use EthicalJobs\SDK\Testing\ResponseFactory;


use Tests\Helpers\MockResponseStack;

class TokenAuthenticatorTest extends \Tests\TestCase
{
    /**
     * @test
     */
    public function it_can_set_its_credentials_and_get_its_token_from_cache()
    {
        $credentials = [
            'client_id'     => '21',
            'client_secret' => 'aksus73j37sh363hsjs83h37sh363hsjksmde',
            'username'      => 'service-account@ethicaljobs.com.au',
            'password'      => 'slipery-squid-legs',
        ];

        $response = ResponseFactory::response(200, ResponseFactory::authentication());

        $client = Mockery::mock(Client::class)
            ->shouldReceive('request')
            ->once()
            ->withArgs([
                'POST',
                'https://api.ethicaljobs.com.au/oauth/token',
                [
                    'json' => [
                        'grant_type'    => 'password',
                        'scope'         => '*',       
                        'client_id'     => $credentials['client_id'],
                        'client_secret' => $credentials['client_secret'],
                        'username'      => $credentials['username'],
                        'password'      => $credentials['password'],
                    ],
                ],
            ])
            ->andReturn($response)
            ->getMock();               

        $cache = Mockery::mock(Repository::class)
            ->shouldReceive('remember')
            ->once()
            ->withArgs([
                'ej:pkg:sdk:token',
                1080,
                Mockery::on(function($callback) {
                    $this->assertEquals(ResponseFactory::token(), $callback());
                    return true;
                }),
            ])
            ->andReturn('mock-token-aks-sjs-38w')
            ->getMock();  

        $token = (new TokenAuthenticator($client, $cache, $credentials))->getToken();

        $this->assertEquals('mock-token-aks-sjs-38w', $token);
    }    

    /**
     * @test
     */
    public function it_sets_an_authorization_bearer_header()
    {
        $client = Mockery::mock(Client::class);

        $cache = Mockery::mock(Repository::class)
            ->shouldReceive('remember')
            ->once()
            ->withAnyArgs()
            ->andReturn('mock-jwt-token')
            ->getMock(); 

        $original = new Request('GET', 'https://github.com/stars');

        $authenticated = (new TokenAuthenticator($client, $cache))
            ->authenticate($original);

        $expected = [
            'Host'              => ['github.com'],
            'Authorization'     => ['Bearer mock-jwt-token'],
        ];

        $this->assertEquals($expected, $authenticated->getHeaders());
    }        

    /**
     * @test
     */
    public function it_throws_correct_exception_on_401()
    {
        $this->expectException(ClientException::class);

        $response = ResponseFactory::response(401, ResponseFactory::authentication());

        $request = new Request('GET', 'https://github.com/stars');

        MockResponseStack::mock([
            new ClientException('Unauthorized', $request, $response),        
        ]);

        $middleware = resolve(TokenAuthenticator::class);

        try {
            $middleware->authenticate($request);
        } catch (\Exception $exception) {
            $this->assertEquals('Unauthorized SDK Request', $exception->getMessage());
            throw $exception; // Dont swallow exceptions in tests - leads to false positives.
        }
    }      

    /**
     * @test
     */
    public function it_throws_correct_exception_on_403()
    {
        $this->expectException(ClientException::class);

        $response = ResponseFactory::response(403, ResponseFactory::authentication());

        $request = new Request('GET', 'https://github.com/stars');

        MockResponseStack::mock([
            new ClientException('Unauthorized', $request, $response),        
        ]);

        $middleware = resolve(TokenAuthenticator::class);

        try {
            $middleware->authenticate($request);
        } catch (\Exception $exception) {
            $this->assertEquals('Unauthorized SDK Request', $exception->getMessage());
            throw $exception; // Dont swallow exceptions in tests - leads to false positives.
        }
    }    
    
    /**
     * @test
     */
    public function it_does_not_modify_non_auth_exceptions()
    {
        $this->expectException(ClientException::class);

        $response = ResponseFactory::response(404, ResponseFactory::authentication());

        $request = new Request('GET', 'https://github.com/stars');

        MockResponseStack::mock([
            new ClientException('Unauthorized', $request, $response),        
        ]);

        $middleware = resolve(TokenAuthenticator::class);

        try {
            $middleware->authenticate($request);
        } catch (\Exception $exception) {
            $this->assertEquals('Unauthorized', $exception->getMessage());
            throw $exception; // Dont swallow exceptions in tests - leads to false positives.
        }
    }      
}
