<?php

namespace EthicalJobs\SDK\Laravel;

use EthicalJobs\SDK\ApiClient;
use Illuminate\Support\Facades\Facade;

/**
 * Laravel facade accessor
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class ApiFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ApiClient::class;
    }
}