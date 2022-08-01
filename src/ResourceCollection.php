<?php

declare(strict_types=1);

namespace EthicalJobs\SDK;

use EthicalJobs\SDK\Repositories;
use EthicalJobs\SDK\Storage\Contracts\Repository;
use Illuminate\Support\Facades\App;

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
     * @return array<string, class-string<\EthicalJobs\SDK\Repositories\ApiRepository>>
     */
    protected static function resources(): array
    {
        return [
            'jobs' => Repositories\JobApiRepository::class,
            'taxonomies' => Repositories\TaxonomyApiRepository::class,
        ];
    }

    /**
     * Make a resource repository instance
     *
     * @param class-string<Repository> $repository
     * @return Repository
     */
    public static function makeResourceRepository(string $repository): Repository
    {
        $api = App::make(ApiClient::class);

        return new $repository($api);
    }
}
