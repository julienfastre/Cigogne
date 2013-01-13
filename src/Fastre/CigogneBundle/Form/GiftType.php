<?php

namespace Fastre\CigogneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GiftType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('basket', 'basket_hidden')
            ->add('item', 'item_hidden')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fastre\CigogneBundle\Entity\Gift'
        ));
    }

    public function getName()
    {
        return 'fastre_cigognebundle_gifttype';
    }
}
