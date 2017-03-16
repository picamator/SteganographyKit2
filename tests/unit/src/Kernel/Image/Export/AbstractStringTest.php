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
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $imageMock;

    protected function setUp()
    {
        parent::setUp();

        $this->imageMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface')
            ->getMock();

        $this->stringMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Export\AbstractString')
            ->setConstructorArgs([$this->imageMock])
            ->getMockForAbstractClass();
    }

    public function testExport()
    {
        // image mock
        $this->imageMock->expects($this->once())
            ->method('getResource');

        // string mock
        $this->stringMock ->expects($this->once())
            ->method('displayImage')
            ->willReturn(true);

        // never
        $this->imageMock->expects($this->never())
            ->method('getPath');


        $this->stringMock->export();
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function testFailExport()
    {
        // image mock
        $this->imageMock->expects($this->once())
            ->method('getResource');

        $this->imageMock->expects($this->once())
            ->method('getPath');

        // string mock
        $this->stringMock ->expects($this->once())
            ->method('displayImage')
            ->willReturn(false);

        $this->stringMock->export();
    }
}
