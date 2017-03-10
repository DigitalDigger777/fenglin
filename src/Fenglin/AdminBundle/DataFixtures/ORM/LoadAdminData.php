<?php
/**
 * Created by PhpStorm.
 * User: korman
 * Date: 23.01.17
 * Time: 14:17
 */

namespace Fenglin\AdminBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Fenglin\AdminBundle\Entity\Admin;
use Panda\ShopperBundle\Entity\Shopper;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadAdminData
 * @package Fenglin\AdminBundle\DataFixtures\ORM
 */
class LoadAdminData implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadAdmin($manager);
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     */
    private function loadAdmin(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.password_encoder');
        $email = 'admin' . rand(0, 1000) . '@test.com';
        $apiKey = md5($email);
        $memberId = crc32($apiKey);

        $admin = new Admin();
        $password = $encoder->encodePassword($admin, '1demo!');

        $admin->setEmail('admin' . rand(0, 1000) . '@test.com');
        $admin->setApiKey($apiKey);
        $admin->setMemberId($memberId);
        $admin->setPassword($password);
        $admin->setTel('+190017777'.rand(10,99));
        $admin->setStatus(Admin::STATUS_ACTIVE);
        $admin->setRole('ROLE_ADMIN');
        $manager->persist($admin);
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
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