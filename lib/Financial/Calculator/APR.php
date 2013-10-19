<?php

namespace Financial\Calculator;

use Financial\Math\NewtonRaphsonMethod;
use Financial\Model\AbsCreditDefinition;
use Financial\Model\CashFlowEntity;
use Financial\Util\Calendar;
use Financial\Util\FunctionCall;

class APR
{
    const PERCENT_MULTIPLIER = 100.0;

    /**
     * @var Calendar
     */
    private $calendar;

    /**
     * @var NewtonRaphsonMethod
     */
    private $newtonRaphsonMethod;

    /**
     * @param Calendar $calendar
     */
    public function __construct(Calendar $calendar, NewtonRaphsonMethod $newtonRaphsonMethod)
    {
        $this->calendar = $calendar;
        $this->newtonRaphsonMethod = $newtonRaphsonMethod;
    }


    /**
     * @param AbsCreditDefinition $credit
     */
    public function calculate(AbsCreditDefinition $credit) {
        return self::PERCENT_MULTIPLIER * $this->newtonRaphsonMethod->calculate(
            $this->prepareFx($credit), $this->prepareDx($credit), 0
        );
    }

    /**
     * @param AbsCreditDefinition $credit
     *
     * @return FunctionCall
     */
    public function prepareFx(AbsCreditDefinition $credit)
    {
        return new FunctionCall(function ($i) use ($credit) {
            $result = 0;
            foreach ($credit->getCashFlow() as $payment) {
                $exponential = -$payment->getDayOffset() / Calendar::DAY_OF_YEAR;

                if ($payment->getType() == CashFlowEntity::TYPE_PAYOUT) {
                    $result -= $payment->getValue() * pow(1 + $i, $exponential);
                } else {
                    $result += $payment->getValue() * pow(1 + $i, $exponential);
                }
            }
            return $result;
        });
    }

    /**
     * @param AbsCreditDefinition $credit
     *
     * @return FunctionCall
     */
    public function prepareDx(AbsCreditDefinition $credit)
    {
        return new FunctionCall(function ($i) use ($credit) {
            $result = 0;
            foreach ($credit->getCashFlow() as $payment) {
                $exponential = -$payment->getDayOffset() / Calendar::DAY_OF_YEAR;
                if ($payment->getType() == CashFlowEntity::TYPE_PAYOUT) {
                    $result -= $exponential * $payment->getValue() * pow(1 + $i, $exponential - 1);
                } else {
                    $result += $exponential * $payment->getValue() * pow(1 + $i, $exponential - 1);
                }
            }
            return $result;
        });
    }
}