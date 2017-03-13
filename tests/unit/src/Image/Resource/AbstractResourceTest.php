<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Image\Resource;

use Picamator\SteganographyKit2\Tests\Unit\BaseTest;

class AbstractResourceTest extends BaseTest
{
    public function testExport()
    {
        $filePath = 'test';

        // resource mock
        $resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Resource\AbstractResource')
                ->setConstructorArgs([$filePath])
                ->getMockForAbstractClass();

        $resourceMock->expects($this->once())
            ->method('getImage')
            ->with($this->equalTo($filePath))
            ->willReturn(true);

        $resourceMock->getResource();
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Exception\RuntimeException
     */
    public function testFailExport()
    {
        $filePath = 'test';

        // resource mock
        $resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Resource\AbstractResource')
            ->setConstructorArgs([$filePath])
            ->getMockForAbstractClass();

        $resourceMock->expects($this->once())
            ->method('getImage')
            ->with($this->equalTo($filePath))
            ->willReturn(false);

        $resourceMock->getResource();
        $resourceMock->getResource(); // double run to test cache
    }
}
