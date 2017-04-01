<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image\Export;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class AbstractStringTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Export\AbstractString | \PHPUnit_Framework_MockObject_MockObject
     */
    private $stringMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $resourceMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMock;

    protected function setUp()
    {
        parent::setUp();

        $this->resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\Api\Resource\ResourceInterface')
            ->getMock();

        $this->stringMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Export\AbstractString')
            ->getMockForAbstractClass();

        $this->infoMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface')
            ->getMock();
    }

    public function testExport()
    {
        // string mock
        $this->stringMock ->expects($this->once())
            ->method('displayImage')
            ->willReturn(true);

        $this->stringMock->export($this->resourceMock);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function testFailExport()
    {
        // resource mock
        $this->resourceMock->expects($this->once())
            ->method('getInfo')
            ->willReturn($this->infoMock);

        // info mock
        $this->infoMock->expects($this->once())
            ->method('getName')
            ->willReturn(' ');
        // string mock
        $this->stringMock->expects($this->once())
            ->method('displayImage')
            ->willReturn(false);

        $this->stringMock->export($this->resourceMock);
    }
}
