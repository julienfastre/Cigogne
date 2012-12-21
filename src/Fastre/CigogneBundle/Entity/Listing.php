<?php

namespace Fastre\CigogneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fastre\CigogneBundle\Entity\Listing
 */
class Listing
{
    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var \DateTime $dateOfBirth
     */
    private $dateOfBirth;

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var \DateTime $creationDate
     */
    private $creationDate;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $codes;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $items;

    /**
     * @var Fastre\CigogneBundle\Entity\User
     */
    private $creator;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->codes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     * @return Listing
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    
        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime 
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Listing
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
     * Set description
     *
     * @param string $description
     * @return Listing
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
     * Set creationDate
     *
     * @param \DateTime $creationDate
     * @return Listing
     */
    public function setCreationDate($creationDate)
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
     * Add codes
     *
     * @param Fastre\CigogneBundle\Entity\Code $codes
     * @return Listing
     */
    public function addCode(\Fastre\CigogneBundle\Entity\Code $codes)
    {
        $this->codes[] = $codes;
    
        return $this;
    }

    /**
     * Remove codes
     *
     * @param Fastre\CigogneBundle\Entity\Code $codes
     */
    public function removeCode(\Fastre\CigogneBundle\Entity\Code $codes)
    {
        $this->codes->removeElement($codes);
    }

    /**
     * Get codes
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getCodes()
    {
        return $this->codes;
    }

    /**
     * Add items
     *
     * @param Fastre\CigogneBundle\Entity\Item $items
     * @return Listing
     */
    public function addItem(\Fastre\CigogneBundle\Entity\Item $items)
    {
        $this->items[] = $items;
    
        return $this;
    }

    /**
     * Remove items
     *
     * @param Fastre\CigogneBundle\Entity\Item $items
     */
    public function removeItem(\Fastre\CigogneBundle\Entity\Item $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set creator
     *
     * @param Fastre\CigogneBundle\Entity\User $creator
     * @return Listing
     */
    public function setCreator(\Fastre\CigogneBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;
    
        return $this;
    }

    /**
     * Get creator
     *
     * @return Fastre\CigogneBundle\Entity\User 
     */
    public function getCreator()
    {
        return $this->creator;
    }
}
