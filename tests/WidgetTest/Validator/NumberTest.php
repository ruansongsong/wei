<?php

namespace WidgetTest\Validator;

class NumberTest extends TestCase
{
    /**
     * @dataProvider providerForNumber
     */
    public function testNumber($input)
    {
        $this->assertTrue($this->isNumber($input));
    }

    /**
     * @dataProvider providerForNotNumber
     */
    public function testNotNumber($input)
    {
        $this->assertFalse($this->isNumber($input));
    }

    public function providerForNumber()
    {
        return array(
            array('1234567'),
            array('123456789'),
            array('1.1'),
            array(2.0)
        );
    }

    public function providerForNotNumber()
    {
        return array(
            array('012345-1234567890'),
            array('not number'),
            array('0.1a'),
        );
    }
}
