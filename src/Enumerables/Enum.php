<?php

declare(strict_types=1);

namespace EthicalJobs\SDK\Enumerables;

use Exception;
use ReflectionClass;
use ReflectionException;

/**
 * Base enumberable class
 *
 * @author Andrew McLagan
 */
abstract class Enum
{
    /**
     * Return the constants keys
     *
     * @return array
     * @throws ReflectionException
     */
    public static function allKeys()
    {
        return array_keys((new ReflectionClass(get_called_class()))->getConstants());
    }

    /**
     * Return the constants values
     *
     * @return array
     * @throws ReflectionException
     */
    public static function allValues()
    {
        return array_values((new ReflectionClass(get_called_class()))->getConstants());
    }

    /**
     * Return a random constant
     *
     * @return array $keys
     * @throws ReflectionException
     */
    public static function random()
    {
        return array_rand(static::all());
    }

    /**
     * Return the constants
     *
     * @return array $keys
     * @throws ReflectionException
     */
    public static function all()
    {
        return (new ReflectionClass(get_called_class()))->getConstants();
    }

    /**
     * Return a value from a key
     *
     * @param string $enumKey
     * @return array $keys
     * @throws ReflectionException
     */
    public static function getValue($enumKey = '')
    {
        foreach (self::all() as $key => $value) {
            if (strtolower($key) == strtolower($enumKey)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * Return a key from a value
     *
     * @param string $enumValue
     * @return array $keys
     * @throws ReflectionException
     */
    public static function getKey($enumValue = '')
    {
        foreach (self::all() as $key => $value) {
            if (strtolower($value) == strtolower($enumValue)) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Returns the name of the enumerable key
     *
     * @param $name
     * @param $arguments
     * @return array $keys
     * @throws ReflectionException
     * @throws Exception
     */
    public static function __callStatic($name, $arguments)
    {
        $class = new ReflectionClass(get_called_class());

        if ($class->hasConstant($name)) {
            return $name;
        }

        throw new Exception('Invalid enumerable: ' . $name);
    }
}
