<?php
/**
 * Created by PhpStorm.
 * User: korman
 * Date: 23.01.17
 * Time: 14:17
 */

namespace Panda\ConsumerBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Fenglin\FenglinBundle\Entity\InviteFriend;

/**
 * Class LoadInviteFriendsData
 * @package Panda\ConsumerBundle\DataFixtures\ORM
 */
class LoadInviteFriendsData implements FixtureInterface, OrderedFixtureInterface
{
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
        $this->consumers = $manager->getRepository('PandaConsumerBundle:Consumer')->findAll();

        foreach($this->consumers as $consumer)
        {
            $consumerTo = $this->getRandomConsumer();
            $inviteFriend = new InviteFriend();
            $inviteFriend->setConsumerFrom($consumer);
            $inviteFriend->setConsumerTo($consumerTo);

            $manager->persist($inviteFriend);
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