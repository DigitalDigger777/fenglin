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
     * @var string
     */
    private $tel;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Admin
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }
}

