<?php

namespace Fastre\CigogneBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Doctrine\ORM\EntityManagerInterface;
use Fastre\CigogneBundle\Entity\Code;

/**
 * Transform a string into Code entity
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class TextToCodeTransformer implements DataTransformerInterface
{
   /**
    *
    * @var Doctrine\ORM\EntityManagerInterface
    */
   private $em;
   
   public function __construct(EntityManagerInterface $em)
   {
      $this->em = $em;
   }
   
   /**
    * transform a list of code into a string
    * 
    * @param \Fastre\CigogneBundle\Entity\Code[] $codes
    * @return string
    */
   public function transform($codes)
   {
      $text = '';
      
      foreach ($codes as $key => $code) {
         if ($text != '') {
            $text .= ', ';
         }
         $text .= $code->getWord();
      }
      
      return $text;
   }

   /**
    * transform a string into a list of code
    * 
    * @param string $value
    */
   public function reverseTransform($string)
   {
      $words = explode(',', $string, 100);
      $codes = new \Doctrine\Common\Collections\ArrayCollection();
      
      foreach ($words as $word) {
         $word = trim($word);
         
         $code = $this->em->getRepository('FastreCigogneBundle:Code')
                 ->findOneBy(array('word' => $word));
         
         if ($code === NULL) {
            $code = new Code($word);
         }
         
         $codes->add($code);
      }
      
      return $codes;
   }

}
