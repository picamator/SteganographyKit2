<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Image\Iterator;

use Picamator\SteganographyKit2\Image\Iterator\SerialIterator;
use Picamator\SteganographyKit2\Tests\Unit\BaseTest;

class SerialIteratorTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Image\Api\ImageInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $imageMock;

    /**
     * @var \Picamator\SteganographyKit2\Image\Api\ColorIndexInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorIndexMock;

    /**
     * @var \Picamator\SteganographyKit2\Primitive\Api\PointFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pointFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Primitive\Api\PointInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pointMock;

    /**
     * @var \Picamator\SteganographyKit2\Entity\Api\PixelFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pixelFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Entity\Api\PixelInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pixelMock;

    /**
     * @var \Picamator\SteganographyKit2\Image\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    /**
     * @var resource
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();

        $this->imageMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Api\ImageInterface')
            ->getMock();

        $this->colorIndexMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Api\ColorIndexInterface')
            ->getMock();

        $this->pointFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Primitive\Api\PointFactoryInterface')
            ->getMock();

        $this->pointMock = $this->getMockBuilder('Picamator\SteganographyKit2\Primitive\Api\Data\PointInterface')
            ->getMock();

        $this->pixelFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Entity\Api\PixelFactoryInterface')
            ->getMock();

        $this->pixelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Entity\Api\PixelInterface')
            ->getMock();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Api\Data\SizeInterface')
            ->getMock();

        $this->resource = imagecreatefrompng($this->getPath('secret' . DIRECTORY_SEPARATOR . 'parallel-lines-100x100px-alpha.png'));
    }

    protected function tearDown()
    {
        parent::tearDown();

        imagedestroy($this->resource);
    }

    public function testIterator()
    {
        $width = 2;
        $height = 2;

        $size = $width * $height;

        // size mock
        $this->sizeMock->expects($this->once())
            ->method('getWidth')
            ->willReturn($width);

        $this->sizeMock->expects($this->once())
            ->method('getHeight')
            ->willReturn($height);

        // image mock
        $this->imageMock->expects($this->exactly(2))
            ->method('getSize')
            ->willReturn($this->sizeMock);

        $this->imageMock->expects($this->once())
            ->method('getResource')
            ->willReturn($this->resource);

        // color index mock
        $this->colorIndexMock->expects($this->exactly($size))
            ->method('getColor');

        // point factory mock
        $this->pointFactoryMock->expects($this->exactly($size))
            ->method('create')
            ->willReturn($this->pointMock);

        // pixel factory mock
        $this->pixelFactoryMock->expects($this->exactly($size))
            ->method('create')
            ->willReturn($this->pixelMock);

        $serialIterator = new SerialIterator(
            $this->imageMock,
            $this->colorIndexMock,
            $this->pointFactoryMock,
            $this->pixelFactoryMock
        );

        $i = 0;
        foreach ($serialIterator as $item) {
            $this->assertInstanceOf('Picamator\SteganographyKit2\Entity\Api\PixelInterface', $item);
            $i ++;
        }
        $this->assertEquals($size, $i);
        $this->assertEquals($size, $serialIterator->key());
    }
}
