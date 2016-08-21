<?php namespace GildedRose\Items;

/**
 * Class BackstageItem
 */
class BackstageItem extends AgedItem
{


    /**
     *
     */
    public function updateQuality()
    {
        if ($this->item->sell_in < 0) {
            $this->item->quality = 0;
        } else {
            parent::updateQuality();

            if ($this->item->sell_in < 11) {
                $this->item->quality++;
            }
            if ($this->item->sell_in < 6) {
                $this->item->quality++;
            }
        }
    }
}