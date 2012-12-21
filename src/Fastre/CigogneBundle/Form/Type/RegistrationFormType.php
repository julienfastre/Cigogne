<?php

namespace Fastre\CigogneBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

/**
 * Description of RegistrationFormType
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class RegistrationFormType extends BaseType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        
        $builder->add('phonenumber', 'text', array('required' => false));
        
        $builder->add('paymentPaypalAccepted', 'checkbox', array('required' => false));
        $builder->add('paymentPaypalAccount', 'email', array('required' => false));
        
        $builder->add('paymentBankAccepted', 'checkbox', array('required' => false));
        $builder->add('paymentBankAccountNumber', 'text', array('required' => false));
        
        $builder->add('paymentBitcoinAccepted', 'checkbox', array('required' => false));
        $builder->add('paymentBitcoinAddress', 'text', array('required' => false));
        
    }
    
    public function getName() {
        return 'fastre_cigogne_registration';
    }
    
}

