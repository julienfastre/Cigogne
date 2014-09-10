<?php

namespace Fastre\CigogneBundle\Tests\Repository\ListingRepository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Fastre\CigogneBundle\EntityRepository\ListingRepository;

/**
 * 
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class ListingRepositoryTest extends WebTestCase
{
   
   
   
   public function testSanitizeCode()
   {
      $this->assertEquals('adele', ListingRepository::sanitizeCode('adèle'));
      $this->assertEquals('adele', ListingRepository::sanitizeCode('Adele'));
   }
}
