<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\Text\Builder;

use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;
use Picamator\SteganographyKit2\Kernel\Text\Builder\AsciiFactory;

class AsciiFactoryTest extends BaseTest
{
    /**
     * @var AsciiFactory
     */
    private $asciiFactory;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $objectManagerMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Text\Api\Data\AsciiInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $asciiMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\ByteFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $byteFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $byteMock;

    protected function setUp()
    {
        parent::setUp();

        $this->objectManagerMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface')
            ->getMock();

        $this->asciiMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\Data\AsciiInterface')
            ->getMock();

        $this->byteFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\ByteFactoryInterface')
            ->getMock();

        $this->byteMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\ByteInterface')
            ->getMock();

        $this->asciiFactory = new AsciiFactory($this->objectManagerMock, $this->byteFactoryMock);
    }

    public function testCreate()
    {
        $char = 'a';

        // byte factory mock
        $this->byteFactoryMock->expects($this->once())
            ->method('create')
            ->willReturn($this->byteMock);

        // object manager mock
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo('Picamator\SteganographyKit2\Kernel\Text\Data\Ascii'), $this->equalTo([$this->byteMock, $char]))
            ->willReturn($this->asciiMock);

        $this->asciiFactory->create($char);
        $this->asciiFactory->create($char); // double run to test cache
    }

    /**
     * @expectedException \Picamator\SteganographyKit2\Kernel\Exception\InvalidArgumentException
     */
    public function testFailCreate()
    {
        $char = 'test';

        $this->asciiFactory->create($char);
    }
}
