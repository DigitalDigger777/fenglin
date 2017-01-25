<?php
/**
 * Created by PhpStorm.
 * User: korman
 * Date: 23.01.17
 * Time: 14:33
 */
namespace Panda\ShopperBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Fenglin\FenglinBundle\Entity\ConsumerAmount;

/**
 * Class LoadShopperAmountConsumersData
 * @package Panda\ShopperBundle\DataFixtures\ORM
 */
class LoadShopperAmountConsumersData implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $shoppers = null;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $consumers = null;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->shoppers = $manager->getRepository('PandaShopperBundle:Shopper')->findAll();
        $this->consumers = $manager->getRepository('PandaConsumerBundle:Consumer')->findAll();

        foreach($this->shoppers as $shopper)
        {
            foreach($this->consumers as $consumer)
            {
                $consumerAmount = new ConsumerAmount();
                $consumerAmount->setShopper($shopper);
                $consumerAmount->setConsumer($consumer);
                $consumerAmount->setTotalAmount(rand(10, 100));

                $manager->persist($consumerAmount);
            }
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}