<?php

namespace Fastre\CigogneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Basket
 */
class Basket
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $email = '';

    /**
     * @var string
     */
    private $message = '';

    /**
     * @var string
     */
    private $payment = '';

    /**
     * @var string
     */
    private $token = '';

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $elements;
    
    /**
     * @var \DateTime
     */
    private $lastUpdate;

    /**
     * @var boolean
     */
    private $closed = false;    

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->elements = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setLastUpdateNow();
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

    /**
     * Set name
     *
     * @param string $name
     * @return Basket
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Basket
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

    /**
     * Set message
     *
     * @param string $message
     * @return Basket
     */
    public function setMessage($message)
    {
        $this->message = $message;
    
        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set payment
     *
     * @param string $payment
     * @return Basket
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    
        return $this;
    }

    /**
     * Get payment
     *
     * @return string 
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Set token
     *
     * @param string $token
     * @return Basket
     */
    public function setToken($token)
    {
        $this->token = $token;
    
        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Add elements
     *
     * @param \Fastre\CigogneBundle\Entity\Gift $elements
     * @return Basket
     */
    public function addElement(\Fastre\CigogneBundle\Entity\Gift $element)
    {
        $this->elements[] = $element;
        $element->setBasket($this);
        $this->setLastUpdateNow();
        
        return $this;
    }

    /**
     * Remove elements
     *
     * @param \Fastre\CigogneBundle\Entity\Gift $elements
     */
    public function removeElement(\Fastre\CigogneBundle\Entity\Gift $elements)
    {
        $this->elements->removeElement($elements);
    }

    /**
     * Get elements
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
     * @return Basket
     */
    private function setLastUpdate(\DateTime $lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;
    
        return $this;
    }
    
    /**
     * 
     * @return \Fastre\CigogneBundle\Entity\Basket
     */
    public function setLastUpdateNow()
    {
        $date = new \DateTime('now');
        $this->setLastUpdate($date);
        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return \DateTime 
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Set closed
     *
     * @param boolean $closed
     * @return Basket
     */
    public function setClosed($closed)
    {
        $this->closed = $closed;
    
        return $this;
    }

    /**
     * Get closed
     *
     * @return boolean 
     */
    public function getClosed()
    {
        return $this->closed;
    }
}