<?php

namespace Financial\Tests\Calculator;

use Financial\Calculator\APR;
use Financial\Calculator\IRR;
use Financial\Math\NewtonRaphsonMethod;
use Financial\Model\CreditDefinitionEqualInstallments;
use Financial\Model\Investment;
use Financial\Util\Calendar;

/**
 * @coversDefaultClass  Financial\Calculator\IRR
 */
class IRRTest extends \PHPUnit_Framework_TestCase
{

    public function investmentDataProvider()
    {
        return array(
            array(new CreditDefinitionEqualInstallments(new Calendar()), 0.0),
            array($this->getCredit(1, 0, 100, 100, 0, Calendar::FREQUENCY_MONTH), 0.0),
            array($this->getCredit(1, 0, 200, 100, 0, Calendar::FREQUENCY_MONTH), 100.0),
            array($this->getCredit(2, 0, 55, 100, 0, Calendar::FREQUENCY_MONTH), 6.6),
            array($this->getCredit(2, 0, 55, 100, 0, Calendar::FREQUENCY_YEAR), 6.6),
            array($this->getCredit(8, 0, 15, 100, 0, Calendar::FREQUENCY_YEAR), 4.24),
        );
    }

    /**
     * @param Investment $investment
     *
     * @test
     * @covers ::calculate
     * @dataProvider investmentDataProvider
     */
    public function testCalculate(Investment $investment, $expectedResult)
    {
        $irrCalculator = new IRR(new NewtonRaphsonMethod());
        $this->assertSame($expectedResult, round($irrCalculator->calculate($investment), 2));
    }

    /**
     * @test
     * @covers ::calculate
     */
    public function shouldThrowExceptionIfCashFlowHasNotRegularPeriod()
    {
        $irrCalculator = new IRR(new NewtonRaphsonMethod());
        $this->setExpectedException('RuntimeException');
        $irrCalculator->calculate($this->getCredit(2, 1, 60, 100, 10, Calendar::FREQUENCY_WEEK));
    }

    private function getCredit(
        $installmentsCount, $installmentsDelay, $installmentValue, $borrowedAmount, $extraCost, $frequency
    ) {
        $credit = new CreditDefinitionEqualInstallments(new Calendar());
        $credit->setInstallmentsCount($installmentsCount);
        $credit->setDelay($installmentsDelay);
        $credit->setInstallmentValue($installmentValue);
        $credit->setBorrowedAmount($borrowedAmount);
        $credit->setOtherCosts($extraCost);
        $credit->setInstallmentsFrequency($frequency);
        return $credit;
    }
}
