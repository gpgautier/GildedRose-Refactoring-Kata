<?php namespace GildedRose;

/**
 * Class Item
 */
class Item
{


    /**
     * @var string
     */
    public $name;


    /**
     * @var int
     */
    public $sell_in;


    /**
     * @var int
     */
    public $quality;


    /**
     * @param string $name
     * @param int    $sell_in
     * @param int    $quality
     */
    function __construct($name, $sell_in, $quality)
    {
        $this->name    = $name;
        $this->sell_in = $sell_in;
        $this->quality = $quality;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->name}, {$this->sell_in}, {$this->quality}";
    }

}