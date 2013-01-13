<?php

namespace Fastre\CigogneBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Fastre\CigogneBundle\Entity\Item;

/**
 * Transform items into number; the number is the id of the item
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class ItemToNumberTransformer implements DataTransformerInterface {
    
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
     * transforms a string (id of the item) into an item
     * 
     * @param string $id
     * @return \Fastre\CigogneBundle\Entity\Item|null
     * @throws Symfony\Component\Form\Exception\TransformationFailedException if item is not found
     */
    public function reverseTransform($id) {
        if (!$id)
            return null;
        
        $item = $this->om->getRepository('FastreCigogneBundle:Item')
                ->find($id);
        
        if (null === $item) {
            throw new TransformationFailedException("An item with id $id does not exist");
        }
        
        return $item;
    }
    
    /**
     * transform an item into a number
     * @param \Fastre\CigogneBundle\Entity\Item $item
     * @return integer
     */
    public function transform($item) {
        if (null === $item) {
            return 0;
        }
        
        return $item->getId();
    }
}

