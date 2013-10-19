<?php

namespace Financial\Model;

use Financial\Util\Calendar;

class CreditDefinitionEqualInstallments extends AbsCreditDefinition {

    protected $installmentValue = 0;

    /**
     * @var Calendar
     */
    private $calendar;

    public function __construct(Calendar $calendar)
    {
        $this->calendar = $calendar;
    }


    /**
     * @param float $installmentValue
     */
    public function setInstallmentValue($installmentValue)
    {
        $this->installmentValue = $installmentValue;
    }

    /**
     * @return float
     */
    public function getInstallmentValue()
    {
        return $this->installmentValue;
    }

    /**
     * @return float
     */
    public function getTotalCost()
    {
        return $this->getInstallmentValue() * $this->getInstallmentsCount() + $this->getNoInstallmentsCost();
    }

    /**
     * @return float
     */
    public function getInstallmentValueByNo($installmentNo)
    {
        if ($installmentNo >= 1 && $installmentNo <= $this->getInstallmentsCount()) {
            return $this->getInstallmentValue();
        }
        return 0.0;
    }

    /**
     * @return CashFlowEntity[]
     */
    public function getCashFlow()
    {
        $result = array(new CashFlowEntity(CashFlowEntity::TYPE_PAYOUT, $this->getBorrowedAmount(), 0));
        $result[] = new CashFlowEntity(CashFlowEntity::TYPE_PAYMENT, $this->getNoInstallmentsCost(), 0);
        $daysOffset = $this->calendar->getDaysByFrequency($this->getInstallmentsFrequency());
        for($i = 1; $i <= $this->getInstallmentsCount(); $i++) {
            $result[] = new CashFlowEntity(
                CashFlowEntity::TYPE_PAYMENT,
                $this->getInstallmentValue(),
                $this->getDelay() + $i * $daysOffset
            );
        }

        return $result;
    }

}