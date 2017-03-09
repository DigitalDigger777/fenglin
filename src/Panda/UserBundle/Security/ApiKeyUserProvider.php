<?php
/**
 * Created by PhpStorm.
 * User: korman
 * Date: 28.07.16
 * Time: 19:40
 */

namespace Panda\UserBundle\Security;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class ApiKeyUserProvider implements UserProviderInterface
{
    /**
     * @var EntityManager
     */
    private $em;

    function __construct(EntityManager $em)
    {
        $this->em = $em;

    }

    /**
     * Get username for api key
     *
     * @param $apiKey
     * @return null|string
     */
    public function getUsernameForApiKey($apiKey)
    {

        /**
         * @var \Panda\UserBundle\Entity\User $user
         */
        $userRepo = $this->em->getRepository('PandaUserBundle:User');

        $user = $userRepo->findOneBy([
            'apiKey' => $apiKey
        ]);

        if ($user) {
            return $user->getEmail();
        } else {
            return null;
        }
    }

    /**
     * Load user by name.
     *
     * @param string $username
     * @return User
     */
    public function loadUserByUsername($username)
    {

        /**
         * @var \Panda\UserBundle\Entity\User $user
         */
        $userRepo = $this->em->getRepository('PandaUserBundle:User');
        $user = $userRepo->findOneBy([
            'email' => $username
        ]);

        return new User(
            $user->getEmail(),
            $user->getPassword(),
            $user->getRoles()
        );
    }


    /**
     * Refresh user.
     *
     * @param UserInterface $user
     * @return \Exception
     */
    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    /**
     * Support class
     *
     * @param string $class
     * @return bool
     */
    public function supportsClass($class)
    {
        return 'Symfony\Component\Security\Core\User\User' === $class;
    }

}