<?php namespace GildedRose;

/**
 * Class UpdatableItemWrapper
 */
class UpdatableItemWrapper
{


    /**
     * @var Item
     */
    protected $item;


    /**
     * @param Item $item
     */
    public function __construct(Item $item)
    {
        $this->item = $item;
    }


    /**
     *
     */
    public function update()
    {
        $this->updateSellIn();
        $this->updateQuality();
        $this->validateQuality();
    }


    /**
     *
     */
    public function updateSellIn()
    {
        $this->item->sell_in--;
    }


    /**
     *
     */
    public function updateQuality()
    {
        $this->item->quality--;

        if ($this->item->sell_in < 0) {
            $this->item->quality--;
        }
    }


    /**
     *
     */
    public function validateQuality()
    {
        if ($this->item->quality < 0) {
            $this->item->quality = 0;
        }

        if ($this->item->quality > 50) {
            $this->item->quality = 50;
        }
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->item;
    }
}