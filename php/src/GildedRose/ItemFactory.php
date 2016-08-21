<?php namespace GildedRose;

use Exception;

/**
 * Class ItemFactory
 */
class ItemFactory
{


    /**
     * @param string $type
     * @param string $name
     * @param int    $sell_in
     * @param int    $quality
     * @return UpdatableItemWrapper
     * @throws Exception
     */
    public static function create($type, $name, $sell_in, $quality)
    {
        $class = '\\GildedRose\\Items\\' . ucfirst($type) . 'Item';

        if (!class_exists($class)) {
            throw new Exception('Unsupported item type "' . $type . '".');
        }

        return new $class($name, $sell_in, $quality);
    }
}