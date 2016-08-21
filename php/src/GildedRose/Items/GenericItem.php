<?php namespace GildedRose\Items;

use GildedRose\Item;
use GildedRose\UpdatableItemWrapper;

/**
 * Class GenericItem
 */
class GenericItem extends UpdatableItemWrapper
{


    /**
     * @param string $name
     * @param int    $sell_in
     * @param int    $quality
     */
    public function __construct($name, $sell_in, $quality)
    {
        parent::__construct(new Item($name, $sell_in, $quality));
    }
}