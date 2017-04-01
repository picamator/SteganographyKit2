<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Entity;

use Picamator\SteganographyKit2\Kernel\Pixel\Iterator\SerialIterator;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class SerialIteratorTest extends BaseTest
{
    /**
     * @var SerialIterator
     */
    private $serialIterator;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $channelMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorMock;

    protected function setUp()
    {
        parent::setUp();

        $this->channelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ChannelInterface')
            ->getMock();

        $this->colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface')
            ->getMock();

        $pixelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface')
            ->getMock();

        $pixelMock->method('getColor')
            ->willReturn($this->colorMock);

        $this->serialIterator = new SerialIterator($pixelMock, $this->channelMock);
    }

    public function testIteration()
    {
        $channelList = ['red', 'green', 'blue'];
        $channelMethodList = ['getRed', 'getGreen', 'getBlue'];

        // channel mock
        $this->channelMock->expects($this->atLeastOnce())
            ->method('count')
            ->willReturn(3);

        $this->channelMock->expects($this->atLeastOnce())
            ->method('getChannel')
            ->willReturnCallback(function($index) use ($channelList) {
                return $channelList[$index];
            });

        $this->channelMock->expects($this->atLeastOnce())
            ->method('getMethod')
            ->willReturnCallback(function($index) use ($channelMethodList) {
                return $channelMethodList[$index];
            });

        // byte mock
        $byteMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface')
            ->getMock();

        // color mock
        $this->colorMock->expects($this->once())
            ->method('getRed')
            ->willReturn($byteMock);

        $this->colorMock->expects($this->once())
            ->method('getGreen')
            ->willReturn($byteMock);

        $this->colorMock->expects($this->once())
            ->method('getBlue')
            ->willReturn($byteMock);

        $iterator = new \ArrayIterator(['red', 'green', 'blue']);
        $multipleIterator = new \MultipleIterator(\MultipleIterator::MIT_NEED_ALL|\MultipleIterator::MIT_KEYS_ASSOC);
        $multipleIterator->attachIterator($this->serialIterator, 'actual');
        $multipleIterator->attachIterator($iterator, 'expected');

        foreach ($multipleIterator as $item) {
            $this->assertEquals($item['expected'], $this->serialIterator->key());
            $this->assertInstanceOf('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface', $item['actual']);
        }
    }
}
