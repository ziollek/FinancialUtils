<?php


namespace Financial\Model;


interface Investment {

    /**
     * @return CashFlowEntity[]
     */
    public function getCashFlow();
}