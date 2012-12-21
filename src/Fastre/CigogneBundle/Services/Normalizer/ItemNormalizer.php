<?php

namespace Fastre\CigogneBundle\Services\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Fastre\CigogneBundle\Entity\Item;

/**
 * Normalize items
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class ItemNormalizer {
    
        /**
     * Normalizes an list into an array
     *
     * @param Fastre\CigogneBundle\Entity\Item $o object to normalize
     * @param string $format format the normalization result will be encoded as
     * @return array|scalar
     */
    public function normalize($o, $format = null) {
        
        return array(
            'title' => $o->getTitle(),
            'description' => $o->getDescription(),
            'type' => $o->getType(),
            'quantity' => $o->getQuantity(),
            'price' => $o->getPrice(),
            'furniture' => $o->getFurniture(),
            'furnitureDetails' => $o->getFurnitureDetails(),
            'priority' => $o->getPriority()
        );
            
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer
     *
     * @param mixed  $data   Data to normalize.
     * @param string $format The format being (de-)serialized from or into.
     * @return Boolean
     */
    public function supportsNormalization($data, $format = null) {
        if ($data instanceof Item)
            return true;
        else 
            return false;
    }
    
}

