<?php

namespace Fastre\CigogneBundle\Services\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Fastre\CigogneBundle\Entity\Listing;
use Fastre\CigogneBundle\Services\Normalizer\ItemNormalizer;

/**
 * Description of ListNormalizer
 *
 * @author Julien Fastré <julien arobase fastre point info>
 * @deprecated
 */
class ListingNormalizer implements NormalizerInterface {
    
    private $itemNormalizer;
    
    public function __construct(ItemNormalizer $itemNormalizer) {
        $this->itemNormalizer = $itemNormalizer;
    }
    
    /**
     * Normalizes an list into an array
     *
     * @param Fastre\CigogneBundle\Entity\Listing $object object to normalize
     * @param string $format format the normalization result will be encoded as
     * @return array|scalar
     */
    public function normalize($object, $format = null, array $context = array()) {
        $a = array(
            'dateOfBirth' => null,
            'name' => $object->getName(),
            'description' => $object->getDescription(),
            'creator' => $object->getCreator()->getUsername(),
            'items' => array()
        );
        
        if ($object->getDateOfBirth() !== null)
        {
            $a['dateOfBirth'] = $object->getDateOfBirth()->format('U');
        }
        
        foreach ($object->getItems() as $item) {
            $a['items'][] = $this->itemNormalizer->normalize($item, $format);
        }
        
        return $a;
            
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer
     *
     * @param mixed  $data   Data to normalize.
     * @param string $format The format being (de-)serialized from or into.
     * @return Boolean
     */
    public function supportsNormalization($data, $format = null) {
        if ($data instanceof Listing)
            return true;
        else 
            return false;
    }
    
}

