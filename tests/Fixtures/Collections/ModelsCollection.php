<?php

namespace Tests\Fixtures\Collections;

use EthicalJobs\Storage\Collection;
use Tests\Fixtures\Models;

class ModelsCollection extends Collection
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
