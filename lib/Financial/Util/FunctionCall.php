<?php


namespace Financial\Util;


class FunctionCall {

    private $callback;

    public function __construct($callback)
    {
        $this->callback = $callback;
    }

    public function run($argument) {
        return call_user_func($this->callback, $argument);
    }
}