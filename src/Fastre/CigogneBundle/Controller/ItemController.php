<?php

namespace Fastre\CigogneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Fastre\CigogneBundle\Entity\Item;
use Fastre\CigogneBundle\Form\ItemType;
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
class ItemController extends Controller
{
   public function newAction($listingId, Request $request)
   {
      $listing = $this->getDoctrine()->getManager()
              ->getRepository('FastreCigogneBundle:Listing')
              ->find($listingId);
      
      if ($listing === NULL){
         throw $this->createNotFoundException();
      }
      
      $user = $this->get('security.context')->getToken()->getUser();
      
      if ($user->getId() !== $listing->getCreator()->getId()) {
         throw $this->createAccessDeniedException();
      }
      
      $item = new Item();
      $item->setListing($listing);
      
      $form = $this->createForm(new ItemType(), $item);
      
      if ($request->getMethod() === 'POST') {
         $form->handleRequest($request);
         
         if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();
            
            $this->get('session')->getFlashBag()
                    ->add('notice', 'cigogne.form.item.item_added');
            
            return $this->redirect(
                    $this->generateUrl('cigogne.listing.update',
                            array('id' => $listingId))
                    );
         }
      }
      
      return $this->render('FastreCigogneBundle:Item:form.html.twig',
              array(
                  'form' => $form->createView()
              ));
   }
   
   public function updateAction($listingId, $id, Request $request)
   {
      $listing = $this->getDoctrine()->getManager()
              ->getRepository('FastreCigogneBundle:Listing')
              ->find($listingId);
      
      if ($listing === NULL){
         throw $this->createNotFoundException();
      }
      
      $user = $this->get('security.context')->getToken()->getUser();
      
      if ($user->getId() !== $listing->getCreator()->getId()) {
         throw $this->createAccessDeniedException();
      }
      
      $item = $this->getDoctrine()->getManager()
              ->getRepository('FastreCigogneBundle:Item')
              ->find($id);
      
      if ($item === NULL) {
         throw $this->createNotFoundException();
      }
      
      if ($item->getListing()->getId() !== $listing->getId()) {
         throw $this->createNotFoundException('item does not belong to id');
      }
      
      $form = $this->createForm(new ItemType(), $item);
      
      if ($request->getMethod() === 'POST'){
         $form->handleRequest($request);
         
         if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            
            $this->get('session')->getFlashBag()
                    ->add('notice', 'cigogne.form.item.item_updated');
            
            return $this->redirect(
                    $this->generateUrl('cigogne.listing.update',
                            array('id' => $listingId)
                            )
                    );
         }
      }
      
      return $this->render('FastreCigogneBundle:Item:form.html.twig',
              array(
                  'form' => $form->createView()
              )
              );
      
   }
   
   public function publicViewAction(Request $request, $codeListing, $itemId)
   {
      //get listing from code
      //sanitize code
      $code = trim($codeListing);

      //get the list
      $em = $this->getDoctrine()->getEntityManager();
      $q = $em->createQuery('SELECT l from FastreCigogneBundle:Listing l JOIN l.codes c where c.word like :code');
      $q->setParameter('code', $code);

      try {
         $listing = $q->getSingleResult();
      } catch (Exception $e) {
         //redirect to first page
         $message = $this->get('translator')->trans('cigogne.listing.pick_from_code.not_found');
         $this->get('session')->getFlashBag()->add('warn', $message);
         return $this->redirect(
                         $this->generateUrl("homepage")
         );
      }
      
      $item = $em->getRepository('FastreCigogneBundle:Item')
              ->find($itemId);
      
      if (NULL === $item) {
         throw $this->createNotFoundException('item not found');
      }
      
      $basket = $this->get('cigogne.basket.provider')->getBasket();
      
      //store the forms
      $forms_item = array();

      if ($item->getType() === Item::TYPE_GOOD) {

         if (in_array(Item::FURNITURE_MONEY, $item->getFurniture())) {
            $gift = new GiftMoney();
            $gift->setBasket($basket)
                    ->setItem($item)
                    //->setAmount($item->getRemainPossibleToGive(Item::FURNITURE_MONEY))
            ;
            $f = $this->createForm(new GiftMoneyType(), $gift);
            $forms_item[Item::FURNITURE_MONEY] = $f->createView();
         }

         if (in_array(Item::FURNITURE_NATURE, $item->getFurniture())) {
            $gift = new GiftNature();
            $gift->setBasket($basket)
                    ->setItem($item)
                    //->setQuantity($item->getRemainPossibleToGive(Item::FURNITURE_NATURE))
            ;
            $f = $this->createForm(new GiftNatureType(), $gift);
            $forms_item[Item::FURNITURE_NATURE] = $f->createView();
         }
      } else {
         $gift = new GiftService();
         $gift->setBasket($basket)
                 ->setItem($item)
                 //->setQuantity($item->getRemainPossibleToGive(Item::FURNITURE_SERVICE))
         ;
         $f = $this->createForm(new GiftServiceType(), $gift);
         $forms_item[Item::FURNITURE_SERVICE] = $f->createView();
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
      
      return $this->render('FastreCigogneBundle:Item:publicView.html.twig',
              array(
                  'forms_item' => $forms_item,
                  'item' => $item,
                  'listing' => $listing,
                  'code' => $code,
                  'deleteToken' => $this->get('form.csrf_provider')
                     ->generateCsrfToken(GiftController::DELETE_ITEM_TOKEN),
                  'itemsInBasket' => $json
              ));
      
   }

}
