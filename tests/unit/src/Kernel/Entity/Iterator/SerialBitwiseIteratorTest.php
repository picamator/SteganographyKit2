<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Entity;

use Picamator\SteganographyKit2\Kernel\Entity\Iterator\SerialBitwiseIterator;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class SerialBitwiseIteratorTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $channelMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pixelMock;

    protected function setUp()
    {
        parent::setUp();

        $this->channelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\ChannelInterface')
            ->getMock();

        $this->colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface')
            ->getMock();

        $this->pixelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface')
            ->getMock();
    }

    public function testIteration()
    {
        $expected = ['0', '1'];

        // pixel mock
        $this->pixelMock->expects($this->once())
            ->method('getColor')
            ->willReturn($this->colorMock);

        // channel mock
        $this->channelMock->expects($this->once())
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

        $byteMock->expects($this->exactly(3))
            ->method('getBinary')
            ->willReturn('10101010');

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

        $iterator = new \ArrayIterator([
            'red-0', 'red-1', 'red-2', 'red-3', 'red-4', 'red-5', 'red-6', 'red-7',
            'green-8', 'green-9', 'green-10', 'green-11', 'green-12', 'green-13', 'green-14', 'green-15',
            'blue-16', 'blue-17', 'blue-18', 'blue-19', 'blue-20', 'blue-21', 'blue-22', 'blue-23'
        ]);
        $serialIterator = new SerialBitwiseIterator($this->pixelMock, $this->channelMock);

        $multipleIterator = new \MultipleIterator(\MultipleIterator::MIT_NEED_ALL|\MultipleIterator::MIT_KEYS_ASSOC);
        $multipleIterator->attachIterator($serialIterator, 'actual');
        $multipleIterator->attachIterator($iterator, 'expected');

        foreach ($multipleIterator as $item) {
            $this->assertEquals($item['expected'], $serialIterator->key());
            $this->assertContains($item['actual'], $expected);
        }
    }
}
