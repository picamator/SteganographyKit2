<?php
namespace Picamator\SteganographyKit2\Tests\Unit\LsbText\SecretText;

use Picamator\SteganographyKit2\LsbText\SecretText\Encode;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class EncodeTest extends BaseTest
{
    /**
     * @var Encode
     */
    private $encode;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Text\Api\FilterManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $filterManagerMock;

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

    protected function setUp()
    {
        parent::setUp();

        $this->filterManagerMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\FilterManagerInterface')
            ->getMock();

        $this->infoMarkFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkFactoryInterface')
            ->getMock();

        $this->infoMarkMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface')
            ->getMock();

        $this->secretTextFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextFactoryInterface')
            ->getMock();

        $this->secretTextMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\SecretTextInterface')
            ->getMock();

        $this->encode = new Encode($this->filterManagerMock, $this->infoMarkFactoryMock, $this->secretTextFactoryMock);
    }

    public function testEncode()
    {
        $data = 'Hello Steganography!';
        $width = strlen($data);
        $height = 0;

        // filter manager mock
        $this->filterManagerMock->expects($this->once())
            ->method('apply')
            ->willReturn($data);

        // info mark factory
        $this->infoMarkFactoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo($width), $this->equalTo($height))
            ->willReturn($this->infoMarkMock);

        // secret text factory mock
        $this->secretTextFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->secretTextMock);

        $this->encode->encode($data);
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function testFailEncode()
    {
        // never
        $this->infoMarkFactoryMock->expects($this->never())
            ->method('create');

        $this->filterManagerMock->expects($this->never())
            ->method('apply');

        $this->secretTextFactoryMock->expects($this->never())
            ->method('create');

        $this->encode->encode([]);
    }
}
