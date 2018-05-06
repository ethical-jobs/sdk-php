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
	 * Returns full URL for a requet route
	 * 
	 * @param string $route
	 * @return string
	 */
	public static function getRouteUrl(string $route)
	{
		switch (App::environment()) {
			case 'staging':
				$host = 'https://api.ethicalstaging.com.au';
				break;						
			case 'development':	
			case 'testing':
				$host = 'http://api-app';
				break;			
			case 'production':
			default:
				$host = 'https://api.ethicaljobs.com.au';
				break;
		}

		return "{$host}".self::sanitizeRoute($route);
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