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

/**
 * Class LoadLevelsData
 * @package Panda\ConsumerBundle\DataFixtures\ORM
 */
class LoadLevelsData implements FixtureInterface, OrderedFixtureInterface
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
        $this->loadLevel2($manager);
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @return array
     */
    public function loadLevel1(ObjectManager $manager)
    {
        /**
         * @var \Doctrine\ORM\QueryBuilder $qb
         */
        $qb = $manager->createQueryBuilder();
        $qb->select('c')
            ->from('FenglinCashBackBundle:CashBack', 'c')
            ->where($qb->expr()->isNotNull('c.payable'));

        return $qb->getQuery()->getResult();
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadLevel2(ObjectManager $manager)
    {
        /**
         * @var \Fenglin\CashBackBundle\Entity\CashBack $item
         * @var \Fenglin\CashBackBundle\Entity\CashBack $cashBackLevel2
         * @var \Fenglin\CashBackBundle\Entity\CashBack $cashBackLevel3
         */
        $refreeTreeRepo = $manager->getRepository('FenglinFenglinBundle:RefreeTree');
        $cashBackRepo = $manager->getRepository('FenglinCashBackBundle:CashBack');

        $cashsBackLevel1 = $this->loadLevel1($manager);

        foreach ($cashsBackLevel1 as $item) {
            $shopper = $item->getShopper();
            $consumer = $item->getConsumer();

            $item->setConsumerPayable($consumer);
            $item->setLevel(1);
            $manager->persist($item);

            $refreeTree = $refreeTreeRepo->findOneBy([
                'shopper'  => $shopper,
                'consumer' => $consumer
            ]);

            if ($refreeTree) {
                $consumerLevel2 = $refreeTree->getReferalConsumer();
                $transactionId = $item->getTransactionId();

                $cashBackLevel2 = $cashBackRepo->findOneBy([
                    'transactionId' => $transactionId,
                    'consumer' => $consumerLevel2
                ]);

                if ($cashBackLevel2) {
                    $cashBackLevel2->setConsumerPayable($consumer);
                    $cashBackLevel2->setLevel(2);
                    $manager->persist($cashBackLevel2);
                }

                $refreeTree = $refreeTreeRepo->findOneBy([
                    'shopper'  => $shopper,
                    'consumer' => $consumerLevel2
                ]);

                if ($refreeTree) {
                    $consumerLevel3 = $refreeTree->getReferalConsumer();

                    $cashBackLevel3 = $cashBackRepo->findOneBy([
                        'transactionId' => $transactionId,
                        'consumer' => $consumerLevel3
                    ]);

                    $cashBackLevel3->setConsumerPayable($consumer);
                    $cashBackLevel3->setLevel(3);
                    $manager->persist($cashBackLevel3);
                }
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
        return 10;
    }
}