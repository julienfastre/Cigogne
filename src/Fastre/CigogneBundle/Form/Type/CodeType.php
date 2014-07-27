<?php

namespace Fastre\CigogneBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Fastre\CigogneBundle\Form\DataTransformer\TextToCodeTransformer;

/**
 * code on text
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class CodeType extends AbstractType
{
   
   private $em;
   
   public function __construct(\Doctrine\Common\Persistence\ObjectManager $em)
   {
      $this->em = $em;
   }
   
   public function getName()
   {
      return 'code';
   }
   
   public function getParent()
   {
      return 'text';
   }
   
   public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
   {
      $builder->addModelTransformer(new TextToCodeTransformer($this->em));
   }

}
