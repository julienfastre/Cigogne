<?php

namespace Fastre\CigogneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Fastre\CigogneBundle\Entity\Basket;
use Doctrine\ORM\EntityManager;

class BasketType extends AbstractType
{
    
    private $basket;
    private $em;
    
    
    public function __construct(Basket $basket, EntityManager $em ) {
        $this->basket = $basket;
        $this->em = $em;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'cigogne.basket.form.name'
                ))
            ->add('email', 'email', array(
                'label' => 'cigogne.basket.form.email'
            ))
            ->add('message', 'textarea', array(
                'label' => 'cigogne.basket.form.message',
                'required' => false
            ))
            ->add('payment', 'choice', array(
                'choices' => Basket::getPaymentMethodWithTranslation(),
                'multiple' => false,
                'expanded' => true,
                'label' => 'cigogne.basket.form.payement'
            ))
        ;
        
        //calculate if there are giftMoney
        
        
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fastre\CigogneBundle\Entity\Basket'
        ));
    }

    public function getName()
    {
        return 'fastre_cigognebundle_baskettype';
    }
}
