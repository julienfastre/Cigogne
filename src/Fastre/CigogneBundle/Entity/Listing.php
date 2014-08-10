<?php

namespace Fastre\CigogneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
     *
     * @var Photo 
     */
    private $photo;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->codes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
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
    
    private $invalidCodes = array();

    /**
     * Add code
     *
     * @param Fastre\CigogneBundle\Entity\Code $code
     * @return Listing
     */
    public function addCode(\Fastre\CigogneBundle\Entity\Code $code)
    {
       //we might not change the code from a listing to another !
       //prepare for validation later
       if ($code->getListing() !== NULL && $code->getListing() !== $this) {
          $invalidCodes[] = $code;
       } else {
          $code->setListing($this);
       }
        
        $this->codes[] = $code;
    
        return $this;
    }
    
    public function checkInvalidCodes(ExecutionContextInterface $context)
    {
       die(var_dump($this->invalidCodes));
       if (count($this->invalidCodes) > 0) {
          $wordsInError = implode(', ', $this->invalidCodes);
          $context->addViolationAt('code', 'cigogne.listing.form.invalid_code', $wordsInError);
       }
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
    
    public function setCodes(\Doctrine\Common\Collections\Collection $codes)
    {
       $this->codes = $codes;
    }

    /**
     * Add items
     *
     * @param Fastre\CigogneBundle\Entity\Item $items
     * @return Listing
     */
    public function addItem(\Fastre\CigogneBundle\Entity\Item $items)
    {
        $items->setListing($this);
        
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