<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Text\Filter;

use Picamator\SteganographyKit2\Kernel\Text\Iterator\SerialBitwiseIterator;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class SerialBitwiseIteratorTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Kernel\Text\Api\TextInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $textMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Text\Api\AsciiFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
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

        $this->textMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\TextInterface')
            ->getMock();

        $this->asciiFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\AsciiFactoryInterface')
            ->getMock();

        $this->asciiMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\Data\AsciiInterface')
            ->getMock();

        $this->byteMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface')
            ->getMock();
    }

    public function testIterator()
    {
        $charBinary = '01110100';
        $text = 'a';

        // text mock
        $this->textMock->expects($this->once())
            ->method('getCountBit')
            ->willReturn(8);

        $this->textMock->expects($this->once())
            ->method('getText')
            ->willReturn($text);

        // ascii factory mock
        $this->asciiFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->asciiMock);

        // ascii mock
        $this->asciiMock->expects($this->once())
            ->method('getByte')
            ->willReturn($this->byteMock);

        // byte mock
        $this->byteMock->expects($this->once())
            ->method('getBinary')
            ->willReturn($charBinary);

        $serialIterator = new SerialBitwiseIterator($this->textMock, $this->asciiFactoryMock, $text);
        $iterator = new \ArrayIterator(str_split($charBinary));

        $multipleIterator = new \MultipleIterator(\MultipleIterator::MIT_NEED_ALL|\MultipleIterator::MIT_KEYS_ASSOC);
        $multipleIterator->attachIterator($serialIterator, 'actual');
        $multipleIterator->attachIterator($iterator, 'expected');

        foreach($multipleIterator as $item) {
            $this->assertEquals($item['expected'], $item['actual']);
        }
    }
}
