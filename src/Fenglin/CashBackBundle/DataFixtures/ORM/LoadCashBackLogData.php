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
use Fenglin\CashBackBundle\Entity\CashBackLog;
use Panda\ConsumerBundle\Entity\Consumer;
use Panda\ShopperBundle\Entity\Shopper;

/**
 * Class LoadCashBackLogData
 * @package Panda\ConsumerBundle\DataFixtures\ORM
 */
class LoadCashBackLogData implements FixtureInterface, OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $cashBacks = $manager->getRepository('FenglinCashBackBundle:CashBack')->findAll();

        foreach($cashBacks as $cashBack) {
            $cashBackLog = $this->loadCashBackLog($cashBack);
            $manager->persist($cashBackLog);
        }

        $manager->flush();
    }

    /**
     * @param $cashBack
     * @return CashBackLog
     */
    private function loadCashBackLog($cashBack)
    {
        $cashBackLog = new CashBackLog();
        $cashBackLog->setCashback($cashBack);
        $cashBackLog->setAction(rand(1, 3));
        $cashBackLog->setDate(new \DateTime());

        return $cashBackLog;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}