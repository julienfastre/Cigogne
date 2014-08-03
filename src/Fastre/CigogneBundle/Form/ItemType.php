<?php

namespace Fastre\CigogneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Fastre\CigogneBundle\Entity\Item;

/**
 * The form to add/update items
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class ItemType extends AbstractType
{
   public function getName()
   {
      return 'item';
   }
   
   public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
   {
      $builder->add('title', 'text')
              ->add('description', 'textarea')
              ->add('type', 'choice', array(
                  'choices' => array(
                      Item::TYPE_GOOD => 'cigogne.form.item.type_good',
                      Item::TYPE_SERVICE => 'cigogne.form.item.type_service'
                  ),
                  'multiple' => false,
                  'expanded' => true
              ))
              ->add('quantity', 'integer', array(
                  
              ))
              ->add('price', 'money')
              ->add('furniture', 'choice', array(
                  'choices' => array(
                      Item::FURNITURE_MONEY => 'cigogne.form.item.furniture_money',
                      Item::FURNITURE_NATURE => 'cigogne.form.item.furniture_nature',
                      Item::FURNITURE_SERVICE => 'cigogne.form.tem.furniture_service'
                  ),
                  'multiple' => true,
                  'expanded' => true
              ))
              ->add('good', 'choice', array(
                  'choices' => array(
                      Item::GOOD_NEW => 'cigogne.form.item.good_new',
                      Item::GOOD_SECOND_HAND => 'cigogne.form.item.good_second'
                  ),
                  'expanded' => true,
                  'multiple' => true
              ))
              ;
   }

}
