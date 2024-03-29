<?php

declare(strict_types=1);

namespace EthicalJobs\SDK\Repositories;

use EthicalJobs\SDK\ApiClient;

/**
 * Api resource repository
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class JobApiRepository extends ApiRepository
{
    /**
     * Object constructor
     *
     * @param ApiClient $api
     * @return void
     */
    public function __construct(ApiClient $api)
    {
        parent::__construct($api, 'jobs');
    }
}
