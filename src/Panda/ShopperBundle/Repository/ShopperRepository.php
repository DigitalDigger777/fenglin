<?php

namespace Panda\ShopperBundle\Repository;
use Doctrine\ORM\Query;

/**
 * ShopperRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ShopperRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @var \Panda\ShopperBundle\Entity\Shopper | null
     */
    private $shopper = null;

    /**
     * @param $email
     * @param bool $chain
     * @return null|object|\Panda\ShopperBundle\Entity\Shopper|ShopperRepository
     */
    public function findByEmail($email, $chain = false)
    {
        $this->shopper = $this->findOneBy([
            'email' => $email
        ]);

        return $chain ? $this : $this->shopper;
    }

    /**
     * @param $apiKey
     * @param bool $chain
     * @return null|object|\Panda\ShopperBundle\Entity\Shopper|ShopperRepository
     */
    public function findByApiKey($apiKey, $chain = false)
    {
        $this->shopper = $this->findOneBy([
            'apiKey' => $apiKey
        ]);

        return $chain ? $this : $this->shopper;
    }

    /**
     * @param $shopperId
     * @param $consumerId
     * @return mixed
     */
    public function checkJoinToConsumer($shopperId, $consumerId)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('COUNT(s)')
            ->from('PandaShopperBundle:Shopper', 's')
            ->join('s.followConsumers', 'c')
            ->where($qb->expr()->andX(
                $qb->expr()->eq('c.id', ':consumerId'),
                $qb->expr()->eq('s.id', ':shopperId')
            ))
            ->setParameter(':consumerId', $consumerId)
            ->setParameter(':shopperId', $shopperId);

        $result = $qb->getQuery()->getSingleScalarResult();

        return $result;
    }

    /**
     * @param $apikey
     * @return mixed
     */
    public function getTotalSpent($apikey)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('SUM(c.spent)')
            ->from('PandaShopperBundle:Shopper', 's')
            ->join('s.cashbacks', 'c')
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->eq('s.apiKey', ':apikey'),
                    $qb->expr()->eq('c.level', ':level')
                )
            )
            ->setParameter(':apikey', $apikey)
            ->setParameter(':level', 1);

        $result = $qb->getQuery()->getSingleScalarResult();

        return $result;
    }

    /**
     * @param $apikey
     * @return mixed
     */
    public function getTodayMemberConsumed($apikey)
    {
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');


        $date = new \DateTime('2017-04-03');
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('COUNT(c)')
            ->from('PandaShopperBundle:Shopper', 's')
            ->join('s.cashbacks', 'c')
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->eq('s.apiKey', ':apikey'),
                    $qb->expr()->eq('c.level', ':level'),
                    $qb->expr()->eq('YEAR(c.date)', ':year'),
                    $qb->expr()->eq('MONTH(c.date)', ':month'),
                    $qb->expr()->eq('DAY(c.date)', ':day')
                )
            )
            ->setParameter(':apikey', $apikey)
            ->setParameter(':level', 1)
            ->setParameter(':year', $year)
            ->setParameter(':month', $month)
            ->setParameter(':day', $day);

        $result = $qb->getQuery()->getSingleScalarResult();

        return $result;
    }

    /**
     * @param $apikey
     * @return mixed
     */
    public function getTodayConsumed($apikey)
    {
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');


        $date = new \DateTime('2017-04-03');
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('SUM(c.spent)')
            ->from('PandaShopperBundle:Shopper', 's')
            ->join('s.cashbacks', 'c')
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->eq('s.apiKey', ':apikey'),
                    $qb->expr()->eq('c.level', ':level'),
                    $qb->expr()->eq('YEAR(c.date)', ':year'),
                    $qb->expr()->eq('MONTH(c.date)', ':month'),
                    $qb->expr()->eq('DAY(c.date)', ':day')
                )
            )
            ->setParameter(':apikey', $apikey)
            ->setParameter(':level', 1)
            ->setParameter(':year', $year)
            ->setParameter(':month', $month)
            ->setParameter(':day', $day);

        $result = $qb->getQuery()->getSingleScalarResult();

        return $result;
    }

    /**
     * @param $apikey
     * @return mixed
     */
    public function getTodayCashback($apikey)
    {
        $emConfig = $this->getEntityManager()->getConfiguration();
        $emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
        $emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
        $emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');


        $date = new \DateTime('2017-04-03');
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');

        $h = fopen('fenglin.log', 'a+');
        fwrite($h, $year . '|' . $month . '|' . $day);
        fclose($h);

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('SUM(c.amount)')
            ->from('PandaShopperBundle:Shopper', 's')
            ->join('s.cashbacks', 'c')
            ->where(
                $qb->expr()->andX(
                    $qb->expr()->eq('s.apiKey', ':apikey'),
                    $qb->expr()->eq('c.level', ':level'),
                    $qb->expr()->eq('YEAR(c.date)', ':year'),
                    $qb->expr()->eq('MONTH(c.date)', ':month'),
                    $qb->expr()->eq('DAY(c.date)', ':day')
                )
            )
            ->setParameter(':apikey', $apikey)
            ->setParameter(':level', 1)
            ->setParameter(':year', $year)
            ->setParameter(':month', $month)
            ->setParameter(':day', $day);

        $result = $qb->getQuery()->getSingleScalarResult();

        return $result;
    }
}
