<?php

namespace Fastre\CigogneBundle\Services\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Fastre\CigogneBundle\Entity\User;

/**
 * Normalize Users Entity
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class UserNormalizer implements NormalizerInterface {
    
    /**
     * 
     * @param Fastre\CigogneBundle\Entity\User $object
     * @param string $format
     */
    public function normalize($object, $format = null)
    {
        return array(
            'username' => $object->getUsername()
        );
    }
    
    public function supportsNormalization($data, $format = null)
    {
        if ($data instanceof User)
            return true;
        else
            return false;
    }
    
}

