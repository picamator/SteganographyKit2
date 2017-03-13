<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Image\Export;

use Picamator\SteganographyKit2\Tests\Unit\BaseTest;

class AbstractFileTest extends BaseTest
{
    /**
     * @var \Picamator\SteganographyKit2\Image\Api\ImageInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $imageMock;

    /**
     * @var \Picamator\SteganographyKit2\File\Api\NameGeneratorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $nameGenertorMock;

    protected function setUp()
    {
        parent::setUp();

        $this->imageMock = $this->getMockBuilder('Picamator\SteganographyKit2\Image\Api\ImageInterface')
            ->getMock();

        $this->nameGenertorMock = $this->getMockBuilder('Picamator\SteganographyKit2\File\Api\NameGeneratorInterface')
            ->getMock();
    }

    public function testExport()
    {
        // image mock
        $this->imageMock->expects($this->once())
            ->method('getResource');

        $this->imageMock->expects($this->once())
            ->method('getPath');

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
     * @expectedException \Picamator\SteganographyKit2\Exception\RuntimeException
     */
    public function testFailExport()
    {
        // image mock
        $this->imageMock->expects($this->once())
            ->method('getResource');

        $this->imageMock->expects($this->exactly(2))
            ->method('getPath');

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
     * @return \Picamator\SteganographyKit2\File\Api\NameGeneratorInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private function getFileMock(string $filePath) : \PHPUnit_Framework_MockObject_MockObject
    {
        return $this->getMockBuilder('Picamator\SteganographyKit2\Image\Export\AbstractFile')
            ->setConstructorArgs([$this->imageMock, $this->nameGenertorMock, $filePath])
            ->getMockForAbstractClass();
    }
}
