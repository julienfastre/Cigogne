<?php

namespace Fastre\CigogneBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;
use Fastre\CigogneBundle\Entity\Basket;
use Fastre\CigogneBundle\Entity\Gift;

/**
 * Description of BasketProviderService
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class BasketProviderService {
    
    /**
     *
     * @var \Symfony\Component\HttpFoundation\Session\Session 
     */
    private $session;
    
    /**
     *
     * @var \Doctrine\ORM\EntityManager 
     */
    private $em;
    
    const KEY = "basket";
    
    public function __construct(Session $session, EntityManager $em) {
        $this->session = $session;
        $this->em = $em;
    }
    
    /**
     * 
     * @return \Fastre\CigogneBundle\Entity\Basket
     */
    public function getBasket() {
        $basket_id = $this->session->get(self::KEY, null);
        
        if ($basket_id === null)
        {
            $basket = new Basket();
            
            $this->em->persist($basket);
            $this->em->flush($basket);
            
            $this->session->set(self::KEY, $basket->getid());
        } else {
            $basket = $this->em->getRepository('FastreCigogneBundle:Basket')
                    ->find($basket_id);
            if ($basket === null) {
                throw new \Exception('basket not found with id '.$basket_id);
            }
        }
        
        return $basket;
        
    }
    
    public function clear()
    {
       $this->session->set(self::KEY, null);
    }
    
    
    
}

