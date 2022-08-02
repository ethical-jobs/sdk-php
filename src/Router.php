<?php

declare(strict_types=1);

namespace EthicalJobs\SDK;

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
    public static function getRouteUrl(string $route): string
    {
        $host = env('API_HOST') ?? 'api.ethicaljobs.com.au';

        $scheme = env('API_SCHEME') ?? 'https';

        return $scheme . '://' . $host . self::sanitizeRoute($route);
    }

    /**
     * Sanitizes a route into acceptable format
     *
     * @param string $route
     * @return string
     */
    protected static function sanitizeRoute(string $route = ''): string
    {
        return '/' . ltrim($route, '/');
    }

    /**
     * Return route to the resource
     *
     * @param string $resource
     * @param string $route
     * @return string
     */
    public static function getResourceRoute(string $resource, string $route = ''): string
    {
        return static::sanitizeRoute($resource) . static::sanitizeRoute($route);
    }
}
