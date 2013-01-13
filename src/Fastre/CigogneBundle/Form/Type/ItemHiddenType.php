<?php

namespace Fastre\CigogneBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Fastre\CigogneBundle\Form\DataTransformer\ItemToNumberTransformer;

/**
 * Create an hidden field for item
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class ItemHiddenType extends AbstractType {
    
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
        $transformer = new ItemToNumberTransformer($this->om);
        $builder->addModelTransformer($transformer);
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'invalid_message' => "cigogne.type.item_hidden.does_not_exist"
        ));
    }
    
    public function getName() {
        return 'item_hidden';
    }
    
    public function getParent() {
        return 'hidden';
    }
}

