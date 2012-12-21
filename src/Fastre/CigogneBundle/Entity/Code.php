<?php

namespace Fastre\CigogneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    private $list;


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
        $this->word = $word;
    
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
     * @param Fastre\CigogneBundle\Entity\Listing $list
     * @return Code
     */
    public function setList(\Fastre\CigogneBundle\Entity\Listing $list = null)
    {
        $this->list = $list;
    
        return $this;
    }

    /**
     * Get list
     *
     * @return Fastre\CigogneBundle\Entity\Listing 
     */
    public function getList()
    {
        return $this->list;
    }
}