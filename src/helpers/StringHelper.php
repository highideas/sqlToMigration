<?php

namespace Highideas\SqlToMigration\helpers;

class StringHelper
{

    /**
     * Prepare a string using PascalCase syntax
     * 
     * @param string $value value to be formatted
     * @return string formatted value
     */
    public static function pascalCase($value = null)
    {
        if (is_null($value)) {
            return $value;
        }
        $value = preg_replace(['/_/', '/-/'], ' ', $value);
        $value = ucwords(strtolower($value));
        return str_replace(' ', '', $value);
    }
}
