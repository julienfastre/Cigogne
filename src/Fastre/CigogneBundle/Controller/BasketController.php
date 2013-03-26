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
    
    public function confirmAction($code) {
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
        
        $totalMoney = 1;
        
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
        
        $basketForm = $this->createForm(new BasketType($basket), $basket);
        
        
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
    
}

