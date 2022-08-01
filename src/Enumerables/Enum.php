<?php

declare(strict_types=1);

namespace EthicalJobs\SDK\Enumerables;

use Exception;
use ReflectionClass;
use ReflectionException;

/**
 * Base enumeration class
 *
 * @author Andrew McLagan
 */
abstract class Enum
{
    /**
     * Return the constants keys
     *
     * @return array<int, string>
     */
    public static function allKeys(): array
    {
        return array_keys(static::all());
    }

    /**
     * Return the constants values
     *
     * @return array<int, string>
     */
    public static function allValues(): array
    {
        return array_values(static::all());
    }

    /**
     * Return a random constant
     */
    public static function random(): string
    {
        return array_rand(static::all());
    }

    /**
     * Return the constants
     *
     * @return array<string, string>
     */
    public static function all(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }

    /**
     * Return a value from a key
     */
    public static function getValue(string $enumKey = ''): ?string
    {
        foreach (static::all() as $key => $value) {
            if (strtolower($key) === strtolower($enumKey)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * Return a key from a value
     */
    public static function getKey(string $enumValue = ''): ?string
    {
        foreach (static::all() as $key => $value) {
            if (strtolower($value) === strtolower($enumValue)) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Returns the name of the enumerable key
     *
     * @param string $name
     * @param array<int|string, mixed> $arguments
     * @throws Exception
     */
    public static function __callStatic(string $name, array $arguments): string
    {
        $class = new ReflectionClass(static::class);

        if ($class->hasConstant($name)) {
            return $name;
        }

        throw new Exception('Invalid enumeration key: ' . $name);
    }
}
