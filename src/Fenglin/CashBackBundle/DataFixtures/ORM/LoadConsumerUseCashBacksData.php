<?php
/**
 * Created by PhpStorm.
 * User: korman
 * Date: 23.01.17
 * Time: 14:33
 */
namespace Fenglin\CashBackBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Fenglin\FenglinBundle\Entity\ConsumerUseCashBack;
use Panda\ShopperBundle\Entity\Shopper;

class LoadConsumerUseCashBacksData implements FixtureInterface, OrderedFixtureInterface
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
                $consumerUseCashBack = new ConsumerUseCashBack();
                $consumerUseCashBack->setConsumer($consumer);
                $consumerUseCashBack->setShopper($shopper);
                $consumerUseCashBack->setAmount(rand(10, 100));
                $consumerUseCashBack->setDate(new \DateTime());

                $manager->persist($consumerUseCashBack);
            }
        }

        $manager->flush();
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