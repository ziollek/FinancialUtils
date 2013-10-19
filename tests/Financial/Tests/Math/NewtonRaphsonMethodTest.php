<?php

namespace Financial\Tests\Math;

use Financial\Math\NewtonRaphsonMethod;
use Financial\Util\FunctionCall;

/**
 * @coversDefaultClass  Financial\Math\NewtonRaphsonMethod
 */
class NewtonRaphsonMethodTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @covers ::calculate
     */
    public function testCalculate()
    {
        $fx = new FunctionCall(function($x) {
            return ($x*$x-3*$x+2);
        });

        $dx = new FunctionCall(function($x) {
            return (2*$x - 3);
        });

        $newtonRaphsonMethod = new NewtonRaphsonMethod();

        $firstSquare = $newtonRaphsonMethod->calculate($fx, $dx, 0);
        $secondSquare = $newtonRaphsonMethod->calculate($fx, $dx, 100);

        $this->assertSame(1.0, round($firstSquare, 3));
        $this->assertSame(2.0, round($secondSquare, 3));
    }
}
