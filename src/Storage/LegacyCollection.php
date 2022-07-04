<?php

declare(strict_types=1);

namespace EthicalJobs\SDK\Storage;

use Illuminate\Support\Collection as LaravelCollection;

class LegacyCollection extends LaravelCollection
{
    public function __construct($items = [])
    {
        if (count($items)) {
            parent::__construct($items);
        } else {
            parent::__construct(static::items());
        }
    }

    /**
     * Create a new collection.
     *
     */
    public static function items()
    {
        return [];
    }


    public static function instances(): LaravelCollection
    {
        $instances = new LaravelCollection;

        foreach (static::make()->all() as $key => $value) {
            if ($instance = self::instance($key)) {
                $instances->put($key, $instance);
            }
        }

        return $instances;
    }

    /**
     * Create an instance of a collection item
     *
     * @param string $key
     * @return mixed
     */
    public static function instance(string $key)
    {
        $collection = static::make();

        $class = $collection->get($key) ?? '';

        if (class_exists($class)) {
            return resolve($class);
        }

        return null;
    }
}
