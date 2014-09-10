<?php

namespace Fastre\CigogneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Fastre\CigogneBundle\EntityRepository\ListingRepository;

/**
 * Fastre\CigogneBundle\Entity\Code
 */
class Code
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $word
     */
    private $word;

    /**
     * @var Fastre\CigogneBundle\Entity\List
     */
    private $listing;
    
    public function __construct($word) {
        $this->word = $word;
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
     * Set word
     *
     * @param string $word
     * @return Code
     */
    public function setWord($word)
    {
        $this->word = ListingRepository::sanitizeCode($word);
    
        return $this;
    }

    /**
     * Get word
     *
     * @return string 
     */
    public function getWord()
    {
        return $this->word;
    }


    /**
     * Set list
     *
     * @param Fastre\CigogneBundle\Entity\Listing $listing
     * @return Code
     */
    public function setListing(\Fastre\CigogneBundle\Entity\Listing $listing = null)
    {
        $this->listing = $listing;
    
        return $this;
    }

    /**
     * Get list
     *
     * @return Fastre\CigogneBundle\Entity\Listing 
     */
    public function getListing()
    {
        return $this->listing;
    }
    
    public function __toString()
    {
       return $this->getWord();
    }
}