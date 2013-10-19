<?php

namespace Financial\Tests\Util;

use Financial\Util\FunctionCall;

/**
 * @coversDefaultClass  Financial\Math\FunctionalCall
 */
class FunctionCallTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @test
     *
     * @covers ::run
     */
    public function testRun()
    {
        $functionCall = new FunctionCall('strlen');

        $this->assertSame(strlen('teststring'), $functionCall->run('teststring'));
    }
}
