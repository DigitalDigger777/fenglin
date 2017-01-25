<?php

namespace Fenglin\FenglinBundle\Entity;

/**
 * ConsumerAmount
 */
class ConsumerAmount
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var float
     */
    private $totalAmount;

    /**
     * @var \Panda\ConsumerBundle\Entity\Consumer
     */
    private $consumer;

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
     * Set totalAmount
     *
     * @param float $totalAmount
     *
     * @return ConsumerAmount
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;

        return $this;
    }

    /**
     * Get totalAmount
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @return \Panda\ConsumerBundle\Entity\Consumer
     */
    public function getConsumer()
    {
        return $this->consumer;
    }

    /**
     * @param \Panda\ConsumerBundle\Entity\Consumer $consumer
     */
    public function setConsumer($consumer)
    {
        $this->consumer = $consumer;
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

