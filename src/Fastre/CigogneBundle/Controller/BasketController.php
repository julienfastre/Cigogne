<?php


namespace Fastre\CigogneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Fastre\CigogneBundle\Form\BasketType;


/**
 * 
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class BasketController extends Controller {
    
    public function confirmAction($code, Request $request) {
        /**
         * @var \Fastre\CigogneBundle\Entity\Basket $basket
         */
        $basket = $this->get('cigogne.basket.provider')
                ->getBasket();
        
        if (count($basket->getElements()) <= 0) {
            $this->get('session')
                    ->getFlashBag()
                    ->add('notice', 'cigogne.basket.confirm.is_empty');
        }
        
        $em = $this->getDoctrine()->getEntityManager();
        
        $giftMoneys = $em->createQuery('select gm from 
            FastreCigogneBundle:Gift\GiftMoney gm where gm.basket = :basket')
                ->setParameter('basket', $basket)
                ->getResult();
        
        $giftNature = $em->createQuery('select gn from 
            FastreCigogneBundle:Gift\GiftNature gn where gn.basket = :basket')
                ->setParameter('basket', $basket)
                ->getResult();
        
        $giftService = $em->createQuery('select gs from 
            FastreCigogneBundle:Gift\GiftService gs where gs.basket = :basket')
                ->setParameter('basket', $basket)
                ->getResult();
        
        $totalMoney = 0;
        
        foreach($giftMoneys as $giftMoney) {
            $totalMoney += $giftMoney->getAmount();
        }
        
        if ($totalMoney === 0) {
            $giftMoney = array();
        }
        
        if (count($giftService) === 0) {
            $giftService = array();
        }
        
        if (count($giftNature) === 0) {
            $giftNature = array();
        }
        
        $basketForm = $this->createForm(
                new BasketType($basket, $this->getDoctrine()->getManager()), 
                $basket);
        
        if ($request->getMethod() === 'POST') {
        	$basketForm->submit($request);
        	
        	if ($basketForm->isValid()) {
        	    $basket->setClosed(true);
        		$em->persist($basket);
        		$em->flush($basket);
        		
        		//send an email to the one who ordered
        		
        		return $this->redirect($this->generateUrl(
                    'cigogne.basket.confirmed',
        		    array('code' => $code, 'basketId' => $basket->getId())
        		));
        		
        	} else {
        		$this->get('session')->getFlashBag()
        		   ->add('notice', 'cigogne.basket.confirm.form_invalid');
        	}
        }
        
        
        return $this->render('FastreCigogneBundle:Basket:confirm.html.twig', 
                array(
                    'giftMoneys' => $giftMoneys,
                    'giftServices' => $giftService,
                    'giftNatures' => $giftNature,
                    'totalMoney' => $totalMoney,
                    'basketForm' => $basketForm->createView(),
                    'code' => $code
                ));
        
        
    }
    
    public function confirmedAction(Request $request, $code, $basketId)
    {
        $basket = $this->get('cigogne.basket.provider')->getBasket();
        
        //check we are allowed to view id
        if ($basket->getId() !== $basketId) {
            $response = new Response($this->get('translator')->trans(
                    'cigogne.basket.confirm.invalid_basket_id'
            ));
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            return $response;
        }
        
        //sanitize code
        $code = trim($code);
        
        //get the list
        $em = $this->getDoctrine()->getEntityManager();
        $q = $em->createQuery('SELECT l from FastreCigogneBundle:Listing l JOIN l.codes c where c.word like :code');
        $q->setParameter('code', $code);
        
        try {
            $list = $q->getSingleResult();
        
        } catch (Exception $e) {
            //redirect to first page
            $message = $this->get('translator')->trans('cigogne.listing.pick_from_code.not_found');
            $this->get('session')->getFlashBag()->add('warn', $message);
            return $this->redirect(
                $this->generateUrl("homepage")
            );
        }
        
        //check basket match code
        if ($basket->getElements()->first()->getItem()->getListing()->getId() !== $list->getId()) {
            $response = new Response($this->get('translator')->trans(
                'cigogne.basket.confirm.invalid_basket_code'
            ));
            $response->setStatusCode(Response::HTTP_FORBIDDEN);
            return $response;
        }
        
        //retrieve gifts
        $em = $this->getDoctrine()->getEntityManager();
        
        $giftMoneys = $em->createQuery('select gm from
            FastreCigogneBundle:Gift\GiftMoney gm where gm.basket = :basket')
                    ->setParameter('basket', $basket)
                    ->getResult();
        
        $giftNature = $em->createQuery('select gn from
            FastreCigogneBundle:Gift\GiftNature gn where gn.basket = :basket')
                    ->setParameter('basket', $basket)
                    ->getResult();
        
        $giftService = $em->createQuery('select gs from
            FastreCigogneBundle:Gift\GiftService gs where gs.basket = :basket')
                    ->setParameter('basket', $basket)
                    ->getResult();
        
        $totalMoney = 0;
        
        foreach($giftMoneys as $giftMoney) {
            $totalMoney += $giftMoney->getAmount();
        }
        
        if ($totalMoney === 0) {
            $giftMoney = array();
        }
        
        if (count($giftService) === 0) {
            $giftService = array();
        }
        
        if (count($giftNature) === 0) {
            $giftNature = array();
        }
        
        return $this->render('FastreCigogneBundle:Basket:confirmed.html.twig',
            array(
                'giftMoneys' => $giftMoneys,
                'giftServices' => $giftService,
                'giftNatures' => $giftNature,
                'basket' => $basket,
                'totalMoney' => $totalMoney,
                'list' => $list,
                'code' => $code
            ));
        
        
        
    }
    
}

