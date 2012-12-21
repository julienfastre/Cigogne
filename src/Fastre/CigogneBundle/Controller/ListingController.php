<?php

namespace Fastre\CigogneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of ListingController
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class ListingController extends Controller {
    
    public function getListingAction($_format, $id)
    {
        $em = $this->getDoctrine()->getEntityManager();
        
        $list = $em->getRepository('FastreCigogneBundle:Listing')->find($id);
        
        if ($list === null)
        {
            throw $this->createNotFoundException('no list with this id');
        }
        
        if ($_format === 'json')
        {
            $serializer = $this->get('cigogne.normalizer.serializer');
            $string = $serializer->serialize($list, 'json');
            return new Response($string);
        }
    }
    
    
}

