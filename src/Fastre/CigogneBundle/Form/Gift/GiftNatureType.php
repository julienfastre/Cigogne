<?php

namespace Fastre\CigogneBundle\Form\Gift;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Fastre\CigogneBundle\Form\GiftType;

class GiftNatureType extends GiftType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('message', 'textarea', array('label' => 'cigogne.gift.form.common.message'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fastre\CigogneBundle\Entity\Gift\GiftNature'
        ));
    }

    public function getName()
    {
        return 'fastre_cigognebundle_gift_giftnaturetype';
    }
}
