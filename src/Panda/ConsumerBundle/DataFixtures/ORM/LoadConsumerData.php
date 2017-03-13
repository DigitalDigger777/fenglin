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
use Panda\ConsumerBundle\Entity\Consumer;
use Panda\ShopperBundle\Entity\Shopper;

/**
 * Class LoadConsumerData
 * @package Panda\ConsumerBundle\DataFixtures\ORM
 */
class LoadConsumerData implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for($i = 0; $i < 10; $i++) {
            $this->loadConsumer($manager);
        }

        $manager->flush();
    }

    /**
     * ES8RCcjWinvNYpyf4IlTqdD8DTZiW4AJgp6OKRZoj2L
     * @param ObjectManager $manager
     */
    private function loadConsumer(ObjectManager $manager)
    {
        $email = 'user' . rand(0, 10000) . '@test.com';
        $apikey = md5($email);

        $consumer = new Consumer();
        $consumer->setEmail($email);
        $consumer->setPassword('');
        $consumer->setApiKey($apikey);
        $consumer->setMemberId(rand(100000, 1000000));
        $consumer->setRole('ROLE_CONSUMER');
        $consumer->setStatus(Consumer::STATUS_ACTIVE);

        $manager->persist($consumer);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}