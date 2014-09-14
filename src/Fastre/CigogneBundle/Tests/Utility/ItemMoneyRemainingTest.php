<?php

namespace Fastre\CigogneBundle\Tests\Utility;

use Fastre\CigogneBundle\Entity\Item;
use Fastre\CigogneBundle\Entity\Gift\GiftMoney;

/**
 * 
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class ItemMoneyRemainingTest extends \PHPUnit_Framework_TestCase
{
   public function testRemaining()
   {
      $item = new Item();
      $item->setQuantity(1)
              ->setPrice(10);
      
      //first gift
      $firstGift = new GiftMoney();
      $firstGift->setAmount(5)
              ->setItem($item);
      $firstGift->registerGiftOnItem();
      
      $this->assertEquals(5, $item->getRemainPossibleToGive(Item::FURNITURE_MONEY));
      
      //second gift
      $secondGift = new GiftMoney();
      $secondGift
              ->setAmount(5)
              ->setItem($item);
      $secondGift->registerGiftOnItem();
      
      $this->assertEquals(0, $item->getRemainPossibleToGive(Item::FURNITURE_MONEY));
   }
   
   public function testRemainingMultipleQuantity()
   {
      $item = new Item();
      $item->setQuantity(2)
              ->setPrice(10);
      
      //first Gift
      $firstGift = new GiftMoney();
      $firstGift->setAmount(5)
              ->setItem($item);
      $firstGift->registerGiftOnItem();
      
      $this->assertEquals(15, $item->getRemainPossibleToGive(Item::FURNITURE_MONEY));
      
      //second gift
      $secondGift = new GiftMoney();
      $secondGift->setAmount(10)
              ->setItem($item);
      $secondGift->registerGiftOnItem();
      
      $this->assertEquals(5, $item->getRemainPossibleToGive(Item::FURNITURE_MONEY));
   }
}
