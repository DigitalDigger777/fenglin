<?php
/**
 * Created by PhpStorm.
 * User: korman
 * Date: 23.01.17
 * Time: 14:17
 */

namespace Fenglin\CashBackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Fenglin\CashBackBundle\Entity\CashBack;
use Panda\ConsumerBundle\Entity\Consumer;
use Panda\ShopperBundle\Entity\Shopper;

/**
 * Class LoadCashBackData
 * @package Panda\ConsumerBundle\DataFixtures\ORM
 */
class LoadCashBackData implements FixtureInterface, OrderedFixtureInterface
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
        for($i = 0; $i < 100; $i++) {
            $this->loadCashBack($manager);
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadCashBack(ObjectManager $manager)
    {
        $this->shoppers = $manager->getRepository('PandaShopperBundle:Shopper')->findAll();
        $this->consumers = $manager->getRepository('PandaConsumerBundle:Consumer')->findAll();
        $shopper = $this->getRandomShopper();
        $consumer = $this->getRandomConsumer();

        $cashBack = new CashBack();
        $cashBack->setAmount(rand(1, 20));
        $cashBack->setAmountLevel2(rand(1, 10));
        $cashBack->setAmountLevel3(rand(1, 5));
        $cashBack->setDate(new \DateTime());
        $cashBack->setStatus(rand(0, 2));
        $cashBack->setConsumer($consumer);
        $cashBack->setShopper($shopper);

        $manager->persist($cashBack);
    }

    /**
     * @return mixed|null
     */
    private function getRandomShopper()
    {
        $count = count($this->shoppers);
        return $this->shoppers[rand(0, $count - 1)];
    }

    /**
     * @return mixed|null
     */
    private function getRandomConsumer()
    {
        $count = count($this->consumers);
        return $this->consumers[rand(0, $count - 1)];
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