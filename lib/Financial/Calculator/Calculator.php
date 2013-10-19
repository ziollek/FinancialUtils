<?php

namespace Financial\Calculator;

use Financial\Model\Investment;

interface Calculator
{
    const PERCENT_MULTIPLIER = 100.0;

    /**
     * @param Investment $investment
     *
     * @return float
     */
    public function calculate(Investment $investment);
}