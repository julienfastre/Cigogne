<?php

namespace Fastre\CigogneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use InvalidArgumentException;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FastreCigogneBundle:Default:index.html.twig');
    }
    
    public function pageAction($page)
    {
       try {
          return $this->render('FastreCigogneBundle:Page:'.$page.'.html.twig');
       } catch (InvalidArgumentException $e) {
          throw $this->createNotFoundException('page not found');
       }
    }
}
