<?php

namespace Fastre\CigogneBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Fastre\CigogneBundle\Entity\Listing;
use Fastre\CigogneBundle\Entity\Code;

/**
 * Description of LoadListData
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class LoadListingData extends AbstractFixture implements ContainerAwareInterface,
        OrderedFixtureInterface {
    
    private $container;
    
    public function getOrder() {
        return 2;
    }

    public function load(ObjectManager $manager) {
        
        $l = new Listing();
        $l->setCreator($this->getReference('user1'));
        $l->setDescription("Notre liste pour le deuxième bébé. On a déjà pas mal de choses, alors on voudrait beaucoup de récup!");
        $l->addCode(new Code('hublart'))
                ->addCode(new Code('fastré'))
                ->setName('La liste du deuxième');
        
        $manager->persist($l);
        
        $this->addReference('list0', $l);
        
        $l2 = new Listing();
        $l2->setCreator($this->getReference('user2'));
        $l2->setDescription("C'est notre premier! Il nous faut plein de trucs!");
        $l2->addCode(new Code('robert'))
                ->addCode(new Code('arnaud'))
                ->setName('La liste du premier');
        
        $manager->persist($l2);
        
        $this->addReference('list1', $l2);
        
        $manager->flush();
        
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}

