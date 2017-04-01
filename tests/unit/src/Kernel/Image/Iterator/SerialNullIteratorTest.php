<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image\Iterator;

use Picamator\SteganographyKit2\Kernel\Image\Iterator\SerialNullIterator;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class SerialNullIteratorTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\PointFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pointFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pointMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pixelFactoryMock;


    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pixelMock;

    protected function setUp()
    {
        parent::setUp();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface')
            ->getMock();

        $this->pointFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\PointFactoryInterface')
            ->getMock();

        $this->pointMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface')
            ->getMock();

        $this->pixelFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelFactoryInterface')
            ->getMock();

        $this->pixelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface')
            ->getMock();
    }

    public function testIterator()
    {
        $width = 1;
        $height = 1;

        $size = $width * $height;

        // size mock
        $this->sizeMock->expects($this->once())
            ->method('getWidth')
            ->willReturn($width);

        $this->sizeMock->expects($this->once())
            ->method('getHeight')
            ->willReturn($height);

        // point factory mock
        $this->pointFactoryMock->expects($this->exactly($size))
            ->method('create')
            ->willReturn($this->pointMock);

        // pixel factory mock
        $this->pixelFactoryMock->expects($this->exactly($size))
            ->method('create')
            ->willReturn($this->pixelMock);

        $serialIterator = new SerialNullIterator($this->sizeMock, $this->pointFactoryMock, $this->pixelFactoryMock);

        $i = 0;
        foreach ($serialIterator as $item) {
            $this->assertInstanceOf('Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface', $item);
            $i ++;
        }
        $this->assertEquals($size, $i);
        $this->assertEquals($size, $serialIterator->key());
    }
}
