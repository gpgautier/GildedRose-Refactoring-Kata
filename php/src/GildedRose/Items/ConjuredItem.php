<?php namespace GildedRose\Items;

/**
 * Class ConjuredItem
 */
class ConjuredItem extends GenericItem
{


    /**
     *
     */
    public function updateQuality()
    {
        parent::updateQuality();

        $this->item->quality--;

        if ($this->item->sell_in < 0) {
            $this->item->quality--;
        }
    }
}