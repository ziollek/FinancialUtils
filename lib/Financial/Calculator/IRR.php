<?php

namespace Financial\Calculator;

use Financial\Math\NewtonRaphsonMethod;
use Financial\Model\CashFlowEntity;
use Financial\Model\Investment;
use Financial\Util\Calendar;
use Financial\Util\FunctionCall;

class IRR implements Calculator
{
    /**
     * @var NewtonRaphsonMethod
     */
    private $newtonRaphsonMethod;

    /**
     * @param NewtonRaphsonMethod $newtonRaphsonMethod
     */
    public function __construct(NewtonRaphsonMethod $newtonRaphsonMethod)
    {
        $this->newtonRaphsonMethod = $newtonRaphsonMethod;
    }

    /**
     * @param Investment $investment
     *
     * @return float
     */
    public function calculate(Investment $investment)
    {
        $lastPeriod = false;
        $old = false;
        foreach ($investment->getCashFlow() as $payment) {
            if ($old !== false) {
                if ($lastPeriod!== false && $lastPeriod != ($payment->getDayOffset() - $old)) {
                    throw new \RuntimeException(
                        'Cash flow periods are not equals - irr cannot be properly computed ('.$lastPeriod.')'
                    );
                }
                $lastPeriod = $payment->getDayOffset() - $old;
            }
            $old = $payment->getDayOffset();
        }
        return Calculator::PERCENT_MULTIPLIER * $this->newtonRaphsonMethod->calculate(
            $this->prepareFx($investment), $this->prepareDx($investment), 0
        );
    }

    /**
     * @param Investment $investment
     *
     * @return FunctionCall
     */
    private function prepareFx(Investment $investment)
    {
        return new FunctionCall(function ($i) use ($investment) {
            $result = 0;
            $periodCount = 0;
            foreach ($investment->getCashFlow() as $payment) {
                $exponential = -$periodCount;
                $periodCount++;

                if ($payment->getType() == CashFlowEntity::TYPE_REVENUE) {
                    $result -= $payment->getValue() * pow(1 + $i, $exponential);
                } else {
                    $result += $payment->getValue() * pow(1 + $i, $exponential);
                }
            }
            return $result;
        });
    }

    /**
     * @param Investment $investment
     *
     * @return FunctionCall
     */
    private function prepareDx(Investment $investment)
    {
        return new FunctionCall(function ($i) use ($investment) {
            $result = 0;
            $periodCount = 0;
            foreach ($investment->getCashFlow() as $payment) {
                $exponential = -$periodCount;
                $periodCount++;
                if ($payment->getType() == CashFlowEntity::TYPE_REVENUE) {
                    $result -= $exponential * $payment->getValue() * pow(1 + $i, $exponential - 1);
                } else {
                    $result += $exponential * $payment->getValue() * pow(1 + $i, $exponential - 1);
                }
            }
            return $result;
        });
    }


}