<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image;

use Picamator\SteganographyKit2\Kernel\Image\Image;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class ImageTest extends BaseTest
{
    /**
     * @var Image
     */
    private $image;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $resourceMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorFactoryMock;

    /**
     * @var \Iterator | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorMock;

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

        $this->resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface')
            ->getMock();

        $this->iteratorFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Iterator\IteratorFactoryInterface')
            ->getMock();

        $this->iteratorMock = $this->getMockBuilder('Iterator')
            ->getMock();

        $this->sizeFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\SizeFactoryInterface')
            ->getMock();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface')
            ->getMock();

        $this->image = new Image(
            $this->resourceMock,
            $this->iteratorFactoryMock,
            $this->sizeFactoryMock
        );
    }

    public function testGetPath()
    {
        // resource mock
        $this->resourceMock->expects($this->once())
            ->method('getPath');

        $this->image->getPath();
    }

    public function testGetResource()
    {
        // resource mock
        $this->resourceMock->expects($this->once())
            ->method('getResource');

        $this->image->getResource();
    }

    public function testGetSize()
    {
        // resource mock
        $this->resourceMock->expects($this->once())
            ->method('getPath');

        // size factory mock
        $this->sizeFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->sizeMock);

        $this->image->getSize();
        $this->image->getSize(); // double runt to test cache
    }


    public function testGetIterator()
    {
        // iterator factory mock
        $this->iteratorFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->iteratorMock);

        $this->image->getIterator();
        $this->image->getIterator(); // double runt to test cache
    }
}
