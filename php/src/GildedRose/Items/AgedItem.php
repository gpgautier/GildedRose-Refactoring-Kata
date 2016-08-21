<?php namespace GildedRose\Items;

/**
 * Class AgedBrieItem
 */
class AgedItem extends GenericItem
{


    /**
     *
     */
    public function updateQuality()
    {
        $this->item->quality++;
    }
}