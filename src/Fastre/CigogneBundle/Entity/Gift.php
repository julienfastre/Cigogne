<?php

namespace Fastre\CigogneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gift
 */
abstract class Gift
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \Fastre\CigogneBundle\Entity\Basket
     */
    private $basket;

    /**
     * @var \Fastre\CigogneBundle\Entity\Item
     */
    private $item;


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
     * Set basket
     *
     * @param \Fastre\CigogneBundle\Entity\Basket $basket
     * @return Gift
     */
    public function setBasket(\Fastre\CigogneBundle\Entity\Basket $basket = null)
    {
        $this->basket = $basket;
    
        return $this;
    }

    /**
     * Get basket
     *
     * @return \Fastre\CigogneBundle\Entity\Basket 
     */
    public function getBasket()
    {
        return $this->basket;
    }

    /**
     * Set item
     *
     * @param \Fastre\CigogneBundle\Entity\Item $item
     * @return Gift
     */
    public function setItem(\Fastre\CigogneBundle\Entity\Item $item = null)
    {
        $this->item = $item;
    
        return $this;
    }

    /**
     * Get item
     *
     * @return \Fastre\CigogneBundle\Entity\Item 
     */
    public function getItem()
    {
        return $this->item;
    }
}