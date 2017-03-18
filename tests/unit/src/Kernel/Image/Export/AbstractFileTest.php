<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Image\Export;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class AbstractFileTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $imageMock;

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

        $this->imageMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface')
            ->getMock();

        $this->nameGenertorMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\Api\NameGeneratorInterface')
            ->getMock();

        $this->resourceMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ResourceInterface')
            ->getMock();
    }

    public function testExport()
    {
        // image mock
        $this->imageMock->expects($this->exactly(2))
            ->method('getResource')
            ->willReturn($this->resourceMock);

        // resource mock
        $this->resourceMock->expects($this->once())
            ->method('getPath')
            ->willReturn('');

        // name generator mock
        $this->nameGenertorMock->expects($this->once())
            ->method('generate');

        // file mock
        $path =  $this->getPath('stego');
        $fileMock = $this->getFileMock($path);

        $fileMock->expects($this->once())
            ->method('saveImage')
            ->willReturn(true);

        $fileMock->export();
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\RuntimeException
     */
    public function testFailExport()
    {
        // resource mock
        $this->resourceMock->expects($this->once())
            ->method('getPath')
            ->willReturn('');

        // image mock
        $this->imageMock->expects($this->exactly(2))
            ->method('getResource')
            ->willReturn($this->resourceMock);

        // name generator mock
        $this->nameGenertorMock->expects($this->once())
            ->method('generate');

        // file mock
        $path =  $this->getPath('stego');
        $fileMock = $this->getFileMock($path);

        $fileMock->expects($this->once())
            ->method('saveImage')
            ->willReturn(false);

        $fileMock->export();
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
