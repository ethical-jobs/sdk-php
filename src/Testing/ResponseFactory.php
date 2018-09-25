<?php

namespace EthicalJobs\SDK\Testing;

use EthicalJobs\SDK\Collection;
use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\json_decode;

/**
 * Api response factory
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class ResponseFactory
{
	/**
	 * Token response
	 *
	 * @return String
	 */
	public static function token(): string
	{
		return 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjZkMWY1NzhkNDFjZTg3ZTNmMDMzZDE1M2VmYmYzM2EzYmUzMjNjMzgyM2I2MmQ1YjVmOWFlOWU1ODk5YTA0NTZkZDUyMzI4ZGY5ZDg0NjU5In0';
	}

	/**
	 * Authentication response
	 *
	 * @return GuzzleHttp\Psr7\Response
	 */
	public static function authentication()
	{
		$response = json_decode('
			{
				"token_type": "Bearer",
				"expires_in": 31536000,
				"access_token": "'.static::token().'"
			}
		', true);

		return new Collection($response);
	}


	/**
	 * User resource response
	 *
	 * @return GuzzleHttp\Psr7\Response
	 */
	public static function user()
	{
		$string = file_get_contents(__DIR__.'/responses/user.json');

		$response = json_decode($string, true);

		return new Collection($response);
	}			


	/**
	 * Job resource response
	 *
	 * @return GuzzleHttp\Psr7\Response
	 */
	public static function job()
	{
		$string = file_get_contents(__DIR__.'/responses/job.json');

		$response = json_decode($string, true);

		return new Collection($response);
	}		

	/**
	 * Jobs resource response
	 *
	 * @param int $status
	 * @return GuzzleHttp\Psr7\Response
	 */
	public static function jobs()
	{
		$string = file_get_contents(__DIR__.'/responses/jobs.json');

		$response = json_decode($string, true);

		return new Collection($response);
	}

	/**
	 * Jobs search resource response
	 *
	 * @param int $status
	 * @return GuzzleHttp\Psr7\Response
	 */
	public static function jobsSearch()
	{
		$string = file_get_contents(__DIR__.'/responses/search.jobs.json');

		$response = json_decode($string, true);

		return new Collection($response);
	}	


	/**
	 * Taxonomy request response
	 *
	 * @return  array
	 */
	public static function taxonomies()
	{
		$string = file_get_contents(__DIR__.'/responses/app.data.json');

		$response = json_decode($string, true);
        
		return new Collection($response);
	}	

	/**
	 * Mocks a response object with stream
	 * 
	 * @param int $status
	 * @param mixed $data
	 * @return GuzzleHttp\Psr7\Response
	 */
	public static function response(int $status, $data): Response
	{
		$encoded = json_encode($data, true);

		$stream = \GuzzleHttp\Psr7\stream_for($encoded);

		$headers = ['Content-Type' => 'application/json'];

		return new Response($status, $headers, $stream);
	}	    
}