<?php

namespace Fenglin\FenglinBundle\Entity;

/**
 * ConsumerUseCashBack
 */
class ConsumerUseCashBack
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var \DateTime
     */
    private $date;

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
     * Set amount
     *
     * @param float $amount
     *
     * @return ConsumerUseCashBack
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ConsumerUseCashBack
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