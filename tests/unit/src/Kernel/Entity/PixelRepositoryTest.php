<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Entity;

use Picamator\SteganographyKit2\Kernel\Entity\PixelRepository;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class PixelRepositoryTest extends BaseTest
{
    /**
     * @var PixelRepository
     */
    private $pixelRepository;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ColorIndexInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorIndexMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ColorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pixelMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pointMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $resourceMock;

    /**
     * @var resource
     */
    private $pngResource;

    protected function setUp()
    {
        parent::setUp();

        $this->colorIndexMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ColorIndexInterface')
            ->getMock();

        $this->colorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ColorFactoryInterface')
            ->getMock();

        $this->colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\ColorInterface')
            ->getMock();

        $this->pixelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Entity\Api\PixelInterface')
            ->getMock();

        $this->pointMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface')
            ->getMock();

        $this->resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface')
            ->getMock();

        $this->pngResource = imagecreatefrompng($this->getPath('secret' . DIRECTORY_SEPARATOR . 'black-pixel-1x1px.png'));

        $this->pixelRepository = new PixelRepository($this->resourceMock, $this->colorIndexMock, $this->colorFactoryMock);
    }

    protected function tearDown()
    {
        parent::tearDown();

        imagedestroy($this->pngResource);
    }

    public function testUpdate()
    {
        // color mock
        $this->colorMock->expects($this->once())
            ->method('toArray')
            ->willReturn([]);

        // color factory mock
        $this->colorFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->colorMock);

        // pixel mock
        $this->pixelMock->expects($this->exactly(2))
            ->method('getColor')
            ->willReturn($this->colorMock);

        $this->pixelMock->expects($this->once())
            ->method('setColor')
            ->willReturnSelf();

        $this->pixelMock->expects($this->once())
            ->method('hasChanged')
            ->willReturn(true);

        $this->pixelMock->expects($this->once())
            ->method('getPoint')
            ->willReturn($this->pointMock);

        // color index mock
        $this->colorIndexMock->expects($this->once())
            ->method('getColorallocate')
            ->willReturn(0);

        // point mock
        $this->pointMock->expects($this->once())
            ->method('getX')
            ->willReturn(0);

        $this->pointMock->expects($this->once())
            ->method('getY')
            ->willReturn(0);

        // resource mock
        $this->resourceMock->expects($this->once())
            ->method('getResource')
            ->willReturn($this->pngResource);

        $this->pixelRepository->update($this->pixelMock, []);
    }

    public function testSkipedUpdate()
    {
        // color mock
        $this->colorMock->expects($this->once())
            ->method('toArray')
            ->willReturn([]);

        // color factory mock
        $this->colorFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->colorMock);

        // pixel mock
        $this->pixelMock->expects($this->once())
            ->method('getColor')
            ->willReturn($this->colorMock);

        $this->pixelMock->expects($this->once())
            ->method('setColor')
            ->willReturnSelf();

        $this->pixelMock->expects($this->once())
            ->method('hasChanged')
            ->willReturn(false);

        // never
        $this->pixelMock->expects($this->never())
            ->method('getPoint');

        $this->colorIndexMock->expects($this->never())
            ->method('getColorallocate');

        $this->pointMock->expects($this->never())
            ->method('getX');

        $this->pointMock->expects($this->never())
            ->method('getY');

        $this->resourceMock->expects($this->never())
            ->method('getResource');

        $this->pixelRepository->update($this->pixelMock, []);
    }
}
