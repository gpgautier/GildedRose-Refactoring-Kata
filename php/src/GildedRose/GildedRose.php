<?php namespace GildedRose;

/**
 * Class GildedRose
 */
class GildedRose
{


    /**
     * @var UpdatableItemWrapper[]
     */
    protected $items;


    /**
     * @param UpdatableItemWrapper[] $items
     */
    function __construct(array $items)
    {
        $this->items = $items;
    }


    /**
     *
     */
    function update_quality()
    {
        /** @var UpdatableItemWrapper $item */
        foreach ($this->items as $item) {
            $item->update();
        }
    }
}