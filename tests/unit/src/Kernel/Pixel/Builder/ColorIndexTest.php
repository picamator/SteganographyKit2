<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Pixel\Builder;

use Picamator\SteganographyKit2\Kernel\Pixel\Builder\ColorIndex;
use Picamator\SteganographyKit2\Kernel\Primitive\Builder\ByteFactory;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class ColorIndexTest extends BaseTest
{
    /**
     * @var ColorIndex
     */
    private $colorIndex;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface| \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorMock;

    protected function setUp()
    {
        parent::setUp();

        $this->colorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorFactoryInterface')
            ->getMock();

        $this->colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface')
            ->getMock();

        $this->colorIndex = new ColorIndex($this->colorFactoryMock);
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

        $actual = $this->colorIndex->getColor($colorIndex);
        $this->assertInstanceOf('Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface', $actual);

        imagedestroy($resource);
    }

    public function testGetColorallocate()
    {
        // color mock
        $this->colorMock->expects($this->once())
            ->method('getRed')
            ->willReturn(ByteFactory::create('0'));

        $this->colorMock->expects($this->once())
            ->method('getGreen')
            ->willReturn(ByteFactory::create('0'));

        $this->colorMock->expects($this->once())
            ->method('getBlue')
            ->willReturn(ByteFactory::create('0'));

        $this->colorIndex->getColorallocate($this->colorMock);
    }
}
