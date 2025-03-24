<?php

namespace App\Helpers;

class ArrayHelper
{
    /**
     * Convert an array or collection to an object
     *
     * @param array|object $array The array or collection to convert
     * @return object|null The resulting object or null if empty
     */
    public static function toObject($array)
    {
        if (empty($array)) {
            return null;
        }
        
        // If it's a collection with items, get the first item
        if (is_object($array) && method_exists($array, 'first') && $array->count() > 0) {
            return $array->first();
        }
        
        // If it's an array with at least one item
        if (is_array($array) && count($array) > 0) {
            return (object) $array[0];
        }
        
        // Otherwise, just cast to object 
        return (object) $array;
    }
}
