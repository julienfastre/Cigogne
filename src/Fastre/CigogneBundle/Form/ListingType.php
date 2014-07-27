<?php

namespace Fastre\CigogneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Fastre\CigogneBundle\Form\DataTransformer\TextToCodeTransformer;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * A form to create a listing
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class ListingType extends AbstractType
{
   
   public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
   {
      $builder->add('name', 'text')
              ->add('description', 'textarea')
              ->add('codes', 'code')
              ;
   }

   
   public function getName()
   {
      return 'listing';
   }
}
