<?php

namespace Fenglin\AdminBundle\Entity;
use Panda\UserBundle\Entity\User;

/**
 * Admin
 */
class Admin extends User
{
    /**
     * @var int
     */
    private $id;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

