<?php

namespace Fastre\CigogneBundle\Tests\Utility;

use Fastre\CigogneBundle\Entity\Item;
use Fastre\CigogneBundle\Entity\Gift\GiftService;

/**
 * 
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class ItemServiceRemainingTest extends \PHPUnit_Framework_TestCase
{
   public function testRemaining()
   {
      $item = new Item();
      $item->setQuantity(10)
              ->setFurniture(array(Item::FURNITURE_SERVICE));
      
      //first gift
      $firstGift = new GiftService();
      $firstGift->setQuantity(5)
              ->setItem($item);
      $firstGift->registerGiftOnItem();
      
      $this->assertEquals(5, $item->getRemainPossibleToGive(Item::FURNITURE_SERVICE));
      
      //second gift
      $secondGift = new GiftService();
      $secondGift->setQuantity(5)
              ->setItem($item);
      $secondGift->registerGiftOnItem();
      
      $this->assertEquals(0, $item->getRemainPossibleToGive(Item::FURNITURE_SERVICE));
      
   }
}
