<?php

namespace Fastre\CigogneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fastre\CigogneBundle\Entity\Item
 */
class Item
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var string $title
     */
    private $title;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var string $type
     */
    private $type;

    /**
     * @var integer $quantity
     */
    private $quantity;

    /**
     * @var array $furniture
     */
    private $furniture;

    /**
     * @var string $furnitureDetails
     */
    private $furnitureDetails;

    /**
     * @var string $furniturePlace
     */
    private $furniturePlace;

    /**
     * @var string $furnitureShop
     */
    private $furnitureShop;

    /**
     * @var integer $priority
     */
    private $priority;

    /**
     * @var \DateTime $creationDate
     */
    private $creationDate;

    /**
     * @var Fastre\CigogneBundle\Entity\Listing
     */
    private $listing;
    
    /**
     * @var array
     */
    private $good;
    
    
    const GOOD_SECOND_HAND = 'second';
    const GOOD_NEW = 'new';
    
    const FURNITURE_MONEY = 'money';
    const FURNITURE_NATURE = 'nature';
    
    const TYPE_GOOD = 'good';
    const TYPE_SERVICE = 'service';
    
    public function __construct()
    {
        $this->setCreationDate(new \DateTime());
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
     * Set title
     *
     * @param string $title
     * @return Item
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Item
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Item
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

    /**
     * Set furniture
     *
     * @param array $furniture
     * @return Item
     */
    public function setFurniture($furniture)
    {
        $this->furniture = $furniture;
    
        return $this;
    }

    /**
     * Get furniture
     *
     * @return array 
     */
    public function getFurniture()
    {
        return $this->furniture;
    }

    /**
     * Set furnitureDetails
     *
     * @param string $furnitureDetails
     * @return Item
     */
    public function setFurnitureDetails($furnitureDetails)
    {
        $this->furnitureDetails = $furnitureDetails;
    
        return $this;
    }

    /**
     * Get furnitureDetails
     *
     * @return string 
     */
    public function getFurnitureDetails()
    {
        return $this->furnitureDetails;
    }

    /**
     * Set furniturePlace
     *
     * @param string $furniturePlace
     * @return Item
     */
    public function setFurniturePlace($furniturePlace)
    {
        $this->furniturePlace = $furniturePlace;
    
        return $this;
    }

    /**
     * Get furniturePlace
     *
     * @return string 
     */
    public function getFurniturePlace()
    {
        return $this->furniturePlace;
    }

    /**
     * Set furnitureShop
     *
     * @param string $furnitureShop
     * @return Item
     */
    public function setFurnitureShop($furnitureShop)
    {
        $this->furnitureShop = $furnitureShop;
    
        return $this;
    }

    /**
     * Get furnitureShop
     *
     * @return string 
     */
    public function getFurnitureShop()
    {
        return $this->furnitureShop;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     * @return Item
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    
        return $this;
    }

    /**
     * Get priority
     *
     * @return integer 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Item
     */
    private function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    
        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }


    /**
     * Get listing
     *
     * @return Fastre\CigogneBundle\Entity\Listing 
     */
    public function getListing()
    {
        return $this->listing;
    }
    /**
     * @var float
     */
    private $price;


    /**
     * Set price
     *
     * @param float $price
     * @return Item
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set listing
     *
     * @param \Fastre\CigogneBundle\Entity\Listing $listing
     * @return Item
     */
    public function setListing(\Fastre\CigogneBundle\Entity\Listing $listing = null)
    {
        $this->listing = $listing;
    
        return $this;
    }



    /**
     * Set good
     *
     * @param array $good
     * @return Item
     */
    public function setGood($good)
    {
        $this->good = $good;
    
        return $this;
    }

    /**
     * Get good
     *
     * @return array 
     */
    public function getGood()
    {
        return $this->good;
    }
}