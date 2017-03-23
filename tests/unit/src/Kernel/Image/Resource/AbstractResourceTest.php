<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image\Resource;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class AbstractResourceTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    protected function setUp()
    {
        parent::setUp();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface')
            ->getMock();
    }

    public function testGetName()
    {
        $filePath = 'text/test.txt';
        $fileName = 'test.txt';

        // resource mock
        /** @var \Picamator\SteganographyKit2\Kernel\Image\Resource\AbstractResource | \PHPUnit_Framework_MockObject_MockObject $resourceMock */
        $resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Resource\AbstractResource')
            ->setConstructorArgs([$this->sizeMock, $filePath])
            ->getMockForAbstractClass();

        $actualFileName = $resourceMock->getName();
        $this->assertEquals($fileName, $actualFileName);
    }

    public function testGetResource()
    {
        $filePath = 'test.txt';

        // resource mock
        /** @var \Picamator\SteganographyKit2\Kernel\Image\Resource\AbstractResource | \PHPUnit_Framework_MockObject_MockObject $resourceMock */
        $resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Resource\AbstractResource')
                ->setConstructorArgs([$this->sizeMock, $filePath])
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

        // resource mock
        /** @var \Picamator\SteganographyKit2\Kernel\Image\Resource\AbstractResource | \PHPUnit_Framework_MockObject_MockObject $resourceMock */
        $resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Resource\AbstractResource')
            ->setConstructorArgs([$this->sizeMock, $filePath])
            ->getMockForAbstractClass();

        $resourceMock->expects($this->once())
            ->method('getImage')
            ->with($this->equalTo($filePath))
            ->willReturn(false);

        $resourceMock->getResource();
    }
}
