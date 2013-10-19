<?php


namespace Financial\Tests\Model;

use Financial\Model\CashFlowEntity;
use Financial\Model\CreditDefinitionEqualInstallments;
use Financial\Util\Calendar;

/**
 * @coversDefaultClass  Financial\Model\CreditDefinitionEqualInstallments
 */
class CreditDefinitionEqualInstallmentsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @covers ::getTotalCost
     */
    public function testGetTotalCost()
    {
        $creditDefinitionEqualInstallments = new CreditDefinitionEqualInstallments(new Calendar());
        $creditDefinitionEqualInstallments->setInstallmentsCount(10);
        $creditDefinitionEqualInstallments->setInstallmentValue(100);
        $creditDefinitionEqualInstallments->setCommission(10);
        $creditDefinitionEqualInstallments->setOtherCosts(0.1);
        $creditDefinitionEqualInstallments->setInsurance(100);

        $this->assertSame(1110.1, $creditDefinitionEqualInstallments->getTotalCost());
    }

    /**
     * @covers ::getInstallmentValueByNo
     */
    public function testGetInstallmentValueByNo()
    {
        $creditDefinitionEqualInstallments = new CreditDefinitionEqualInstallments(new Calendar);
        $creditDefinitionEqualInstallments->setInstallmentsCount(2);
        $creditDefinitionEqualInstallments->setInstallmentValue(550);
        $this->assertSame(550, $creditDefinitionEqualInstallments->getInstallmentValueByNo(1));
        $this->assertSame(550, $creditDefinitionEqualInstallments->getInstallmentValueByNo(2));
        $this->assertSame(0.0, $creditDefinitionEqualInstallments->getInstallmentValueByNo(3));
    }

    /**
     * @covers ::getTotalCost
     */
    public function testGetCashFlow()
    {
        $creditDefinitionEqualInstallments = new CreditDefinitionEqualInstallments(new Calendar());
        $creditDefinitionEqualInstallments->setInstallmentsCount(2);
        $creditDefinitionEqualInstallments->setInstallmentValue(550);
        $creditDefinitionEqualInstallments->setBorrowedAmount(1000);
        $creditDefinitionEqualInstallments->setOtherCosts(15);
        $creditDefinitionEqualInstallments->setDelay(20);
        $creditDefinitionEqualInstallments->setInstallmentsFrequency(Calendar::FREQUENCY_WEEK);

        $expectedCashFlow = array(
            new CashFlowEntity(CashFlowEntity::TYPE_REVENUE, 1000, 0),
            new CashFlowEntity(CashFlowEntity::TYPE_INVESTMENT, 15, 0),
            new CashFlowEntity(CashFlowEntity::TYPE_INVESTMENT, 550, 27),
            new CashFlowEntity(CashFlowEntity::TYPE_INVESTMENT, 550, 34),
        );


        $this->assertEquals($expectedCashFlow, $creditDefinitionEqualInstallments->getCashFlow());
    }
}
