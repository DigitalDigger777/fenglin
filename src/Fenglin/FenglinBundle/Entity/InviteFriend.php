<?php

namespace Fenglin\FenglinBundle\Entity;

/**
 * InviteFriend
 */
class InviteFriend
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var \Panda\ConsumerBundle\Entity\Consumer
     */
    private $consumerFrom;

    /**
     * @var \Panda\ConsumerBundle\Entity\Consumer
     */
    private $consumerTo;

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
     * @return \Panda\ConsumerBundle\Entity\Consumer
     */
    public function getConsumerFrom()
    {
        return $this->consumerFrom;
    }

    /**
     * @param \Panda\ConsumerBundle\Entity\Consumer $consumerFrom
     */
    public function setConsumerFrom($consumerFrom)
    {
        $this->consumerFrom = $consumerFrom;
    }

    /**
     * @return \Panda\ConsumerBundle\Entity\Consumer
     */
    public function getConsumerTo()
    {
        return $this->consumerTo;
    }

    /**
     * @param \Panda\ConsumerBundle\Entity\Consumer $consumerTo
     */
    public function setConsumerTo($consumerTo)
    {
        $this->consumerTo = $consumerTo;
    }
}

