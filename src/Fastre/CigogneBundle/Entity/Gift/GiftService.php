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
    private $message;


    /**
     * Set message
     *
     * @param string $message
     * @return GiftService
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