<?php

namespace Panda\ConsumerBundle\Entity;
use Panda\UserBundle\Entity\User;

/**
 * Consumer
 */
class Consumer extends User
{

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $consumerUseCashbacks;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $cashbacks;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $inviteFreindConsumersFrom;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $inviteFreindConsumersTo;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $refreeTreeConsumers;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $refreeTreeReferalConsumers;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $amountConsumers;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $followShoppers;


    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getConsumerUseCashbacks()
    {
        return $this->consumerUseCashbacks;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $consumerUseCashbacks
     */
    public function setConsumerUseCashbacks($consumerUseCashbacks)
    {
        $this->consumerUseCashbacks = $consumerUseCashbacks;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getCashbacks()
    {
        return $this->cashbacks;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $cashbacks
     */
    public function setCashbacks($cashbacks)
    {
        $this->cashbacks = $cashbacks;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getInviteFreindConsumersFrom()
    {
        return $this->inviteFreindConsumersFrom;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $inviteFreindConsumersFrom
     */
    public function setInviteFreindConsumersFrom($inviteFreindConsumersFrom)
    {
        $this->inviteFreindConsumersFrom = $inviteFreindConsumersFrom;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getInviteFreindConsumersTo()
    {
        return $this->inviteFreindConsumersTo;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $inviteFreindConsumersTo
     */
    public function setInviteFreindConsumersTo($inviteFreindConsumersTo)
    {
        $this->inviteFreindConsumersTo = $inviteFreindConsumersTo;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getRefreeTreeConsumers()
    {
        return $this->refreeTreeConsumers;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $refreeTreeConsumers
     */
    public function setRefreeTreeConsumers($refreeTreeConsumers)
    {
        $this->refreeTreeConsumers = $refreeTreeConsumers;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getRefreeTreeReferalConsumers()
    {
        return $this->refreeTreeReferalConsumers;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $refreeTreeReferalConsumers
     */
    public function setRefreeTreeReferalConsumers($refreeTreeReferalConsumers)
    {
        $this->refreeTreeReferalConsumers = $refreeTreeReferalConsumers;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getAmountConsumers()
    {
        return $this->amountConsumers;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $amountConsumers
     */
    public function setAmountConsumers($amountConsumers)
    {
        $this->amountConsumers = $amountConsumers;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getFollowShoppers()
    {
        return $this->followShoppers;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $followShoppers
     */
    public function setFollowShoppers($followShoppers)
    {
        $this->followShoppers = $followShoppers;
    }
}

