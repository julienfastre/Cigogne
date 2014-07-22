<?php

namespace Fastre\CigogneBundle\Entity\Gift;

use Fastre\CigogneBundle\Entity\Gift;
use Fastre\CigogneBundle\Entity\Item;

/**
 * Description of GiftNature
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class GiftNature extends Gift {
    
    /**
     * @var string
     */
    private $message = '';
    
    /**
     * @var integer
     */
    private $quantity = 1;


    /**
     * Set message
     *
     * @param string $message
     * @return GiftNature
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
     * @return GiftNature
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
       if (!in_array(Item::FURNITURE_NATURE, $this->getItem()->getFurniture())) {
          throw new \Exception('nature not possible with this item');
       }
       
       if ($this->getPrice() === 0) { $price = 1; } else { $price = $this->getPrice();}
       
       $received = $this->getItem()->getReceived();
        $received += $this->getQuantity() * $price ;
        $this->getItem()->setReceived($received);
    }
    
    /**
     * 
     * @throws \Exception not implemented
     */
    public function registerRemoveOnItem()
    {
        throw \Exception('not implemented');
    }
}