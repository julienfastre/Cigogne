<?php

namespace Fastre\CigogneBundle\Events;

use OpenCloud\OpenStack\Client;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Fastre\CigogneBundle\Entity\Photo;
use OpenCloud\OpenStack;

/**
 * 
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class PhotoLifecycle
{
   
   private $swiftEndPoint, $swiftUsername, $swiftPassword,
           $swiftRegio, $swiftContainer;
   
   public function __construct($swiftEndPoint, $swiftUsername,
           $swiftPassword, $regio, $container)
   {
      $this->swiftEndPoint = $swiftEndPoint;
      $this->swiftUsername = $swiftUsername;
      $this->swiftPassword = $swiftPassword;
      $this->swiftRegio = $regio;
      $this->swiftContainer = $container;
   }
   
   public function postPersist(LifecycleEventArgs $args)
   {
      $entity = $args->getEntity();
      
      if ($entity instanceof Photo) {
         $this->saveOnCloud($entity);
      }
   }
   
   public function postUpdate(LifecycleEventArgs $args)
   {
      $entity = $args->getEntity();
      
      if ($entity instanceof Photo) {
         $this->saveOnCloud($entity);
      }
   }
   
   /**
    * 
    * @return \OpenCloud\ObjectStore\Resource\Container;
    */
   private function getContainer()
   {
      $client = new OpenStack($this->swiftEndPoint, array(
          'username' => $this->swiftUsername,
          'password' => $this->swiftPassword,
          'tenantName' => '77315660'
      ));  
      $objectStoreService = $client->objectStoreService('swift', $this->swiftRegio);
      return $objectStoreService->getContainer($this->swiftContainer);
   }
   
   private function saveOnCloud(Photo $photo)
   {
      var_dump($photo->getPhoto());
      $data = fopen($photo->getPhoto()->getPathname(), 'r');
      $container = $this->getContainer();
      $container->uploadObject($photo->getFileName(), 
              $data);
      
   }
}
