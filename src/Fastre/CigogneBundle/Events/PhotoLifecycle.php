<?php

namespace Fastre\CigogneBundle\Events;

use OpenCloud\OpenStack\Client;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Fastre\CigogneBundle\Entity\Photo;
use OpenCloud\OpenStack;
use \SplFileObject;

/**
 * 
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class PhotoLifecycle
{
   
   private $swiftEndPoint, $swiftUsername, $swiftPassword,
           $swiftRegio, $swiftContainer, $swiftTenant;
   private $cachedir;
   
   const MAX_SIZE = 700;
   
   public function __construct($swiftEndPoint, $swiftUsername,
           $swiftPassword, $regio, $container, $tenant, $cachedir)
   {
      $this->swiftEndPoint = $swiftEndPoint;
      $this->swiftUsername = $swiftUsername;
      $this->swiftPassword = $swiftPassword;
      $this->swiftRegio = $regio;
      $this->swiftContainer = $container;
      $this->swiftTenant = $tenant;
      $this->cachedir = $cachedir;
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
          'tenantName' => $this->swiftTenant
      ));  
      $objectStoreService = $client->objectStoreService('swift', $this->swiftRegio);
      return $objectStoreService->getContainer($this->swiftContainer);
   }
   
   private function saveOnCloud(Photo $photo)
   {
      var_dump($photo->getPhoto());
      
      $image = $this->resizePhoto($photo->getPhoto());
      
      $tempfile = $this->cachedir.'/'.$photo->getFileName();
      

      switch($photo->getType())
      {
         case 'jpeg':
         case 'jpg':
            $res = imagejpeg($image, $tempfile);
            break;
         case 'png':
            $res = imagepng($image, $tempfile);
            break;
         default:
            throw new \Exception("type ".$photo->getType()." may not be stored temporarily on disk");
      }
      
      if (FALSE === $res){
         throw new \Exception("image could not be stored temporarily"
                 . " on disk");
      }
 
      
      
      $data = fopen($tempfile, 'r');
      $container = $this->getContainer();
      $container->uploadObject($photo->getFileName(), 
            $data);
      
      //fclose($data); this line is not necessary: closed by uploadObject function
      
      $res = unlink($tempfile);
      
      if ($res === FALSE) {
         throw new \Exception("image was uploaded but could not be delete from cachedir");
      }
   }
   
   private function resizePhoto(\Symfony\Component\HttpFoundation\File\UploadedFile $photo)
   {
      $type = strtolower($photo->guessExtension());
      list($width, $height) = getimagesize($photo->getPathname());
      $orientation = ($width > $height) ? 'landscape' : 'portrait';
      $image = $this->createimage($type, $photo->getPathname());
      
      switch ($orientation) {
         case 'landscape':
            if ($width < self::MAX_SIZE) {
               return $image;
            }
            $new_width = self::MAX_SIZE;
            $new_height = $height * ( $new_width / $width);
            break;
         case 'portrait':
            if ($height < self::MAX_SIZE) {
               return $image;
            }
            $new_height = self::MAX_SIZE;
            $new_width = $width * ($new_height / $height);
      }
      
      
      
      $resized_image = \imagecreatetruecolor($new_width, $new_height);
      
      \imagecopyresampled($resized_image, $image, 0, 0, 0, 0, 
              $new_width, $new_height, $width, $height);
      
      return $resized_image;
   }
   
   private function createimage($type, $filename)
   {
      switch ($type) {
         case 'jpeg':
         case 'jpg':
            return imagecreatefromjpeg($filename);
         case 'png': 
            return imagecreatefrompng($filename);
         default:
            throw new \Exception("image from type $type may not be created");
      }
   }
}
