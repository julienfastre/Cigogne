<?php

namespace Fastre\CigogneBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

/**
 * 
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class ListingRepository extends EntityRepository
{
   /**
    * 
    * @param string $code
    * @throws \Doctrine\ORM\NonUniqueResultException if multiple lists are associated with one code
    */
   public function getListingByCode($code = NULL)
   {
      if ($code === NULL) {
         return NULL;
      }
      $sanitizedCode = self::sanitizeCode($code);
      $q = $this->getEntityManager()
              ->createQuery('SELECT l from FastreCigogneBundle:Listing l '
                      . 'JOIN l.codes c '
                      . 'WHERE c.word like :word');
      $q->setParameter('word', $sanitizedCode);
      
      try {
         return $q->getSingleResult();
      } catch (\Doctrine\ORM\NonUniqueResultException $ex) {
         throw $ex;
      } catch (\Doctrine\ORM\NoResultException $ex) {
         return NULL;
      }
   }
   
   public static function sanitizeCode($string) 
   {
      $trimmedCode = trim($string);
      $lowerCode = strtolower($trimmedCode);
      //remove special characters
      if (strpos($lowerCode = htmlentities($lowerCode, ENT_QUOTES, 'UTF-8'), '&') !== false) {
          $cleanCode = html_entity_decode(
                  preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|tilde|uml);~i', '$1', $lowerCode), 
                  ENT_QUOTES, 
                  'UTF-8'
                  );
      } else {
         $cleanCode = $lowerCode;
      }
      
      return $cleanCode;
   }
}
