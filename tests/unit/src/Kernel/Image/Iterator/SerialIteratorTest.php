<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image\Iterator;

use Picamator\SteganographyKit2\Kernel\Image\Iterator\SerialIterator;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class SerialIteratorTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $imageMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $repositoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\PointFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pointFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pointMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pixelMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    protected function setUp()
    {
        parent::setUp();

        $this->imageMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface')
            ->getMock();

        $this->repositoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\RepositoryInterface')
            ->getMock();

        $this->pointFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\PointFactoryInterface')
            ->getMock();

        $this->pointMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface')
            ->getMock();

        $this->pixelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface')
            ->getMock();

        $this->infoMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface')
            ->getMock();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface')
            ->getMock();
    }

    public function testIterator()
    {
        $width = 1;
        $height = 1;

        $size = $width * $height;

        // image mock
        $this->imageMock->expects($this->once())
            ->method('getRepository')
            ->willReturn($this->repositoryMock);

        $this->imageMock->expects($this->once())
            ->method('getInfo')
            ->willReturn($this->infoMock);

        // repository mock
        $this->repositoryMock->expects($this->exactly($size))
            ->method('find')
            ->with($this->equalTo($this->pointMock))
            ->willReturn($this->pixelMock);

        // info mock
        $this->infoMock->expects($this->once())
            ->method('getSize')
            ->willReturn($this->sizeMock);

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

        $serialIterator = new SerialIterator(
            $this->imageMock,
            $this->pointFactoryMock
        );

        $i = 0;
        foreach ($serialIterator as $item) {
            $this->assertInstanceOf('Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface', $item);
            $i ++;
        }
        $this->assertEquals($size, $i);
        $this->assertEquals($size, $serialIterator->key());
    }
}
