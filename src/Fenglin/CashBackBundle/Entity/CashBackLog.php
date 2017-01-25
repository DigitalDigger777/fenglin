<?php

namespace Fenglin\CashBackBundle\Entity;

/**
 * CashBackLog
 */
class CashBackLog
{
    const ACTION_CREATE_NEW = 1;
    const ACTION_CHANGE_STATUS_NEW_TO_DECLINE = 2;
    const ACTION_CHANGE_STATUS_NEW_TO_CONFIRM = 3;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $action;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var \Fenglin\CashBackBundle\Entity\CashBack
     */
    private $cashback;

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
     * Set action
     *
     * @param integer $action
     *
     * @return CashBackLog
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return int
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return CashBackLog
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
     * @return CashBack
     */
    public function getCashback()
    {
        return $this->cashback;
    }

    /**
     * @param CashBack $cashback
     */
    public function setCashback($cashback)
    {
        $this->cashback = $cashback;
    }
}