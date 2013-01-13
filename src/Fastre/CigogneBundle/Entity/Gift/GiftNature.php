<?php

namespace Fastre\CigogneBundle\Entity\Gift;

use Fastre\CigogneBundle\Entity\Gift;

/**
 * Description of GiftNature
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class GiftNature extends Gift {
    
    /**
     * @var string
     */
    private $message;


    /**
     * Set message
     *
     * @param string $message
     * @return GiftNature
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

}