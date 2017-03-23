<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image\Resource;

use Picamator\SteganographyKit2\Kernel\Image\Resource\PaletteResource;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class PaletteResourceTest extends BaseTest
{
    /**
     * @var PaletteResource
     */
    private $paletteResource;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    protected function setUp()
    {
        parent::setUp();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface')
            ->getMock();

        $this->paletteResource = new PaletteResource($this->sizeMock, 'test.txt');
    }

    public function testGetResource()
    {
        $width = 10;
        $height = 10;

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
