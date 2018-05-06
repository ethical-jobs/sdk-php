<?php

namespace EthicalJobs\SDK\Enumerables;

/**
 * Base enumberable class
 *
 * @author Andrew McLagan
 */

abstract class Enum
{
    /**
     * Return the constants
     *
     * @return Array $keys
     */
    public static function all()
    {
        return (new \ReflectionClass(get_called_class()))->getConstants();
    }

    /**
     * Return the constants keys
     *
     * @return Array
     */
    public static function allKeys()
    {
        return array_keys((new \ReflectionClass(get_called_class()))->getConstants());
    }    

    /**
     * Return the constants values
     *
     * @return Array
     */
    public static function allValues()
    {
        return array_values((new \ReflectionClass(get_called_class()))->getConstants());
    }       

    /**
     * Return a random constant
     *
     * @return Array $keys
     */
    public static function random()
    {
        return array_rand(static::all());
    }

    /**
     * Return a value from a key
     *
     * @return Array $keys
     */
    public static function getValue($enumKey = '')
    {
        foreach (self::all() as $key => $value ) {
            if (strtolower($key) == strtolower($enumKey)) {
                return $value;
            }
        }
        return null;
    }

    /**
     * Return a key from a value
     *
     * @return Array $keys
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
     * @return Array $keys
     */
    public static function __callStatic($name, $arguments)
    {
        $class = new \ReflectionClass(get_called_class());

        if ($class->hasConstant($name)) {
            return $name;
        }

        throw new \Exception('Invalid enumerable: '.$name);
    }
}
