<?php

namespace Fastre\CigogneBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Fastre\CigogneBundle\Entity\Basket;

/**
 * Transform items into number; the number is the id of the item
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class BasketToNumberTransformer implements DataTransformerInterface {
    
    /**
     *
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $om;
    
    /**
     * 
     * @param \Doctrine\Common\Persistence\ObjectManager $om
     */
    public function __construct(ObjectManager $om) {
        $this->om = $om;
    }
    
    /**
     * transforms a string (id of the item) into a basket
     * 
     * @param string $id
     * @return \Fastre\CigogneBundle\Entity\Basket|null
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException if item is not found
     */
    public function reverseTransform($id) {
        if (!$id)
            return null;
        
        $basket = $this->om->getRepository('FastreCigogneBundle:Basket')
                ->find($id);
        
        if (null === $basket) {
            throw new TransformationFailedException("An item with id $id does not exist");
        }
        
        return $basket;
    }
    
    /**
     * transform an item into a number
     * @param \Fastre\CigogneBundle\Entity\Basket $basket
     * @return integer
     */
    public function transform($basket) {
        if (null === $basket) {
            return 0;
        }
        
        return $basket->getId();
    }
}

