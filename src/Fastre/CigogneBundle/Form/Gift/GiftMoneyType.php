<?php

namespace Fastre\CigogneBundle\Form\Gift;

use Fastre\CigogneBundle\Form\GiftType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GiftMoneyType extends GiftType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('amount', 'money', array(
                'label' => 'cigogne.gift.form.common.amount',
                'grouping' => true,
            )
                    )
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fastre\CigogneBundle\Entity\Gift\GiftMoney'
        ));
    }

    public function getName()
    {
        return 'fastre_cigognebundle_gift_giftmoneytype';
    }
}
