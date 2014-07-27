<?php

namespace Fastre\CigogneBundle\Entity;

use CL\PersonaUserBundle\Entity\PersonaUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * Fastre\CigogneBundle\Entity\User
 */
class User implements PersonaUserInterface, UserInterface
{
    
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string $email
     */
    private $email;
            
    /**
     *
     * @var string $label
     */
    private $label;

    /**
     * @var string $paymentBankAccountNumber
     */
    private $paymentBankAccountNumber;

    /**
     * @var boolean $paymentBankAccepted
     */
    private $paymentBankAccepted = true;

    
    private $lists;
    
    /**
     *
     * default role
     * 
     * @var string[]
     */
    private $roles = array('ROLE_USER');


    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getLabel()
    {
       return $this->label;
    }

    public function setLabel($label)
    {
       $this->label = $label;
    }

    /**
     * Set paymentBankAccountNumber
     *
     * @param string $paymentBankAccountNumber
     * @return User
     */
    public function setPaymentBankAccountNumber($paymentBankAccountNumber)
    {
        $this->paymentBankAccountNumber = $paymentBankAccountNumber;
    
        return $this;
    }

    /**
     * Get paymentBankAccountNumber
     *
     * @return string 
     */
    public function getPaymentBankAccountNumber()
    {
        return $this->paymentBankAccountNumber;
    }

    /**
     * Set paymentBankAccepted
     *
     * @param boolean $paymentBankAccepted
     * @return User
     */
    public function setPaymentBankAccepted($paymentBankAccepted)
    {
        $this->paymentBankAccepted = $paymentBankAccepted;
    
        return $this;
    }

    /**
     * Get paymentBankAccepted
     *
     * @return boolean 
     */
    public function getPaymentBankAccepted()
    {
        return $this->paymentBankAccepted;
    }

   /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

   public function eraseCredentials()
   {
      
   }

   public function getPassword()
   {
      return '';
   }

   /**
    * 
    * @return string[]
    */
   public function getRoles()
   {
      return $this->roles;
   }

   public function getSalt()
   {
      return '';
   }

   public function getUsername()
   {
      return $this->getEmail();
   }

   public function getPersonaId()
   {
      return $this->getEmail();
   }

}