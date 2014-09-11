<?php

namespace Fastre\CigogneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Fastre\CigogneBundle\Form\BasketType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * 
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class BasketController extends Controller
{

   public function confirmAction($code, Request $request)
   {
      /**
       * @var \Fastre\CigogneBundle\Entity\Basket $basket
       */
      $basket = $this->get('cigogne.basket.provider')
              ->getBasket();

      if (count($basket->getElements()) <= 0) {
         $this->get('session')
                 ->getFlashBag()
                 ->add('warn', $this->get('translator')->trans(
                         'cigogne.basket.confirm.is_empty'));
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

      foreach ($giftMoneys as $giftMoney) {
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
              new BasketType($basket, $this->getDoctrine()->getManager()), $basket);

      if ($request->getMethod() === 'POST') {
         $basketForm->handleRequest($request);

         if ($basketForm->isValid()) {
            $basket->setClosed(true);

            //register gifts on item
            $function = function (\Fastre\CigogneBundle\Entity\Gift $el) use ($em) {
               $el->registerGiftOnItem();
               $em->persist($el->getItem());
               var_dump($el->getItem()->getReceived());
            };
            array_map($function, $giftMoneys);
            array_map($function, $giftService);
            array_map($function, $giftNature);

            $em->flush();

            //clear the basket in session
            $this->get('cigogne.basket.provider')->clear();

            $confirmationUrl = $this->generateUrl(
                    'cigogne.basket.confirmed', 
                    array('code' => $code, 'basketId' => $basket->getId()), 
                    UrlGeneratorInterface::ABSOLUTE_URL
            );


            //SEND EMAILS - PREPARATION
            $gifts = $this->retrieveGifts($basket);
            //retrieve the list
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
            //send an email to the one who ordered

            $params = array_merge($gifts, array(
                'confirmationUrl' => $confirmationUrl,
                'list' => $list
                    )
            );
            $emailTextToClient = $this->renderView('FastreCigogneBundle:Basket:'
                    . 'confirmed.txt.twig', $params);

            $trans = $this->get('translator');

            $messageToClient = \Swift_Message::newInstance()
                    ->setSubject($trans->trans('cigogne.basket.confirmed.title'))
                    ->setFrom($this->container->getParameter('mail_from'))
                    ->setTo($basket->getEmail())
                    ->setBody($emailTextToClient)
            ;
            $sending1 = $this->get('mailer')->send($messageToClient);

            //send an email to the list owner
            $emailTextToListCreator = $this->renderView('FastreCigogneBundle:Basket:'
                    . 'gift_warning.txt.twig', $params);

            $trans = $this->get('translator');

            $messageToListCreator = \Swift_Message::newInstance()
                    ->setSubject($trans->trans('cigogne.basket.confirmed.warning_subject'))
                    ->setFrom($this->container->getParameter('mail_from'))
                    ->setTo($list->getCreator()->getEmail())
                    ->setBody($emailTextToListCreator)
            ;
            $this->get('mailer')->send($messageToListCreator);




            return $this->redirect($confirmationUrl);
         } else {
            $this->get('session')->getFlashBag()
                    ->add('notice', 'cigogne.basket.confirm.form_invalid');
         }
      }


      return $this->render('FastreCigogneBundle:Basket:confirm.html.twig', array(
                  'giftMoneys' => $giftMoneys,
                  'giftServices' => $giftService,
                  'giftNatures' => $giftNature,
                  'totalMoney' => $totalMoney,
                  'basket' => $basket,
                  'basketForm' => $basketForm->createView(),
                  'code' => $code
      ));
   }

   public function confirmedAction(Request $request, $code, $basketId)
   {
      $basket = $this->getDoctrine()->getRepository('FastreCigogneBundle:Basket')
              ->find($basketId);

      if ($basket === NULL) {
         return $this->createNotFoundException();
      }

      //retrieve the list
      //sanitize code
      $code = trim($code);

      //get the list
      $em = $this->getDoctrine()->getEntityManager();
      $q = $em->createQuery('SELECT l from FastreCigogneBundle:Listing l JOIN '
              . 'l.codes c where c.word like :code');
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


      //retrieve gifts
      $gifts = $this->retrieveGifts($basket);

      $params = $gifts;
      $params['list'] = $list;
      $params['code'] = $code;
      $params['basket'] = $basket;

      return $this->render('FastreCigogneBundle:Basket:confirmed.html.twig', $params);
   }

   private function retrieveGifts(\Fastre\CigogneBundle\Entity\Basket $basket)
   {
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

      foreach ($giftMoneys as $giftMoney) {
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

      return array(
          'giftMoneys' => $giftMoneys,
          'giftServices' => $giftService,
          'giftNatures' => $giftNature,
          'basket' => $basket,
          'totalMoney' => $totalMoney,
      );
   }

}
