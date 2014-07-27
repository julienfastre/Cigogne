<?php

namespace Fastre\CigogneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Fastre\CigogneBundle\Form\Type\RegistrationFormType;
use Fastre\CigogneBundle\Entity\User;
use CL\PersonaUserBundle\CLPersonaUserBundle;

/**
 * provide methods and function to deal with users
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class UserController extends Controller
{

   public function registerAction(Request $request)
   {
      $emailRecorded = $this->get('session')
              ->get(CLPersonaUserBundle::KEY_EMAIL_SESSION, null);

      if ($emailRecorded === NULL) {
         $response = new Response("You must authenticate with persona first!");
         $response->setStatusCode(Response::HTTP_NOT_ACCEPTABLE);
         return $response;
      }
      $user = new User();
      $user->setEmail($emailRecorded);

      $form = $this->createForm(new RegistrationFormType(), $user);
      
      if($request->getMethod() === 'POST') {
         $form->handleRequest($request);
         
         if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            
            $this->get('cl_persona_user.manual_login')
                      ->authenticate($user);
            
            $this->get('session')->getFlashBag()->add('notice', 
                    $this->get('translator')->trans('cigogne.register.welcome')
                    );
            
            return $this->redirect($this->generateUrl('cigogne.listing.list'));
         }
      }
      
      return $this->render('FastreCigogneBundle:Persona:register.html.twig', array(
          'form' => $form->createView()
      ));
      
      
   }

   public function personaExplainAction()
   {
      return $this->render('FastreCigogneBundle:Persona:explain.html.twig');
   }
   
   public function logoutAction()
   {
      return array();
   }

}
