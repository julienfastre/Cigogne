<?php

namespace Fastre\CigogneBundle\Security\UserProvider;

use Doctrine\ORM\EntityManagerInterface;
use CL\PersonaUserBundle\Security\UserProvider\PersonaUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use CL\PersonaUserBundle\Security\Provider\PersonaIdNotExistingException;

/**
 * Provide user for authentication with persona
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class UserProvider implements PersonaUserProviderInterface
{

   private $em;

   public function __construct(EntityManagerInterface $em)
   {
      $this->em = $em;
   }

   public function loadUserByPersonaId($personaId)
   {
      $user = $this->em->getRepository('FastreCigogneBundle:User')
              ->findOneBy(array('email' => $personaId));

      if ($user === null) {
         throw new UsernameNotFoundException($personaId);
      }


      return $user;
   }

   public function loadUserByUsername($username)
   {
      $user = $this->em->getRepository('FastreCigogneBundle:User')
              ->findBy(array('email' => $username));

      if ($user === null) {
         throw new UsernameNotFoundException("The user with username "
         . $username . " is not found");
      }


      return $user;
   }

   public function refreshUser(\Symfony\Component\Security\Core\User\UserInterface $user)
   {
      if (!$this->supportsClass(get_class($user))) {
         throw new UnsupportedUserException('class ' . get_class($user) .
         " is not supported by " . get_class($this));
      }

      try {
         return $this->em->getRepository('FastreCigogneBundle:User')
                         ->find($user->getId());
      } catch (\Exception $e) {
         throw new \Exception("problem on refreshing user ", 0, $e);
      }
   }

   public function supportsClass($class)
   {
      return $class === 'Fastre\CigogneBundle\Entity\User';
   }

}
