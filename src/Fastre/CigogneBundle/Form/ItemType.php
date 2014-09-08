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
                      Item::TYPE_GOOD => 'cigogne.item.form.type_good',
                      Item::TYPE_SERVICE => 'cigogne.item.form.type_service'
                  ),
                  'multiple' => false,
                  'expanded' => true
              ))
              ->add('quantity', 'integer', array(
                  
              ))
              ->add('price', 'money')
              ->add('furniture', 'choice', array(
                  'choices' => array(
                      Item::FURNITURE_MONEY => 'cigogne.item.form.furniture_money',
                      Item::FURNITURE_NATURE => 'cigogne.item.form.furniture_nature',
                      Item::FURNITURE_SERVICE => 'cigogne.item.form.furniture_service'
                  ),
                  'multiple' => true,
                  'expanded' => true
              ))
              ->add('good', 'choice', array(
                  'choices' => array(
                      Item::GOOD_NEW => 'cigogne.item.form.good_new',
                      Item::GOOD_SECOND_HAND => 'cigogne.item.form.good_second'
                  ),
                  'preferred_choices' => array(Item::GOOD_NEW),
                  'expanded' => true,
                  'multiple' => true
              ))
              ->add('photo', new PhotoType(), array(
                  'required' => false
              ))
              ;
   }

}
