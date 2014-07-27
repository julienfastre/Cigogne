<?php

namespace Fastre\CigogneBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;


/**
 * Description of RegistrationFormType
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class RegistrationFormType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        parent::buildForm($builder, $options);
        
        $builder->add('label', 'text', array('required' => true));
        
        
        $builder->add('paymentBankAccepted', 'checkbox', array('required' => false));
        $builder->add('paymentBankAccountNumber', 'text', array('required' => false));
        
        
    }
    
    public function getName() {
        return 'fastre_cigogne_registration';
    }
    
}

