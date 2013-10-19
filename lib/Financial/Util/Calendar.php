<?php

namespace Financial\Util;

class Calendar
{
    const DAY_OF_YEAR = 365;
    const DAY_OF_WEEK = 7;
    const DAY_OF_MONTH = 30;
    const MONTH_OF_YEAR = 12;

    const FREQUENCY_DAY  = 1;
    const FREQUENCY_WEEK = 2;
    const FREQUENCY_MONTH = 3;
    const FREQUENCY_YEAR = 4;


    /**
     * @param int $frequency
     *
     * @return float
     * @throws \RuntimeException
     */
    public function getYearEventsByFrequency($frequency)
    {
        switch ($frequency) {
            case Calendar::FREQUENCY_DAY:
                return Calendar::DAY_OF_YEAR;
            case Calendar::FREQUENCY_WEEK:
                return Calendar::DAY_OF_YEAR / Calendar::DAY_OF_WEEK;
            case Calendar::FREQUENCY_MONTH:
                return Calendar::MONTH_OF_YEAR;
            case Calendar::FREQUENCY_YEAR:
                return 1;
            default:
                throw new \RuntimeException('Frequency type not known '.$frequency);
        }
    }

    /**
     * @param int $frequency
     *
     * @return float
     * @throws \RuntimeException
     */
    public function getDaysByFrequency($frequency)
    {
        switch ($frequency) {
            case Calendar::FREQUENCY_DAY:
                return 1;
            case Calendar::FREQUENCY_WEEK:
                return Calendar::DAY_OF_WEEK;
            case Calendar::FREQUENCY_MONTH:
                return Calendar::DAY_OF_YEAR / Calendar::MONTH_OF_YEAR;
            case Calendar::FREQUENCY_YEAR:
                return Calendar::DAY_OF_YEAR;
            default:
                throw new \RuntimeException('Frequency type not known '.$frequency);
        }
    }

}