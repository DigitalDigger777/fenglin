<?php

namespace Panda\UserBundle\Entity;

/**
 * RequestRecoveryPassword
 */
class RequestRecoveryPassword
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \DateTime
     */
    private $dateExpired;

    /**
     * @var bool
     */
    private $used;

    /**
     * @var string
     */
    private $hash;

    /**
     * @var \Panda\UserBundle\Entity\User
     */
    private $user;

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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return RequestRecoveryPassword
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set dateExpired
     *
     * @param \DateTime $dateExpired
     *
     * @return RequestRecoveryPassword
     */
    public function setDateExpired($dateExpired)
    {
        $this->dateExpired = $dateExpired;

        return $this;
    }

    /**
     * Get dateExpired
     *
     * @return \DateTime
     */
    public function getDateExpired()
    {
        return $this->dateExpired;
    }

    /**
     * Set used
     *
     * @param boolean $used
     *
     * @return RequestRecoveryPassword
     */
    public function setUsed($used)
    {
        $this->used = $used;

        return $this;
    }

    /**
     * Get used
     *
     * @return bool
     */
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * Set hash
     *
     * @param string $hash
     *
     * @return RequestRecoveryPassword
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}

