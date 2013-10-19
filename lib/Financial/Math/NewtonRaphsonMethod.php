<?php

namespace Financial\Math;

use Financial\Util\FunctionCall;

class NewtonRaphsonMethod {

    const PRECISE = 0.0000001;

    /**
     * Implementation Newton–Raphson method
     *
     * compute in loop x_[n+1] = x_n- fx(x_n)/dx(x_n), where fx(x_n)/dx(x_n) < PRECISE
     *
     * @param FunctionCall $fx
     * @param FunctionCall $dx
     * @param float        $initArgument - x_0
     */
    public function calculate(FunctionCall $fx, FunctionCall $dx, $initArgument)
    {
        $currentArgument = $initArgument;
        while (true) {
            $fxResult = $fx->run($currentArgument);
            $dfxResult = $dx->run($currentArgument);

            $nextArgument = $currentArgument;

            if ($dfxResult != 0) {
                $nextArgument -= $fxResult/$dfxResult;
            } else {
                break;
            }

            if ($nextArgument == 0 || abs(($nextArgument - $currentArgument) / $nextArgument)  < NewtonRaphsonMethod::PRECISE) {
                break;
            }


            $currentArgument = $nextArgument;
        }
        return $currentArgument;
    }

}