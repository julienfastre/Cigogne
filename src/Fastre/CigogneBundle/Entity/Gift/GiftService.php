<?php

namespace Fastre\CigogneBundle\Entity\Gift;

use Fastre\CigogneBundle\Entity\Gift;

/**
 * Description of GiftService
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class GiftService extends Gift {

    /**
     * @var string
     */
    private $message = '';
    
    /**
     * @var integer
     */
    private $quantity = null;    


    /**
     * Set message
     *
     * @param string $message
     * @return GiftService
     */
    public function setMessage($message)
    {
        $this->message = $message;
        if ($this->message === null)
        {
            $this->message = '';
        }
    
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
     * Set quantity
     *
     * @param integer $quantity
     * @return GiftService
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    
    public function registerGiftOnItem()
    {
        $received = $this->getItem()->getReceived();
        $received += $this->getQuantity();
        $this->getItem()->setReceived($received);
    }
    
    public function registerRemoveOnItem()
    {
        $received = $this->getItem()->getReceived();
        $received -= $this->getQuantity();
        $this->getItem()->setReceived($received);
    }
}