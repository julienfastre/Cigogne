<?php

namespace Fastre\CigogneBundle\Tests\Utility;

use Fastre\CigogneBundle\Entity\Item;
use Fastre\CigogneBundle\Entity\Gift\GiftNature;

/**
 * 
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class ItemNatureRemainingTest extends \PHPUnit_Framework_TestCase
{
   public function testRemaining()
   {
      $item = new Item();
      $item->setQuantity(10)
              ->setFurniture(array(Item::FURNITURE_NATURE));
      
      //first gift
      $firstGift = new GiftNature();
      $firstGift->setQuantity(5)
              ->setItem($item);
      $firstGift->registerGiftOnItem();
      
      $this->assertEquals(5, $item->getRemainPossibleToGive(Item::FURNITURE_NATURE));
      
      //second gift
      $secondGift = new GiftNature();
      $secondGift->setQuantity(5)
              ->setItem($item);
      $secondGift->registerGiftOnItem();
      
      $this->assertEquals(0, $item->getRemainPossibleToGive(Item::FURNITURE_NATURE));
      
   }
}
