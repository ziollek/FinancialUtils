<?php

namespace Financial\Tests\Util;

use Financial\Util\Calendar;

/**
 * @coversDefaultClass  Financial\Math\Calendar
 */
class CalendarTest extends \PHPUnit_Framework_TestCase
{
    public function frequencyDataProvider()
    {
        return array(
            array(Calendar::FREQUENCY_DAY, 365),
            array(Calendar::FREQUENCY_WEEK, 52.142857142857),
            array(Calendar::FREQUENCY_MONTH, 12),
            array(Calendar::FREQUENCY_YEAR, 1),
        );
    }

    public function frequencyDayDataProvider()
    {
        return array(
            array(Calendar::FREQUENCY_DAY, 1),
            array(Calendar::FREQUENCY_WEEK, 7),
            array(Calendar::FREQUENCY_MONTH, 30.416666666667),
            array(Calendar::FREQUENCY_YEAR, 365),
        );
    }

    /**
     * @param int   $frequency
     * @param float $expectedCount
     *
     * @test
     * @covers ::getYearEventsByFrequency
     * @dataProvider frequencyDataProvider
     */
    public function shouldGetYearEventsByFrequency($frequency, $expectedCount)
    {
        $calendar = new Calendar();

        $this->assertSame($expectedCount, $calendar->getYearEventsByFrequency($frequency));
    }

    /**
     *
     * @test
     * @covers ::getYearEventsByFrequency
     */
    public function shouldThrowExceptionWhileGetYearEventsIfFrequencyIsNotKnown()
    {
        $calendar = new Calendar();

        $this->setExpectedException('\RuntimeException');
        $calendar->getYearEventsByFrequency(666);
    }

    /**
     * @param int   $frequency
     * @param float $expectedCount
     *
     * @test
     * @covers ::getDaysByFrequency
     * @dataProvider frequencyDayDataProvider
     */
    public function shouldGetDaysByFrequency($frequency, $expectedCount)
    {
        $calendar = new Calendar();

        $this->assertSame($expectedCount, $calendar->getDaysByFrequency($frequency));
    }

    /**
     *
     * @test
     * @covers ::getDaysByFrequency
     */
    public function shouldThrowExceptionWhileGetDaysIfFrequencyIsNotKnown()
    {
        $calendar = new Calendar();

        $this->setExpectedException('\RuntimeException');
        $calendar->getDaysByFrequency(666);
    }
}
