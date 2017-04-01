<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\File\Resource;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class AbstractResourceTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMock;

    protected function setUp()
    {
        parent::setUp();

        $this->infoMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface')
            ->getMock();
    }

    public function testGetResource()
    {
        $filePath = 'test.txt';

        // info mock
        $this->infoMock->expects($this->once())
            ->method('getPath')
            ->willReturn($filePath);

        // resource mock
        /** @var \Picamator\SteganographyKit2\Kernel\File\Resource\AbstractResource | \PHPUnit_Framework_MockObject_MockObject $resourceMock */
        $resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\Resource\AbstractResource')
                ->setConstructorArgs([$this->infoMock])
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
        $filePath = 'test.txt';

        // info mock
        $this->infoMock->expects($this->once())
            ->method('getPath')
            ->willReturn($filePath);

        // resource mock
        /** @var \Picamator\SteganographyKit2\Kernel\File\Resource\AbstractResource | \PHPUnit_Framework_MockObject_MockObject $resourceMock */
        $resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\Resource\AbstractResource')
            ->setConstructorArgs([$this->infoMock])
            ->getMockForAbstractClass();

        $resourceMock->expects($this->once())
            ->method('getImage')
            ->with($this->equalTo($filePath))
            ->willReturn(false);

        $resourceMock->getResource();
    }
}
