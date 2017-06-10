<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Text\Builder;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Text\Builder\AsciiFactory;

class AsciiFactoryTest extends BaseTest
{
    public function testCreate()
    {
        $char = 'a';
        $charCode = 97;

        $actual = AsciiFactory::create($char);
        $this->assertEquals($char, $actual->getChar());
        $this->assertEquals($charCode, $actual->getByte()->getInt());
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function testFailCreate()
    {
        AsciiFactory::create('test');
    }
}
