<?php
/**
 * @author José Jaime Ramírez Calvo <mr.ljaime@gmail.com>
 * @version 1
 * @since 1
 */

namespace App\Util;

/**
 * Aux class to make operations over arrays
 *
 * class ArrayUtil
 * @package App\Util
 */
class ArrayUtil
{
    /**
     * Use to get value from array in safe way to avoid key not found errors
     *
     * @param array $from
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public static function safe($from, $key, $default = null)
    {
        if (is_null($from)) {
            return $default;
        }

        if (!array_key_exists($key, $from)) {
            return $default;
        }

        return $from[$key];
    }
}