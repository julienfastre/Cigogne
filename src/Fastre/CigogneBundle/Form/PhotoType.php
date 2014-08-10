<?php

namespace Fastre\CigogneBundle\Form;

use Symfony\Component\Form\AbstractType;

/**
 * 
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class PhotoType extends AbstractType
{
   public function getName()
   {
      return 'photo';
   }
   
   public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
   {
      $builder->add('photo', 'file', array(
          
      ));
   }
   
   public function setDefaultOptions(\Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver)
   {
      $resolver->setDefaults(array(
          'data_class' => 'Fastre\CigogneBundle\Entity\Photo'
      ));
   }

}
