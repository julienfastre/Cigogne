<?php

namespace Fastre\CigogneBundle\Services\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Fastre\CigogneBundle\Entity\Gift;
use Fastre\CigogneBundle\Entity\Gift\GiftMoney;
use Fastre\CigogneBundle\Entity\Gift\GiftNature;
use Fastre\CigogneBundle\Entity\Gift\GiftService;

/**
 * Description of GiftNormalizer
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class GiftNormalizer implements NormalizerInterface {
    
    const ID = 'id';
    const TITLE = 'title';
    const AMOUNT = 'amount';
    const UUID = 'uuid';
    const MESSAGE = 'message';
    const QUANTITY = 'quantity';
    const TYPE = 'type';
    const ITEM_ID = 'itemId';
    
    
    /**
     * @param \Fastre\CigogneBundle\Entity\Gift $object
     * @param string $format 
     * @param array $context 
     */
    public function normalize($object, $format = null, array $context = array()) {
        
        $a = array();
        $a[self::ID] = $object->getId();
        $a[self::TITLE] = $object->getItem()->getTitle();
        $a[self::UUID] = $this->gen_uuid();
        $a[self::ITEM_ID] = $object->getItem()->getId();
        
        if ($object instanceof GiftMoney) {
            
            $a[self::AMOUNT] = $object->getAmount();
            $a[self::TYPE] = 'money';
            
        } elseif ($object instanceof GiftNature) {
            
            $a[self::MESSAGE] = $object->getMessage();
            $a[self::QUANTITY] = $object->getQuantity();
            $a[self::TYPE] = 'nature';
            
        } elseif ($object instanceof GiftService) {
            
            $a[self::MESSAGE] = $object->getMessage();
            $a[self::QUANTITY] = $object->getQuantity();
            $a[self::TYPE] = 'service';
            
        }
        
        return $a;
        
    }
    
    /**
     * 
     * @param \Fastre\CigogneBundle\Entity\Gift $data
     * @param type $format
     * @return boolean
     */
    public function supportsNormalization($data, $format = null) {
        return ($data instanceof Gift);      
    }    
    
    
    private function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

        // 16 bits for "time_mid"
        mt_rand( 0, 0xffff ),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand( 0, 0x0fff ) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand( 0, 0x3fff ) | 0x8000,

        // 48 bits for "node"
        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
    );
}
}

