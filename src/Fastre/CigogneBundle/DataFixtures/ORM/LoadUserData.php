<?php

namespace Fastre\CigogneBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Description of LoadUserData
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface {
    
    /**
     *
     * @var Symfony\Component\DependencyInjection\ContainerInterface 
     */
    private $container;
    
    public function getOrder() {
        return 1;
    }
    
    

    public function load(ObjectManager $manager) {
        
        $userManager = $this->container->get('fos_user.user_manager');
        
        $user = $userManager->createUser();
        
        $user->setUsername("Ju et Coline");
        $user->setEmail("julien@fastre.info");
        $user->setPassword('julien');
        $user->setPhonenumber('+3242870228');
        
        $userManager->updateUser($user);
        
        $this->addReference('user1', $user);
        
        $user1 = $userManager->createUser();
        
        $user1->setUsername("Ju et Coline Deux");
        $user1->setEmail("julien@test.fastre.info");
        $user1->setPassword('julien');
        $user1->setPhonenumber('+3242870228');
        
        $userManager->updateUser($user1);
        
        $this->addReference('user2', $user1);
        
        $manager->flush();
        
    }

    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
    }
}

