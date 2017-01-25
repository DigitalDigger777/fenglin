<?php

namespace Fenglin\FenglinBundle\Entity;

/**
 * RefreeTree
 */
class RefreeTree
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \Panda\ShopperBundle\Entity\Shopper
     */
    private $shopper;

    /**
     * @var \Panda\ConsumerBundle\Entity\Consumer
     */
    private $consumer;

    /**
     * @var \Panda\ConsumerBundle\Entity\Consumer
     */
    private $referalConsumer;

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
     * @return \Panda\ConsumerBundle\Entity\Consumer
     */
    public function getReferalConsumer()
    {
        return $this->referalConsumer;
    }

    /**
     * @param \Panda\ConsumerBundle\Entity\Consumer $referalConsumer
     */
    public function setReferalConsumer($referalConsumer)
    {
        $this->referalConsumer = $referalConsumer;
    }
}

