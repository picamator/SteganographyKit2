<?php
namespace Picamator\SteganographyKit2\Tests\Unit\LsbImage\SecretText;

use Picamator\SteganographyKit2\LsbImage\SecretText\Encode;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class EncodeTest extends BaseTest
{
    /**
     * @var Encode
     */
    private $encode;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Converter\ImageToBinaryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $converterMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMarkFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMarkMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $secretTextFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $secretTextMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $imageMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    protected function setUp()
    {
        parent::setUp();

        $this->converterMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Converter\ImageToBinaryInterface')
            ->getMock();

        $this->infoMarkFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkFactoryInterface')
            ->getMock();

        $this->infoMarkMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface')
            ->getMock();

        $this->secretTextFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextFactoryInterface')
            ->getMock();

        $this->secretTextMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface')
            ->getMock();

        $this->imageMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface')
            ->getMock();

        $this->infoMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\File\Api\Data\InfoInterface')
            ->getMock();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface')
            ->getMock();

        $this->encode = new Encode($this->converterMock, $this->infoMarkFactoryMock, $this->secretTextFactoryMock);
    }

    public function testEncode()
    {
        $convertedData = 'Hello Steganography!';
        $width = 1;
        $height = 1;

        // converter mock
        $this->converterMock->expects($this->once())
            ->method('convert')
            ->with($this->equalTo($this->imageMock))
            ->willReturn($convertedData);

        // image mock
        $this->imageMock->expects($this->once())
            ->method('getInfo')
            ->willReturn($this->infoMock);

        // info mock
        $this->infoMock->expects($this->once())
            ->method('getSize')
            ->willReturn($this->sizeMock);

        // size mock
        $this->sizeMock->expects($this->once())
            ->method('getWidth')
            ->willReturn($width);

        $this->sizeMock->expects($this->once())
            ->method('getHeight')
            ->willReturn($height);

        // info mark factory
        $this->infoMarkFactoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo($width), $this->equalTo($height))
            ->willReturn($this->infoMarkMock);

        // secret text factory mock
        $this->secretTextFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->secretTextMock);

        $this->encode->encode($this->imageMock);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     *
     * @dataProvider providerFailEncode
     *
     * @param mixed $data
     */
    public function testFailEncode($data)
    {
        // never
        $this->converterMock->expects($this->never())
            ->method('convert');

        $this->imageMock->expects($this->never())
            ->method('getInfo');

        $this->infoMarkFactoryMock->expects($this->never())
            ->method('create');

        $this->secretTextFactoryMock->expects($this->never())
            ->method('create');

        $this->encode->encode($data);
    }

    public function providerFailEncode()
    {
        return [
            ['test'],
            [new \stdClass()],
        ];
    }
}
