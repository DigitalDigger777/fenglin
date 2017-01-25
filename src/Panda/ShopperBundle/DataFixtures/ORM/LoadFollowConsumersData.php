<?php
/**
 * Created by PhpStorm.
 * User: korman
 * Date: 23.01.17
 * Time: 14:33
 */
namespace Panda\ShopperBundle\DataFixtures\ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadFollowConsumersData
 * @package Panda\ShopperBundle\DataFixtures\ORM
 */
class LoadFollowConsumersData implements FixtureInterface, OrderedFixtureInterface
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
        /**
         * @var \Panda\ShopperBundle\Entity\Shopper $shopper
         */
        $this->shoppers = $manager->getRepository('PandaShopperBundle:Shopper')->findAll();
        $this->consumers = $manager->getRepository('PandaConsumerBundle:Consumer')->findAll();

        foreach($this->shoppers as $shopper)
        {

            for($i = 0; $i < 5; $i++) {
                $consumer = $this->getRandomConsumer();
                $consumers = $shopper->getFollowConsumers();

                if ($consumers && !$consumers->contains($consumer)) {
                    $consumers->add($consumer);
                } else {
                    $consumers = new ArrayCollection([
                        $consumer
                    ]);
                }

                $shopper->setFollowConsumers($consumers);

                $manager->persist($shopper);
            }
        }

        $manager->flush();
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