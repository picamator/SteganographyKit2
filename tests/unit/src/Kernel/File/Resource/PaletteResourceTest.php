<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\File\Resource;

use Picamator\SteganographyKit2\Kernel\File\Resource\PaletteResource;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class PaletteResourceTest extends BaseTest
{
    /**
     * @var PaletteResource
     */
    private $paletteResource;

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

        $this->infoMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface')
            ->getMock();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface')
            ->getMock();

        $this->paletteResource = new PaletteResource($this->infoMock);
    }

    public function testGetResource()
    {
        $width = 10;
        $height = 10;

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

        $this->paletteResource->getResource();
        $resource = $this->paletteResource->getResource(); // double run to test cache

        $this->assertInternalType('resource', $resource);
    }
}
