<?php

namespace Fastre\CigogneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use \Exception;
use Fastre\CigogneBundle\Entity\Item;
use Fastre\CigogneBundle\Entity\Gift\GiftMoney;
use Fastre\CigogneBundle\Form\Gift\GiftMoneyType;
use Fastre\CigogneBundle\Entity\Gift\GiftNature;
use Fastre\CigogneBundle\Form\Gift\GiftNatureType;
use Fastre\CigogneBundle\Entity\Gift\GiftService;
use Fastre\CigogneBundle\Form\Gift\GiftServiceType;



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
    
    public function pickFromCodeAction(Request $request) {
        //get code string and sanitize
        $codeString = $request->request->get('code');
        $codeString = trim($codeString);
        
        //split code into array
        $codeArray = preg_split("/[\s,]+/", $codeString, 3);
        
        $em = $this->getDoctrine()->getEntityManager();
        
        foreach($codeArray as $word ) {
            $q = $em->createQuery('SELECT l from FastreCigogneBundle:Listing l JOIN l.codes c where c.word like :word');
            $q->setParameter('word', $word);
            try {
                    $l = $q->getSingleResult();
            } catch (NonUniqueResultException $e) {
                //redirect to first page
                $message = $this->get('translator')->trans('cigogne.listing.pick_from_code.not_found');
                $this->get('session')->getFlashBag()->add('warn', $message);
                return $this->redirect(
                        $this->generateUrl("homepage")
                        );
            } catch (NoResultException $e) {
                $l = null;
            }
            
            if ($l !== null) {
                $code = $word;
                break;
            }
                
        }
        
        if ($l !== null)
        {
            return $this->redirect($this->generateUrl('cigogne.listing.see', array('code' => $code)));
        } else {
            //redirect to first page
            $message = $this->get('translator')->trans('cigogne.listing.pick_from_code.not_found');
                $this->get('session')->getFlashBag()->add('warn', $message);
                return $this->redirect(
                        $this->generateUrl("homepage")
                        );
        }
        
        
    }
    
    public function getListingFromCodeAction($code, Request $request) {
        //sanitize code
        $code = trim($code);
        
        //get the list
        $em = $this->getDoctrine()->getEntityManager();
        $q = $em->createQuery('SELECT l from FastreCigogneBundle:Listing l JOIN l.codes c where c.word like :code');
        $q->setParameter('code', $code);
        
        try {
           $l = $q->getSingleResult();
                    
        } catch (Exception $e) {
            //redirect to first page
            $message = $this->get('translator')->trans('cigogne.listing.pick_from_code.not_found');
            $this->get('session')->getFlashBag()->add('warn', $message);
            return $this->redirect(
                    $this->generateUrl("homepage")
                    );
        }
        
        //prepare an array which hold the form for gifts
        $forms = array();
        $basket = new \Fastre\CigogneBundle\Entity\Basket();
        
        foreach ($l->getItems() as $item) {
            $forms_item = array();
            
            if ($item->getType() === Item::TYPE_GOOD) {
 
                if (in_array(Item::FURNITURE_MONEY, $item->getFurniture())) {
                    $gift = new GiftMoney();
                    $gift->setBasket($basket)
                            ->setItem($item)
                            ->setAmount($item->getPrice());
                    $f = $this->createForm(new GiftMoneyType(), $gift);
                    $forms_item[Item::FURNITURE_MONEY] = $f->createView();
                }

                if (in_array(Item::FURNITURE_NATURE, $item->getFurniture())) {
                    $gift = new GiftNature();
                    $gift->setBasket($basket)
                            ->setItem($item)
                            ;
                    $f = $this->createForm(new GiftNatureType(), $gift);
                    $forms_item[Item::FURNITURE_NATURE] = $f->createView();
                }
            } else {
                $gift = new GiftService();
                $gift->setBasket($basket)
                        ->setItem($item)
                        ;
                $f = $this->createForm(new GiftServiceType(), $gift);
                $forms_item[Item::FURNITURE_SERVICE] = $f->createView();
            }
            
            if (count($forms_item) > 0) {
                $forms[$item->getId()] = $forms_item;
            }
        }
        
        
        //get the gift already in the basket and serialize them into json
        $json = $this->get("cigogne.normalizer.serializer")
                ->serialize(
                        $this->get("cigogne.basket.provider")
                            ->getBasket()
                            ->getElements(),
                        'json',
                        array()
                        );
        
        
        
        return $this->render('FastreCigogneBundle:Listing:view.html.twig', array(
            'listing' => $l,
            'forms' => $forms,
            'deleteToken' => $this->get('form.csrf_provider')
                ->generateCsrfToken(GiftController::DELETE_ITEM_TOKEN),
            'itemsInBasket' => $json,
        ));        
    }
    
    
}

