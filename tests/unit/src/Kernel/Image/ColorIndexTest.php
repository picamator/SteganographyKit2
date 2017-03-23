<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Image\ColorIndex;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class ColorIndexTest extends BaseTest
{
    /**
     * @var ColorIndex
     */
    private $colorIndex;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\ByteFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $byteFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $byteMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ColorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface| \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorMock;

    protected function setUp()
    {
        parent::setUp();

        $this->byteFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\ByteFactoryInterface')
            ->getMock();

        $this->byteMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface')
            ->getMock();

        $this->colorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ColorFactoryInterface')
            ->getMock();

        $this->colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface')
            ->getMock();

        $this->colorIndex = new ColorIndex( $this->byteFactoryMock, $this->colorFactoryMock);
    }

    public function testGetColor()
    {
        $path = $this->getPath('secret' . DIRECTORY_SEPARATOR . 'black-pixel-1x1px.png');
        $resource = imagecreatefrompng($path);

        $colorIndex = imagecolorat($resource, 0, 0);

        // color factory mock
        $this->colorFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->colorMock);

        // byte factory mock
        $this->byteFactoryMock->expects($this->exactly(4))
            ->method('create')
            ->willReturn($this->byteMock);

        $actual = $this->colorIndex->getColor($colorIndex);
        $this->assertInstanceOf('Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface', $actual);

        imagedestroy($resource);
    }

    public function testGetColorallocate()
    {
        // byte mock
        $this->byteMock->expects($this->exactly(3))
            ->method('getInt')
            ->willReturn(0);

        // color mock
        $this->colorMock->expects($this->once())
            ->method('getRed')
            ->willReturn($this->byteMock);

        $this->colorMock->expects($this->once())
            ->method('getGreen')
            ->willReturn($this->byteMock);

        $this->colorMock->expects($this->once())
            ->method('getBlue')
            ->willReturn($this->byteMock);

        $this->colorIndex->getColorallocate($this->colorMock);
    }
}
