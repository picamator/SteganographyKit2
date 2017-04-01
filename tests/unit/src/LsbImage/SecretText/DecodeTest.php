<?php
namespace Picamator\SteganographyKit2\Tests\Unit\LsbImage\SecretText;

use Picamator\SteganographyKit2\LsbImage\SecretText\Decode;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class DecodeTest extends BaseTest
{
    /**
     * @var Decode
     */
    private $decode;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\Converter\BinaryToImageInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $converterMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMarkMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $secretTextMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $imageMock;

    protected function setUp()
    {
        parent::setUp();

        $this->converterMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\Converter\BinaryToImageInterface')
            ->getMock();

        $this->infoMarkMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface')
            ->getMock();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface')
            ->getMock();

        $this->secretTextMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface')
            ->getMock();

        $this->imageMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Image\Api\ImageInterface')
            ->getMock();

        $this->decode = new Decode($this->converterMock);
    }

    public function testDecode()
    {
        $data = '01010101';

        // secret text mock
        $this->secretTextMock->expects($this->once())
            ->method('getInfoMark')
            ->willReturn($this->infoMarkMock);

        $this->secretTextMock->expects($this->once())
            ->method('getBinaryText')
            ->willReturn($data);

        // info mark mock
        $this->infoMarkMock->expects($this->once())
            ->method('getSize')
            ->willReturn($this->sizeMock);

        // converter mock
        $this->converterMock->expects($this->once())
            ->method('convert')
            ->with($this->equalTo($this->sizeMock), $this->equalTo($data))
            ->willReturn($this->imageMock);

        $this->decode->decode($this->secretTextMock);
    }
}
