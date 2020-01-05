<?php

namespace CompassHB\Ccb\Traits;

use ReflectionClass;

trait Enum
{

    /**
     * gets class constants with key and value
     * @return array
     */
    static function constants() : array
    {

        $refl = new ReflectionClass(__CLASS__);

        return $refl->getConstants();
    }

    /**
     * gets class constant values
     * @return array
     */
    static function constantValues() : array
    {

        $refl = new ReflectionClass(__CLASS__);

        $output = array();

        foreach ($refl->getConstants() as $key => $value) {
            $output[] = $value;
        }

        return $output;
    }

    /**
     * checks if value is a class constant
     * @param  [string]  $val [value to check]
     * @return boolean
     */
    static function has($val) : bool
    {

        $constants = self::constantValues();

        return in_array($val, $constants);
    }

    static function get($val) : array
    {
        $constants = self::constantValues();

        if (self::has($val)) {
            return $constants[$val];
        }

        return [];
    }
}
