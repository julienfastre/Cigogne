<?php

namespace Fastre\CigogneBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Fastre\CigogneBundle\Entity\Item;

/**
 * Description of LoadItemsData
 *
 * @author Julien Fastré <julien arobase fastre point info>
 */
class LoadItemsData extends AbstractFixture implements OrderedFixtureInterface {
    
    
    public function getOrder() {
        return 3;
    }

    public function load(ObjectManager $manager) {
        
        $items = array(
            array(
                "desc" => "Une grande pousette pour mettre les deux enfants avec un marchepied pour le premier",
                "title" => "pousette de luxe",
                "quantity" => 1,
                "furn" => array(Item::FURNITURE_MONEY, Item::FURNITURE_NATURE),
                "price" => 550,00,
                "priority" => 0,
                "type" => Item::TYPE_GOOD,
                'good' => array(Item::GOOD_NEW, Item::GOOD_SECOND_HAND),
            ),
            array(
                "desc" => "Cette baignoire ravira le petit (jusqu'à ce que le grand la troue)",
                "title" => "baignoire facile",
                "quantity" => 1,
                "furn" => array(Item::FURNITURE_MONEY),
                "price" => 25,
                "furnDetails" => "si possible sans trous :-)",
                "priority" => 1,
                "type" => Item::TYPE_GOOD,
                'good' => array(Item::GOOD_NEW),
            ),
            
        );
        
        foreach ($items as $a)
        {
            $item = new Item();
            $item->setTitle($a['title'])
                    ->setDescription($a['desc'])
                    ->setQuantity($a['quantity'])
                    ->setPrice($a['price'])
                    ->setFurniture($a['furn'])
                    ->setPriority($a['priority'])
                    ->setType($a['type'])
                    ->setGood($a['good']);
            if (isset($a['furnDetails']))
            {
                $item->setFurnitureDetails($a['furnDetails']);
            }
            
            $this->getReference('list0')->addItem($item);
        }
        
        $manager->flush();
        
    }
}

