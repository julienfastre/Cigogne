<?php

namespace Fastre\CigogneBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Fastre\CigogneBundle\Form\DataTransformer\BasketToNumberTransformer;

/**
 * Create an hidden field for item
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class BasketHiddenType extends AbstractType {
    
    /**
     *
     * @var \Doctrine\Common\Persistence\ObjectManager 
     */
    private $om;
    
    /**
     * 
     * @param \Doctrine\Common\Persistence\ObjectManager $om
     */
    public function __construct(ObjectManager $om) {
        $this->om = $om;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $transformer = new BasketToNumberTransformer($this->om);
        $builder->addModelTransformer($transformer);
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'invalid_message' => "cigogne.type.basket_hidden.does_not_exist"
        ));
    }
    
    public function getName() {
        return 'basket_hidden';
    }
    
    public function getParent() {
        return 'hidden';
    }
}

