<?php
namespace Picamator\SteganographyKit2\Tests\Unit\LsbImage\SecretText;

use Picamator\SteganographyKit2\LsbImage\SecretText\SecretText;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class SecretTextTest extends BaseTest
{
    /**
     * @var SecretText
     */
    private $secretText;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $imageMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    /**
     * @var \Iterator | \PHPUnit_Framework_MockObject_MockObject
     */
    private $iteratorMock;

    protected function setUp()
    {
        parent::setUp();

        $this->imageMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface')
            ->getMock();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Data\SizeInterface')
            ->getMock();

        $this->iteratorMock = $this->getMockBuilder('Iterator')
            ->getMock();

        $this->secretText = new SecretText($this->imageMock);
    }

    public function testGetResource()
    {
        // image mock
        $this->imageMock->expects($this->once())
            ->method('getResource');

        $this->secretText->getResource();
    }

    public function testGetCountBit()
    {
        $channel = 3;
        $width = 10;
        $height = 5;

        $expected = $width * $height * $channel * 8;

        // image mock
        $this->imageMock->expects($this->once())
            ->method('getSize')
            ->willReturn($this->sizeMock);

        // size mock
        $this->sizeMock->expects($this->once())
            ->method('getWidth')
            ->willReturn($width);

        $this->sizeMock->expects($this->once())
            ->method('getHeight')
            ->willReturn($height);

        $actual = $this->secretText->getCountBit();
        $this->assertEquals($expected, $actual);
    }

    public function testGetIterator()
    {
        // image mock
        $this->imageMock->expects($this->once())
            ->method('getIterator')
            ->willReturn($this->iteratorMock);

        $this->secretText->getIterator();
    }
}
