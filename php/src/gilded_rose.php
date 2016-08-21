<?php

class GildedRose {

    private $items;

    function __construct($items) {
        $this->items = $items;
    }

    function update_quality() {
        foreach ($this->items as $item) {
            if ($item->name === 'Sulfuras, Hand of Ragnaros') {
                continue;
            }

            if ( !in_array($item->name, ['Aged Brie', 'Backstage passes to a TAFKAL80ETC concert']) ) {
                $item->quality--;

                if ( $item->sell_in < 1 ) {
                    $item->quality--;
                }
            } else {
                $item->quality++;
            }

            if ( $item->name === 'Conjured Mana Cake' ) {
                $item->quality--;

                if ( $item->sell_in < 1 ) {
                    $item->quality--;
                }
            }

            if ( $item->name === 'Backstage passes to a TAFKAL80ETC concert' ) {
                if ( $item->sell_in < 11 ) {
                    $item->quality++;
                }

                if ( $item->sell_in < 6 ) {
                    $item->quality++;
                }

                if ( $item->sell_in < 1 ) {
                    $item->quality = 0;
                }
            }

            if ( $item->quality < 0 ) {
                $item->quality = 0;
            }

            if ( $item->quality > 50 ) {
                $item->quality = 50;
            }

            $item->sell_in--;
        }
    }
}

class Item {

    public $name;
    public $sell_in;
    public $quality;

    function __construct($name, $sell_in, $quality) {
        $this->name = $name;
        $this->sell_in = $sell_in;
        $this->quality = $quality;
    }

    public function __toString() {
        return "{$this->name}, {$this->sell_in}, {$this->quality}";
    }

}

