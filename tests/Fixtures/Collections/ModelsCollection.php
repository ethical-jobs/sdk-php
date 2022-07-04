<?php

namespace Tests\Fixtures\Collections;

use EthicalJobs\SDK\Storage\LegacyCollection;
use Tests\Fixtures\Models;

class ModelsCollection extends LegacyCollection
{
    /**
     * Create a new collection.
     *
     * @return array
     */
    public static function items()
    {
        return [
            'families' => Models\Family::class,
            'people' => Models\Person::class,
            'vehicles' => Models\Vehicle::class,
        ];
    }
}
