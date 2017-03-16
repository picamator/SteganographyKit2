<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Lsb\StegoSystem;

use Picamator\SteganographyKit2\Lsb\StegoSystem\EncodeBit;
use Picamator\SteganographyKit2\Tests\Unit\Lsb\BaseTest;

class EncodeBitTest extends BaseTest
{
    /**
     * @var EncodeBit
     */
    private $encodeBit;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\ByteFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $byteFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $byteMock;

    protected function setUp()
    {
        parent::setUp();

        $this->byteFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\ByteFactoryInterface')
            ->getMock();

        $this->byteMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface')
            ->getMock();

        $this->encodeBit = new EncodeBit($this->byteFactoryMock);
    }

    public function testEncode()
    {
        $binary = str_repeat(0, 8);

        $secretBit = 1;
        $stegoByte = substr_replace($binary, $secretBit, -1);

        // byte mock
        $this->byteMock->expects($this->once())
            ->method('getBinary')
            ->willReturn($binary);

        // byte factory mock
        $this->byteFactoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo($stegoByte))
            ->willReturn($this->byteMock);

        $this->encodeBit->encode(1, $this->byteMock);
    }
}
