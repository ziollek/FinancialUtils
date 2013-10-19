<?php

namespace Financial\Model;

use Financial\Util\Calendar;

abstract class AbsCreditDefinition {
    protected $commission = 0;
    protected $percentageRate = 0;
    protected $borrowedAmount = 0;
    protected $installmentsCount = 0;
    protected $insurance = 0;
    protected $delay = 0;
    protected $installmentsFrequency = Calendar::FREQUENCY_MONTH;
    protected $otherCosts = 0;

    /**
     * @param int $insurance
     */
    public function setInsurance($insurance)
    {
        $this->insurance = $insurance;
    }

    /**
     * @return float
     */
    public function getInsurance()
    {
        return $this->insurance;
    }

    /**
     * @param float $borrowedAmount
     */
    public function setBorrowedAmount($borrowedAmount)
    {
        $this->borrowedAmount = $borrowedAmount;
    }

    /**
     * @return float
     */
    public function getBorrowedAmount()
    {
        return $this->borrowedAmount;
    }

    /**
     * @param float $commission
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;
    }

    /**
     * @return float
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * @param int $installmentsCount
     */
    public function setInstallmentsCount($installmentsCount)
    {
        $this->installmentsCount = $installmentsCount;
    }

    /**
     * @return int
     */
    public function getInstallmentsCount()
    {
        return $this->installmentsCount;
    }

    /**
     * @param float $percentageRate
     */
    public function setPercentageRate($percentageRate)
    {
        $this->percentageRate = $percentageRate;
    }

    /**
     * @return float
     */
    public function getPercentageRate()
    {
        return $this->percentageRate;
    }

    /**
     * @param int $delay
     */
    public function setDelay($delay)
    {
        $this->delay = $delay;
    }

    /**
     * @return int
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * @param int $installmentsFrequency
     */
    public function setInstallmentsFrequency($installmentsFrequency)
    {
        $this->installmentsFrequency = $installmentsFrequency;
    }

    /**
     * @return int
     */
    public function getInstallmentsFrequency()
    {
        return $this->installmentsFrequency;
    }

    /**
     * @param float $otherCosts
     */
    public function setOtherCosts($otherCosts)
    {
        $this->otherCosts = $otherCosts;
    }

    /**
     * @return float
     */
    public function getOtherCosts()
    {
        return $this->otherCosts;
    }

    /**
     * @return int
     */
    public function getSettlementPeriod()
    {
        return $this->getDelay() + $this->getInstallmentsFrequency() * $this->getInstallmentsCount();
    }

    /**
     * @return float
     */
    public function getNoInstallmentsCost()
    {
        return $this->getOtherCosts() + $this->getInsurance() + $this->getCommission();
    }

    /**
     * @return float
     */
    abstract function getTotalCost();

    /**
     * @return float
     */
    abstract function getInstallmentValueByNo($installmentNo);

    /**
     * @return CashFlowEntity[]
     */
    abstract function getCashFlow();

}