<?php

namespace Fastre\CigogneBundle\Entity;

use Symfony\Component\Validator\Context\ExecutionContextInterface;

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
     * @var float
     */
    private $price = 0;

    /**
     * @var array $furniture
     */
    private $furniture;

    /**
     * @var integer $priority
     */
    private $priority = 1;

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
    
    /**
     * @var string
     */
    private $furnitureDetails = '';
    
    /**
     * @var float
     */
    private $received = 0;
    
    /**
     * @var \Fastre\CigogneBundle\Entity\Photo
     */
    private $photo;
    
    
    const GOOD_SECOND_HAND = 'second';
    const GOOD_NEW = 'new';
    
    const FURNITURE_MONEY = 'money';
    const FURNITURE_NATURE = 'nature';
    const FURNITURE_SERVICE = 'service';
    
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

    /**
     * Set received
     *
     * @param float $received
     * @return Item
     */
    public function setReceived($received)
    {
        $this->received = $received;
    
        return $this;
    }

    /**
     * Get received
     *
     * @return float 
     */
    public function getReceived()
    {
        return $this->received;
    }
    
    public function getRemainPossibleToGive($furniture)
    {
       switch ($furniture) {
          case self::FURNITURE_MONEY : 
             return $this->getPrice() - $this->getReceived();
          case self::FURNITURE_NATURE : 
             if ($this->getPrice() === 0) { $price = 1; } else { $price = $this->getPrice();}
             return ceil(($price * $this->getQuantity() - $this->getReceived()) / $price);
          case self::FURNITURE_SERVICE :
             return $this->getQuantity() - $this->getReceived();
       }
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
     * check the consistency of the item
     * Used for validation
     */
    public function isConsistent(ExecutionContextInterface $context) {
      switch ($this->getType())
      {
         case self::TYPE_GOOD :
            //don't ask to give the good as a service
            if (in_array(self::FURNITURE_SERVICE, $this->getFurniture())){
               $context->buildViolation('cigogne.item.form.a_good_may_not_be_given_as_a_service')
                      ->atPath('furniture')
                      ->addViolation();
            }
            //give the price if you ask for money
            if ($this->getPrice() == 0 
                    && in_array(self::FURNITURE_MONEY, $this->getFurniture())){
               $context->buildViolation('cigogne.item.form.give_a_price')
                       ->atPath('price')
                       ->addViolation();
            }
            //fill at least one of 'good' possibility ('new' or 'second hand')
            if (count($this->getGood()) === 0){
               $context->buildViolation('cigogne.item.form.required_new_or_second_hand')
                       ->atPath('good')
                       ->addViolation();
            }
            break;
        case self::TYPE_SERVICE:
           //a service may not be 'new' or 'second hand'
           if (in_array(self::GOOD_NEW, $this->getGood()) 
                   OR in_array(self::GOOD_SECOND_HAND, $this->getGood())) {
              $context->buildViolation('cigogne.item.form.a_service_may_not_be_new_nor_second_hand')
                      ->atPath('good')
                      ->addViolation();
           }
           //a service may not be given as moyen
           if (in_array(self::FURNITURE_MONEY, $this->getFurniture())){
              $context->buildViolation('cigogne.item.form.a_service_may_not_be_paid')
                      ->atPath('furniture')
                      ->addViolation();
           }
           //a service may not be given in nature
           if (in_array(self::FURNITURE_NATURE, $this->getFurniture())) {
              $context->buildViolation('cigogne.item.form.a_service_may_not_be_nature')
                      ->atPath('furniture')
                      ->addViolation();
           }
           //furniture service must be checked
           if (!in_array(self::FURNITURE_SERVICE, $this->getFurniture())){
              $context->buildViolation('cigogne.item.form.service_must_be_checked')
                      ->atPath('furniture')
                      ->addViolation();
           }
           break;

      } 
    }



    /**
     * Set photo
     *
     * @param \Fastre\CigogneBundle\Entity\Photo $photo
     * @return Item
     */
    public function setPhoto(\Fastre\CigogneBundle\Entity\Photo $photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return \Fastre\CigogneBundle\Entity\Photo 
     */
    public function getPhoto()
    {
        return $this->photo;
    }
}
