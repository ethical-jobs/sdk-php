<?php

namespace EthicalJobs\SDK;

use Illuminate\Support\Facades\App;
use EthicalJobs\SDK\Repositories;
use EthicalJobs\Storage\Contracts\Repository;

/**
 * Api resource collection
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */

class ResourceCollection extends \Illuminate\Support\Collection
{
    /**
     * Create a new collection.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(static::resources());
    }    

    /**
     * Returns api resources
     *
     * @return array
     */
    protected static function resources(): array
    {
        return [
            'jobs'          => Repositories\JobApiRepository::class,
            'taxonomies'    => Repositories\TaxonomyApiRepository::class,
        ];
    }

    /**
     * Make a resource repository instance
     *
     * @param string $repository
     * @return EthicalJobs\SDK\ApiResource
     */
    public static function makeResourceRepository(string $repository): Repository
    {
        $api = App::make(ApiClient::class);

        return new $repository($api);
    }    
}