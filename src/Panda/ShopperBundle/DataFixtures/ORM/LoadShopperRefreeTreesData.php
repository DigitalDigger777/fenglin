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
use Fenglin\FenglinBundle\Entity\RefreeTree;
use Panda\ShopperBundle\Entity\Shopper;

class LoadShopperRefreeTreesData implements FixtureInterface, OrderedFixtureInterface
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
                $referalConsumer = $this->getRandomReferalConsumer($consumer);

                $refreeTree = new RefreeTree();
                $refreeTree->setShopper($shopper);
                $refreeTree->setConsumer($consumer);
                $refreeTree->setReferalConsumer($referalConsumer);

                $manager->persist($refreeTree);
            }
        }

        $manager->flush();
    }


    /**
     * @param $consumer
     * @return mixed|null
     */
    private function getRandomReferalConsumer($consumer)
    {
        $id = $consumer->getId();
        $count = count($this->consumers);
        $referalConsumer = $this->consumers[rand(0, $count - 1)];

        while($id == $referalConsumer->getId()) {
            $referalConsumer = $this->consumers[rand(0, $count - 1)];
        }

        return $referalConsumer;
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