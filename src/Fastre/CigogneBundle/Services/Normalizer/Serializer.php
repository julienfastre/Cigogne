<?php

namespace Fastre\CigogneBundle\Services\Normalizer;

use Symfony\Component\Serializer\Serializer as BaseSerializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

/**
 * Description of Serializer
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class Serializer extends BaseSerializer {
    
    public function __construct($normalizers) {
        parent::__construct($normalizers, array('json' => new JsonEncoder()));
    }
    
}

