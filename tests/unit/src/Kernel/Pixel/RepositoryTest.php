<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Pixel;

use Picamator\SteganographyKit2\Kernel\Pixel\Repository;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class RepositoryTest extends BaseTest
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorIndexInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorIndexMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pixelFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pixelMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pointMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $resourceMock;

    /**
     * @var resource
     */
    private $pngResource;

    protected function setUp()
    {
        parent::setUp();

        $this->resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface')
            ->getMock();

        $this->colorIndexMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorIndexInterface')
            ->getMock();

        $this->colorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Builder\ColorFactoryInterface')
            ->getMock();

        $this->colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\Data\ColorInterface')
            ->getMock();

        $this->pixelFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelFactoryInterface')
            ->getMock();

        $this->pixelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Pixel\Api\PixelInterface')
            ->getMock();

        $this->pointMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\PointInterface')
            ->getMock();

        $this->pngResource = imagecreatefrompng($this->getPath('secret' . DIRECTORY_SEPARATOR . 'black-pixel-1x1px.png'));

        $this->repository = new Repository($this->resourceMock, $this->colorIndexMock, $this->colorFactoryMock, $this->pixelFactoryMock);
    }

    protected function tearDown()
    {
        parent::tearDown();

        imagedestroy($this->pngResource);
    }

    public function testUpdate()
    {
        $oldData = ['red' => 1, 'green' => 2, 'blue' => 3, 'alpha' => 4];
        $data = ['red' => 0, 'green' => 2, 'blue' => 3, 'alpha' => 4];

        // color mock
        $this->colorMock->expects($this->once())
            ->method('toArray')
            ->willReturn($oldData);

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

        $this->repository->update($this->pixelMock, $data);
    }

    public function testSkippedUpdate()
    {
        $oldData = ['red' => new \stdClass(1), 'green' => 2, 'blue' => 3, 'alpha' => 4];
        $data = ['red' => new \stdClass(1), 'green' => 2, 'blue' => 3];

        // color mock
        $this->colorMock->expects($this->once())
            ->method('toArray')
            ->willReturn($oldData);

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

        $this->repository->update($this->pixelMock, $data);
    }

    public function testIdenticalUpdate()
    {
        $oldData = ['red' => new \stdClass(1), 'green' => 2, 'blue' => 3, 'alpha' => 4];
        $data = $oldData;

        // color mock
        $this->colorMock->expects($this->once())
            ->method('toArray')
            ->willReturn($oldData);

        // pixel mock
        $this->pixelMock->expects($this->once())
            ->method('getColor')
            ->willReturn($this->colorMock);

        // never
        $this->colorFactoryMock->expects($this->never())
            ->method('create');

        $this->pixelMock->expects($this->never())
            ->method('setColor');

        $this->pixelMock->expects($this->never())
            ->method('hasChanged');

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

        $this->repository->update($this->pixelMock, $data);
    }

    public function testFind()
    {
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

        // color index mock
        $this->colorIndexMock->expects($this->once())
            ->method('getColor')
            ->willReturn($this->colorMock);

        $this->pixelFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->pixelMock);

        $this->repository->find($this->pointMock);
    }
}
