<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Image\Repository;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class RepositoryTest extends BaseTest
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $imageMock;

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
     * @var resource
     */
    private $resource;

    protected function setUp()
    {
        parent::setUp();

        $this->imageMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface')
            ->getMock();

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

        $this->resource = imagecreatefrompng($this->getPath('secret' . DIRECTORY_SEPARATOR . 'black-pixel.png'));

        $this->repository = new Repository($this->imageMock, $this->colorIndexMock, $this->colorFactoryMock);
    }

    protected function tearDown()
    {
        parent::tearDown();

        imagedestroy($this->resource);
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

        // image mock
        $this->imageMock->expects($this->once())
            ->method('getResource')
            ->willReturn($this->resource);

        $this->repository->update($this->pixelMock, []);
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

        $this->imageMock->expects($this->never())
            ->method('getResource');

        $this->repository->update($this->pixelMock, []);
    }
}
