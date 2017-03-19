<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Entity;

use Picamator\SteganographyKit2\Kernel\Entity\Iterator\SerialBytewiseIterator;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class SerialBytewiseIteratorTest extends BaseTest
{
    /**
     * @var SerialBytewiseIterator
     */
    private $serialIterator;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $channelMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorMock;

    protected function setUp()
    {
        parent::setUp();

        $this->channelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface')
            ->getMock();

        $this->colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface')
            ->getMock();

        $pixelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface')
            ->getMock();

        $pixelMock->method('getColor')
            ->willReturn($this->colorMock);

        $this->serialIterator = new SerialBytewiseIterator($pixelMock, $this->channelMock);
    }

    public function testIteration()
    {
        // channel mock
        $this->channelMock->expects($this->atLeastOnce())
            ->method('count')
            ->willReturn(3);

        $this->channelMock->expects($this->atLeastOnce())
            ->method('getChannels')
            ->willReturn(['red', 'green', 'blue']);

        $this->channelMock->expects($this->atLeastOnce())
            ->method('getMethodChannels')
            ->willReturn(['getRed', 'getGreen', 'getBlue']);

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
