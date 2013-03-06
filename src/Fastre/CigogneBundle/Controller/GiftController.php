<?php

namespace Fastre\CigogneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Fastre\CigogneBundle\Entity\Gift\GiftMoney;
use Fastre\CigogneBundle\Form\Gift\GiftMoneyType;

/**
 * 
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class GiftController extends Controller {
    
    public function moneyAddAction($_format, Request $request) {
        
        $giftMoney = new GiftMoney();
        $form = $this->createForm(new GiftMoneyType(), $giftMoney);
        
        if ($request->isMethod("POST")) {
            $form->bindRequest($request);
        
            if ($form->isValid())
            {
                /**
                 * @var \Fastre\CigogneBundle\Services\BasketProviderService
                 */
                $basketProvider = $this->get('cigogne.basket.provider');
                $basket = $basketProvider->getBasket();
                
                $basket->addElement($giftMoney);
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($giftMoney);
                $em->flush();
                
                $uuid = $request->request->get('uuid', null);
                
                return new Response(json_encode(
                        array(
                            'result' => true, 
                            'uuid' => $uuid, 
                            'id' => $giftMoney->getId()
                        )));
            }
        }
        
        return $this->createNotFoundException();
        
        
        
        
    }
            
    
}

