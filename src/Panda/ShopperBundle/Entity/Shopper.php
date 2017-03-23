<?php

namespace Panda\ShopperBundle\Entity;

use Panda\UserBundle\Entity\User;

/**
 * Shopper
 */
class Shopper extends User
{

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $logo;

    /**
     * @var string
     */
    private $address;

    /**
     * @var string
     */
    private $tel;

    /**
     * @var float
     */
    private $totalAmount;

    /**
     * @var float
     */
    private $rebate;

    /**
     * @var float
     */
    private $rebateLevelRate;

    /**
     * @var float
     */
    private $rebateLevel2Rate;

    /**
     * @var float
     */
    private $rebateLevel3Rate;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $amountConsumers;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $refreeTrees;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $cashbacks;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $followConsumers;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $consumerUseCashbacks;

    /**
     * @var string
     */
    private $openPassword;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $staffs;

    /**
     * @var string
     */
    private $shedule;

    /**
     * @var string
     */
    private $contactTel;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Shopper
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return Shopper
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Shopper
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set tel
     *
     * @param string $tel
     *
     * @return Shopper
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

    /**
     * Set totalAmount
     *
     * @param float $totalAmount
     *
     * @return Shopper
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
     * Set rebate
     *
     * @param float $rebate
     *
     * @return Shopper
     */
    public function setRebate($rebate)
    {
        $this->rebate = $rebate;

        return $this;
    }

    /**
     * Get rebate
     *
     * @return float
     */
    public function getRebate()
    {
        return $this->rebate;
    }

    /**
     * Set rebateLevelRate
     *
     * @param float $rebateLevelRate
     *
     * @return Shopper
     */
    public function setRebateLevelRate($rebateLevelRate)
    {
        $this->rebateLevelRate = $rebateLevelRate;

        return $this;
    }

    /**
     * Get rebateLevelRate
     *
     * @return float
     */
    public function getRebateLevelRate()
    {
        return $this->rebateLevelRate;
    }

    /**
     * Set rebateLevel2Rate
     *
     * @param float $rebateLevel2Rate
     *
     * @return Shopper
     */
    public function setRebateLevel2Rate($rebateLevel2Rate)
    {
        $this->rebateLevel2Rate = $rebateLevel2Rate;

        return $this;
    }

    /**
     * Get rebateLevel2Rate
     *
     * @return float
     */
    public function getRebateLevel2Rate()
    {
        return $this->rebateLevel2Rate;
    }

    /**
     * Set rebateLevel3Rate
     *
     * @param float $rebateLevel3Rate
     *
     * @return Shopper
     */
    public function setRebateLevel3Rate($rebateLevel3Rate)
    {
        $this->rebateLevel3Rate = $rebateLevel3Rate;

        return $this;
    }

    /**
     * Get rebateLevel3Rate
     *
     * @return float
     */
    public function getRebateLevel3Rate()
    {
        return $this->rebateLevel3Rate;
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
    public function getRefreeTrees()
    {
        return $this->refreeTrees;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $refreeTrees
     */
    public function setRefreeTrees($refreeTrees)
    {
        $this->refreeTrees = $refreeTrees;
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
    public function getFollowConsumers()
    {
        return $this->followConsumers;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $followConsumers
     */
    public function setFollowConsumers($followConsumers)
    {
        $this->followConsumers = $followConsumers;
    }

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
     * @return string
     */
    public function getOpenPassword()
    {
        return $this->openPassword;
    }

    /**
     * @param string $openPassword
     */
    public function setOpenPassword($openPassword)
    {
        $this->openPassword = $openPassword;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getStaffs()
    {
        return $this->staffs;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $staffs
     */
    public function setStaffs($staffs)
    {
        $this->staffs = $staffs;
    }

    /**
     * @return string
     */
    public function getShedule()
    {
        return $this->shedule;
    }

    /**
     * @param string $shedule
     */
    public function setShedule($shedule)
    {
        $this->shedule = $shedule;
    }

    /**
     * @return string
     */
    public function getContactTel()
    {
        return $this->contactTel;
    }

    /**
     * @param string $contactTel
     */
    public function setContactTel($contactTel)
    {
        $this->contactTel = $contactTel;
    }
}

