<?php

namespace EthicalJobs\SDK\Testing;

use EthicalJobs\SDK\Collection;
use EthicalJobs\SDK\Enumerables;
use Faker\Factory;
use ReflectionException;

/**
 * Api resource factory - create items for an api resource
 *
 * @author Andrew McLagan <andrew@ethicaljobs.com.au>
 */
class ResourceFactory
{
    /**
     * Authentication response
     *
     * @param int $numberOfJobs
     * @return Collection
     * @throws ReflectionException
     */
    public static function jobs(int $numberOfJobs = 100)
    {
        $faker = Factory::create();

        $response = new Collection;

        for ($i = 0; $i < $numberOfJobs; $i++) {
            $response->push([
                'id' => rand(76, 10000),
                'organisation_id' => rand(76, 10000),
                'organisation_uid' => $faker->userName,
                'status' => Enumerables\JobStatus::random(),
                'title' => $faker->realText(60),
            ]);
        }

        return $response;
    }
}