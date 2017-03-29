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
     * @var float
     */
    private $totalCashBack;

    /**
     * @var int
     */
    private $consumerId;

    /**
     * @var int
     */
    private $shopperId;

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

    /**
     * @return float
     */
    public function getTotalCashBack()
    {
        return $this->totalCashBack;
    }

    /**
     * @param float $totalCashBack
     */
    public function setTotalCashBack($totalCashBack)
    {
        $this->totalCashBack = $totalCashBack;
    }

    /**
     * @return int
     */
    public function getConsumerId()
    {
        return $this->consumerId;
    }

    /**
     * @param int $consumerId
     */
    public function setConsumerId($consumerId)
    {
        $this->consumerId = $consumerId;
    }

    /**
     * @return int
     */
    public function getShopperId()
    {
        return $this->shopperId;
    }

    /**
     * @param int $shopperId
     */
    public function setShopperId($shopperId)
    {
        $this->shopperId = $shopperId;
    }
}

