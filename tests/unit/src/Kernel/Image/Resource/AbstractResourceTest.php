<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image\Resource;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class AbstractResourceTest extends BaseTest
{
    public function testGetResource()
    {
        $filePath = 'test';

        // resource mock
        $resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Resource\AbstractResource')
                ->setConstructorArgs([$filePath])
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
            ->setConstructorArgs([$filePath])
            ->getMockForAbstractClass();

        $resourceMock->expects($this->once())
            ->method('getImage')
            ->with($this->equalTo($filePath))
            ->willReturn(false);

        $resourceMock->getResource();
    }
}
