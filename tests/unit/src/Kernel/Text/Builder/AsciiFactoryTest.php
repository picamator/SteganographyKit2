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

    protected function setUp()
    {
        parent::setUp();

        $this->objectManagerMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface')
            ->getMock();

        $this->asciiMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Text\Api\Data\AsciiInterface')
            ->getMock();

        $this->asciiFactory = new AsciiFactory($this->objectManagerMock);
    }

    public function testCreate()
    {
        $char = 'a';

        // object manager mock
        $this->objectManagerMock->expects($this->once())
            ->method('create')
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
