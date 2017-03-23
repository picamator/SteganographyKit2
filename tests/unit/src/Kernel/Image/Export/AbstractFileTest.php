<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image\Export;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class AbstractFileTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Export\AbstractFile | \PHPUnit_Framework_MockObject_MockObject
     */
    private $fileMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\File\Api\Data\WritablePathInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $writablePathMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\File\Api\NameGeneratorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $nameGenertorMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $resourceMock;

    protected function setUp()
    {
        parent::setUp();

        $this->writablePathMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\Api\Data\WritablePathInterface')
            ->getMock();

        $this->nameGenertorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\Api\NameGeneratorInterface')
            ->getMock();

        $this->resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface')
            ->getMock();

        $this->fileMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Export\AbstractFile')
            ->setConstructorArgs([$this->writablePathMock, $this->nameGenertorMock])
            ->getMockForAbstractClass();
    }

    public function testExport()
    {
        // resource mock
        $this->resourceMock->expects($this->once())
            ->method('getName')
            ->willReturn('');

        // name generator mock
        $this->nameGenertorMock->expects($this->once())
            ->method('generate');

        // file mock
        $this->fileMock->expects($this->once())
            ->method('saveImage')
            ->willReturn(true);

        $this->fileMock->export($this->resourceMock);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function testFailExport()
    {
        // resource mock
        $this->resourceMock->expects($this->once())
            ->method('getName')
            ->willReturn('');

        // name generator mock
        $this->nameGenertorMock->expects($this->once())
            ->method('generate');

        // file mock
        $this->fileMock->expects($this->once())
            ->method('saveImage')
            ->willReturn(false);

        $this->fileMock->export($this->resourceMock);
    }

    /**
     * Gets file mock
     *
     * @param string $filePath
     *
     * @return \Picamator\SteganographyKit2\Kernel\File\Api\NameGeneratorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private function getFileMock(string $filePath) : \PHPUnit_Framework_MockObject_MockObject
    {
        return $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Export\AbstractFile')
            ->setConstructorArgs([$this->imageMock, $this->nameGenertorMock, $filePath])
            ->getMockForAbstractClass();
    }
}
