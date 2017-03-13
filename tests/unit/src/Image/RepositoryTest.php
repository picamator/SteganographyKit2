<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Image;

use Picamator\SteganographyKit2\Image\Repository;
use Picamator\SteganographyKit2\Tests\Unit\BaseTest;

class RepositoryTest extends BaseTest
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * @var \Picamator\SteganographyKit2\Image\Api\ImageInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $imageMock;

    /**
     * @var \Picamator\SteganographyKit2\Image\Api\ColorIndexInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorIndexMock;

    /**
     * @var \Picamator\SteganographyKit2\Image\Api\Data\ColorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $colorMock;

    /**
     * @var \Picamator\SteganographyKit2\Entity\Api\PixelInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pixelMock;

    /**
     * @var \Picamator\SteganographyKit2\Primitive\Api\Data\PointInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pointMock;

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

        $this->colorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Api\Data\ColorInterface')
            ->getMock();

        $this->pixelMock = $this->getMockBuilder('Picamator\SteganographyKit2\Entity\Api\PixelInterface')
            ->getMock();

        $this->pointMock = $this->getMockBuilder('Picamator\SteganographyKit2\Primitive\Api\Data\PointInterface')
            ->getMock();

        $this->resource = imagecreatefrompng($this->getPath('secret' . DIRECTORY_SEPARATOR . 'black-pixel.png'));

        $this->repository = new Repository($this->imageMock, $this->colorIndexMock);
    }

    protected function tearDown()
    {
        parent::tearDown();

        imagedestroy($this->resource);
    }

    public function testUpdate()
    {
        // pixel mock
        $this->pixelMock->expects($this->once())
            ->method('getColor')
            ->willReturn($this->colorMock);

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

        $this->repository->update($this->pixelMock);
    }
}
