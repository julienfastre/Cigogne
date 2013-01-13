<?php

namespace Fastre\CigogneBundle\Entity\Gift;

use Fastre\CigogneBundle\Entity\Gift;

/**
 * Description of GiftMoney
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class GiftMoney extends Gift {

    /**
     * @var float
     */
    private $amount;


    /**
     * Set amount
     *
     * @param float $amount
     * @return GiftMoney
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    
        return $this;
    }

    /**
     * Get amount
     *
     * @return float 
     */
    public function getAmount()
    {
        return $this->amount;
    }

}