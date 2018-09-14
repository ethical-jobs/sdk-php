<?php

namespace EthicalJobs\SDK;

use Illuminate\Support\Facades\App;

/**
 * Route, endpoint and url helper class
 *
 * @author  Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class Router
{
	/**
	 * Returns full URL for a request route
	 * 
	 * @param string $route
	 * @return string
	 */
	public static function getRouteUrl(string $route)
	{
		$host = env('API_HOST') ?? 'api.ethicaljobs.com.au';

		$scheme = env('API_SCHEME') ?? 'https';

		return $scheme . '://' . $host . self::sanitizeRoute($route);
	}

   	/**
   	 * Return route to the resource
   	 *
   	 * @param  String $resource 
   	 * @param  String $route
   	 * @return String
   	 */
    public static function getResourceRoute($resource, $route = '')
    {   	
    	return static::sanitizeRoute($resource).static::sanitizeRoute($route);
    }		

   	/**
   	 * Sanitizes a route into acceptable format
   	 * 
   	 * @param  String $route
   	 * @return String
   	 */
    protected static function sanitizeRoute($route = '')
    {   	
    	return '/'.ltrim($route, '/');
    }	    
}