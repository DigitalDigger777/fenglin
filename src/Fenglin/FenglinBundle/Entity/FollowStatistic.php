<?php

namespace Fenglin\FenglinBundle\Entity;

/**
 * FollowStatistic
 */
class FollowStatistic
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $countFollow;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \Panda\ShopperBundle\Entity\Shopper
     */
    private $shopper;


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
     * Set countFollow
     *
     * @param integer $countFollow
     *
     * @return FollowStatistic
     */
    public function setCountFollow($countFollow)
    {
        $this->countFollow = $countFollow;

        return $this;
    }

    /**
     * Get countFollow
     *
     * @return int
     */
    public function getCountFollow()
    {
        return $this->countFollow;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return FollowStatistic
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
     * @return \Panda\ShopperBundle\Entity\Shopper
     */
    public function getShopper()
    {
        return $this->shopper;
    }

    /**
     * @param \Panda\ShopperBundle\Entity\Shopper $shopper
     */
    public function setShopper($shopper)
    {
        $this->shopper = $shopper;
    }
}

