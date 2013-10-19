<?php

namespace Financial\Tests\Calculator;

use Financial\Calculator\APR;
use Financial\Math\NewtonRaphsonMethod;
use Financial\Model\AbsCreditDefinition;
use Financial\Model\CreditDefinitionEqualInstallments;
use Financial\Util\Calendar;


/**
 * @coversDefaultClass  Financial\Calculator\APR
 */
class APRTest extends \PHPUnit_Framework_TestCase
{

    public function creditsDataProvider()
    {
        return array(
            array(new CreditDefinitionEqualInstallments(new Calendar()), 0.0),
            array($this->getCredit(1, 0, 112, 100, 0, Calendar::FREQUENCY_YEAR), 12.00),
            array($this->getCredit(1, 0, 102, 100, 0, Calendar::FREQUENCY_MONTH), 26.82),
            array($this->getCredit(10, 0, 10.20, 100, 0, Calendar::FREQUENCY_MONTH), 4.43),
            array($this->getCredit(24, 0, 40.0, 400.0, 0, Calendar::FREQUENCY_MONTH), 169.96),
            array($this->getCredit(24, 0, 40.0, 400.0, 10, Calendar::FREQUENCY_MONTH), 179.53),
            array($this->getCredit(30, 0, 55.0, 1000.0, 66, Calendar::FREQUENCY_MONTH), 62.89)
        );
    }

    /**
     * @test
     * @covers ::calculate
     * @dataProvider creditsDataProvider
     */
    public function testCalculate(AbsCreditDefinition $credit, $expectedResult)
    {
        $aprCalculator = new APR(new Calendar(), new NewtonRaphsonMethod());
        $this->assertSame($expectedResult, round($aprCalculator->calculate($credit), 2));
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
