<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image\Resource;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class AbstractResourceTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\SizeFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    protected function setUp()
    {
        parent::setUp();

        $this->sizeFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\SizeFactoryInterface')
            ->getMock();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface')
            ->getMock();
    }

    public function testGetSize()
    {
        $filePath = 'test';

        // resource mock
        $resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Resource\AbstractResource')
            ->setConstructorArgs([$this->sizeFactoryMock, $filePath])
            ->getMockForAbstractClass();

        // size factory mock
        $this->sizeFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->sizeMock);

        $resourceMock->getSize();
        $resourceMock->getSize(); // double runt to test cache
    }

    public function testGetResource()
    {
        $filePath = 'test';

        // resource mock
        $resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Resource\AbstractResource')
                ->setConstructorArgs([$this->sizeFactoryMock, $filePath])
                ->getMockForAbstractClass();

        $resourceMock->expects($this->once())
            ->method('getImage')
            ->with($this->equalTo($filePath))
            ->willReturn(true);

        $resourceMock->getResource();
        $resourceMock->getResource(); // double run to test cache
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function testFailGetResource()
    {
        $filePath = 'test';

        // resource mock
        $resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Resource\AbstractResource')
            ->setConstructorArgs([$this->sizeFactoryMock, $filePath])
            ->getMockForAbstractClass();

        $resourceMock->expects($this->once())
            ->method('getImage')
            ->with($this->equalTo($filePath))
            ->willReturn(false);

        $resourceMock->getResource();
    }
}
