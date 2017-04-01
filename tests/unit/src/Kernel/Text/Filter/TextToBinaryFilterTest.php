<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Kernel\Text\Filter\TextToBinaryFilter;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class TextToBinaryFilterTest extends BaseTest
{
    /**
     * @var TextToBinaryFilter
     */
    private $filter;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Text\Api\Builder\AsciiFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $asciiFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Text\Api\Data\AsciiInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $asciiMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $byteMock;

    protected function setUp()
    {
        parent::setUp();

        $this->asciiFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\Builder\AsciiFactoryInterface')
            ->getMock();

        $this->asciiMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\Data\AsciiInterface')
            ->getMock();

        $this->byteMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface')
            ->getMock();

        $this->filter = new TextToBinaryFilter($this->asciiFactoryMock);
    }

    /**
     * @dataProvider providerFilter
     *
     * @param string $text
     */
    public function testFilter(string $text)
    {
        $textSplited = str_split($text);
        $binaryContainer = [];
        foreach($textSplited as $item) {
            $binaryContainer[] = sprintf('%08d',  decbin(ord($item)));
        }

        // ascii factory mock
        $this->asciiFactoryMock->expects($this->exactly(strlen($text)))
            ->method('create')
            ->willReturn($this->asciiMock);

        // ascii mock
        $this->asciiMock->expects($this->exactly(count($binaryContainer)))
            ->method('getByte')
            ->willReturn($this->byteMock);

        // byte mock
        $this->byteMock->expects($this->exactly(count($binaryContainer)))
            ->method('getBinary')
            ->willReturnCallback(function() use (&$binaryContainer) {
               $current = current($binaryContainer);
               next($binaryContainer);

               return $current;
            });


        $actual = $this->filter->filter($text);

        $this->assertEquals(implode('', $binaryContainer), $actual);
    }

    public function providerFilter()
    {
        return [
            ['Hello Steganography!'],
        ];
    }
}
