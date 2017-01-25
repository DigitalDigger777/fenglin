<?php

namespace Fenglin\CashBackBundle\Entity;

/**
 * CashBack
 */
class CashBack
{
    const STATUS_NEW     = 1;
    const STATUS_CONFIRM = 2;
    const STATUS_DECLINE = 0;

    /**
     * @var int
     */
    private $id;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var float
     */
    private $amountLevel2;

    /**
     * @var float
     */
    private $amountLevel3;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var int
     */
    private $status;

    /**
     * @var \Panda\ConsumerBundle\Entity\Consumer
     */
    private $consumer;

    /**
     * @var \Panda\ShopperBundle\Entity\Shopper
     */
    private $shopper;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $logItems;

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
     * @return CashBack
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
     * Set amountLevel2
     *
     * @param float $amountLevel2
     *
     * @return CashBack
     */
    public function setAmountLevel2($amountLevel2)
    {
        $this->amountLevel2 = $amountLevel2;

        return $this;
    }

    /**
     * Get amountLevel2
     *
     * @return float
     */
    public function getAmountLevel2()
    {
        return $this->amountLevel2;
    }

    /**
     * Set amountLevel3
     *
     * @param float $amountLevel3
     *
     * @return CashBack
     */
    public function setAmountLevel3($amountLevel3)
    {
        $this->amountLevel3 = $amountLevel3;

        return $this;
    }

    /**
     * Get amountLevel3
     *
     * @return float
     */
    public function getAmountLevel3()
    {
        return $this->amountLevel3;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return CashBack
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
     * Set status
     *
     * @param integer $status
     *
     * @return CashBack
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
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
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getLogItems()
    {
        return $this->logItems;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $logItems
     */
    public function setLogItems($logItems)
    {
        $this->logItems = $logItems;
    }
}

