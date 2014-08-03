<?php

namespace Fastre\CigogneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Fastre\CigogneBundle\Entity\Item;
use Fastre\CigogneBundle\Form\ItemType;


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
}
