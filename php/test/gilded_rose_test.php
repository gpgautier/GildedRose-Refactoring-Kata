<?php

use GildedRose\GildedRose;
use GildedRose\Item;
use GildedRose\ItemFactory;

require_once __DIR__ . '/../vendor/autoload.php';

class GildedRoseTest extends PHPUnit_Framework_TestCase
{


    function testItemMustBeConstructedWithNameSellInAndQuality()
    {
        $reflection  = new ReflectionClass(Item::class);
        $constructor = $reflection->getConstructor();
        $parameters  = $constructor->getParameters();

        $this->assertEquals('name', $parameters[0]->getName());
        $this->assertEquals('sell_in', $parameters[1]->getName());
        $this->assertEquals('quality', $parameters[2]->getName());
    }


    function testItemsHasAttributesNameSellInAndQuality()
    {
        $item = new Item('Foo', 1, 2);

        $this->assertObjectHasAttribute('name', $item);
        $this->assertObjectHasAttribute('sell_in', $item);
        $this->assertObjectHasAttribute('quality', $item);
    }


    function testItemsHasToStringFunction()
    {
        $item = new Item('Foo', 1, 2);

        $this->assertEquals('Foo, 1, 2', (string)$item);
    }


    function testFactoryThrowsExceptionOnUnknownItemType() {
        try {
            ItemFactory::create('foo', 'Bar', 1, 1);
        } catch ( Exception $e ) {
            $this->assertTrue(true);
            return;
        }

        $this->assertTrue(false);
    }


    function testEveryDaySellInAndQualityIsLowered()
    {
        $items = [ItemFactory::create('generic', 'Foo', 1, 2)];
        $rose  = new GildedRose($items);

        $rose->update_quality();

        $this->assertEquals('Foo, 0, 1', (string)$items[0]);
    }


    function testOnceTheSellByDateHasPassedQualityDegradesTwiceAsFast()
    {
        $items = [ItemFactory::create('generic', 'Foo', 0, 2)];
        $rose  = new GildedRose($items);

        $rose->update_quality();

        $this->assertEquals('Foo, -1, 0', (string)$items[0]);
    }


    function testQualityIsNeverNegative()
    {
        $items = [ItemFactory::create('generic', 'Foo', 1, 0)];
        $rose  = new GildedRose($items);

        $rose->update_quality();

        $this->assertEquals('Foo, 0, 0', (string)$items[0]);
    }


    function testQualityIsNeverHigherThenFifty()
    {
        $items = [ItemFactory::create('aged', 'Aged Brie', 1, 50)];
        $rose  = new GildedRose($items);

        $rose->update_quality();

        $this->assertEquals('Aged Brie, 0, 50', (string)$items[0]);
    }


    function testAgedBrieIncreasesInQualityTheOlderItGets()
    {
        $items = [ItemFactory::create('aged', 'Aged Brie', 1, 1)];
        $rose  = new GildedRose($items);

        $rose->update_quality();

        $this->assertEquals('Aged Brie, 0, 2', (string)$items[0]);

        $rose->update_quality();

        $this->assertEquals('Aged Brie, -1, 3', (string)$items[0]);
    }


    function testSulfurasNeverHasToBeSoldOrDecreaseInQuality()
    {
        $items = [
            ItemFactory::create('legendary', 'Sulfuras, Hand of Ragnaros', 1,
                80)
        ];
        $rose  = new GildedRose($items);

        $rose->update_quality();

        $this->assertEquals('Sulfuras, Hand of Ragnaros, 1, 80',
            (string)$items[0]);
    }


    function testBackstagePassesIncreaseInQuality()
    {
        $items = [
            ItemFactory::create('backstage',
                'Backstage passes to a TAFKAL80ETC concert', 20, 0)
        ];
        $rose  = new GildedRose($items);

        $rose->update_quality();

        $this->assertEquals('Backstage passes to a TAFKAL80ETC concert, 19, 1',
            (string)$items[0]);
    }


    function testBackstagePassesIncreaseInQualityByTwoWithTenDaysOrLess()
    {
        $items = [
            ItemFactory::create('backstage',
                'Backstage passes to a TAFKAL80ETC concert', 10, 0)
        ];
        $rose  = new GildedRose($items);

        $rose->update_quality();

        $this->assertEquals('Backstage passes to a TAFKAL80ETC concert, 9, 2',
            (string)$items[0]);
    }


    function testBackstagePassesIncreaseInQualityByThreeWithFiveDaysOrLess()
    {
        $items = [
            ItemFactory::create('backstage',
                'Backstage passes to a TAFKAL80ETC concert', 5, 0)
        ];
        $rose  = new GildedRose($items);

        $rose->update_quality();

        $this->assertEquals('Backstage passes to a TAFKAL80ETC concert, 4, 3',
            (string)$items[0]);
    }


    function testBackstagePassesQualityToZeroWhenAfterSellDate()
    {
        $items = [
            ItemFactory::create('backstage',
                'Backstage passes to a TAFKAL80ETC concert', 0, 10)
        ];
        $rose  = new GildedRose($items);

        $rose->update_quality();

        $this->assertEquals('Backstage passes to a TAFKAL80ETC concert, -1, 0',
            (string)$items[0]);
    }


    function testConjuredItemsDegradeTwiceAsFast()
    {
        $items = [ItemFactory::create('conjured', 'Conjured Mana Cake', 1, 10)];
        $rose  = new GildedRose($items);

        $rose->update_quality();

        $this->assertEquals('Conjured Mana Cake, 0, 8',
            (string)$items[0]);

        $rose->update_quality();

        $this->assertEquals('Conjured Mana Cake, -1, 4',
            (string)$items[0]);
    }


    function testTextTestFixturePasses()
    {
        $items = [
            ItemFactory::create('generic', '+5 Dexterity Vest', 10, 20),
            ItemFactory::create('aged', 'Aged Brie', 2, 0),
            ItemFactory::create('generic', 'Elixir of the Mongoose', 5, 7),
            ItemFactory::create('legendary', 'Sulfuras, Hand of Ragnaros', 0,
                80),
            ItemFactory::create('legendary', 'Sulfuras, Hand of Ragnaros', -1,
                80),
            ItemFactory::create('backstage',
                'Backstage passes to a TAFKAL80ETC concert', 15, 20),
            ItemFactory::create('backstage',
                'Backstage passes to a TAFKAL80ETC concert', 10, 49),
            ItemFactory::create('backstage',
                'Backstage passes to a TAFKAL80ETC concert', 5, 49),
            ItemFactory::create('backstage',
                'Backstage passes to a TAFKAL80ETC concert', 0, 50),
            ItemFactory::create('conjured', 'Conjured Mana Cake', 3, 6),
            ItemFactory::create('conjured', 'Conjured Mana Cake', 0, 8)
        ];

        $rose = new GildedRose($items);

        $rose->update_quality();

        $this->assertEquals('+5 Dexterity Vest, 9, 19', (string)$items[0]);
        $this->assertEquals('Aged Brie, 1, 1', (string)$items[1]);
        $this->assertEquals('Elixir of the Mongoose, 4, 6', (string)$items[2]);
        $this->assertEquals('Sulfuras, Hand of Ragnaros, 0, 80',
            (string)$items[3]);
        $this->assertEquals('Sulfuras, Hand of Ragnaros, -1, 80',
            (string)$items[4]);
        $this->assertEquals('Backstage passes to a TAFKAL80ETC concert, 14, 21',
            (string)$items[5]);
        $this->assertEquals('Backstage passes to a TAFKAL80ETC concert, 9, 50',
            (string)$items[6]);
        $this->assertEquals('Backstage passes to a TAFKAL80ETC concert, 4, 50',
            (string)$items[7]);
        $this->assertEquals('Backstage passes to a TAFKAL80ETC concert, -1, 0',
            (string)$items[8]);
        $this->assertEquals('Conjured Mana Cake, 2, 4', (string)$items[9]);
        $this->assertEquals('Conjured Mana Cake, -1, 4', (string)$items[10]);
    }
}
