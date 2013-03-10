<?php

namespace Fastre\CigogneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Fastre\CigogneBundle\Entity\Gift\GiftMoney;
use Fastre\CigogneBundle\Form\Gift\GiftMoneyType;
use Fastre\CigogneBundle\Entity\Gift\GiftNature;
use Fastre\CigogneBundle\Form\Gift\GiftNatureType;
use Fastre\CigogneBundle\Entity\Gift\GiftService;
use Fastre\CigogneBundle\Form\Gift\GiftServiceType;

/**
 * 
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class GiftController extends Controller {
    
    const DELETE_ITEM_TOKEN = 'delete_item';
    
    public function addAction($_format, Request $request, $type) {
        
        switch($type) {
            case 'money' :    
                $gift = new GiftMoney();
                $form = $this->createForm(new GiftMoneyType(), $gift);
                break;
            case 'nature':
                $gift = new GiftNature();
                $form = $this->createForm(new GiftNatureType, $gift);
                break;
            case 'service':
                $gift = new GiftService();
                $form = $this->createForm(new GiftServiceType, $gift);
                break;
            default:
                $r = new Response('type not exist : '.$type);
                $r->setStatusCode(400);
                return $r;
        }
        
        
        
        
        if ($request->isMethod("POST")) {
            $form->bindRequest($request);
        
            if ($form->isValid())
            {
                /**
                 * @var \Fastre\CigogneBundle\Services\BasketProviderService
                 */
                $basketProvider = $this->get('cigogne.basket.provider');
                $basket = $basketProvider->getBasket();
                
                $basket->addElement($gift);
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($gift);
                $em->flush();
                
                $uuidFromClient = $request->request->get('uuid', null);
                
                return new Response(json_encode(
                            array(
                                'result' => true,
                                'uuid' => $uuidFromClient,
                                'id' => $gift->getId()
                            )
                        ));
            }
        }
        
        return $this->createNotFoundException();
        
        
        
        
    }
    
    public function removeAction($_format, Request $request) {
        
        
        $token = $request->request->get('token', null);
        $giftId = $request->request->get('id', null);
        
        if ($token === null OR $giftId === null) {
            $r = new Response('malformed Request : token : '.$token.' id : '.$giftId );
            $r->setStatusCode(400);
            return $r;
        }
        
        /*if ($this->get('form.csrf_provider')
                ->isCsrfTokenValid($token, self::DELETE_ITEM_TOKEN) == false) {
            $r = new Response('bad token : are you trying to steal a session id ? ' );
            $r->setStatusCode(403);
            return $r;
        }*/ //FIXME : add correct csrf protection here
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $gift = $em->getRepository('FastreCigogneBundle:Gift')
                ->find($giftId);
        
        if ($gift === null) {
            throw $this->createNotFoundException('gift not found with id '.$giftId);
        }
        
        $basket = $this->get('cigogne.basket.provider')->getBasket();
        
        if ($basket->hasElement($gift) === false) {
            $r = new Response('bad request: you can not delete an element for not current basket ' );
            $r->setStatusCode(403);
            return $r;
        }
        
        $basket->removeElement($gift);
        $em->remove($gift);
        
        $em->flush();
        
        return new Response(
                    json_encode(array(
                        'result' => true
                    ))
                );
        
    }
            
    
}

