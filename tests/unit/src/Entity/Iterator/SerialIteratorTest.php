<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Entity;

use Picamator\SteganographyKit2\Entity\Iterator\SerialIterator;
use Picamator\SteganographyKit2\Tests\Unit\BaseTest;

class SerialIteratorTest extends BaseTest
{
    /**
     * @var SerialIterator
     */
    private $serialIterator;

    /**
     * @var \Picamator\SteganographyKit2\Image\Api\Data\ColorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorMock;

    protected function setUp()
    {
        parent::setUp();

        $this->colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Api\Data\ColorInterface')
            ->getMock();

        $pixelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Entity\Api\PixelInterface')
            ->getMock();

        $pixelMock->method('getColor')
            ->willReturn($this->colorMock);

        $this->serialIterator = new SerialIterator($pixelMock);
    }

    public function testIteration()
    {
        // byte mock
        $byteMock = $this->getMockBuilder('Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface')
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
            $this->assertInstanceOf('Picamator\SteganographyKit2\Primitive\Api\Data\ByteInterface', $item['actual']);
        }
    }
}
