<?php
namespace Picamator\SteganographyKit2\Tests\Unit\Kernel\SecretText;

use Picamator\SteganographyKit2\Kernel\SecretText\InfoMarkFactory;
use Picamator\SteganographyKit2\Tests\Unit\Kernel\BaseTest;

class InfoMarkFactoryTest extends BaseTest
{
    /**
     * @var InfoMarkFactory
     */
    private $infoMarkFactory;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $objectManagerMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\SizeFactoryInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeFactoryMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $sizeMock;

    /**
     * @var \Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $infoMarkMock;

    protected function setUp()
    {
        parent::setUp();

        $this->objectManagerMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Util\Api\ObjectManagerInterface')
            ->getMock();

        $this->sizeFactoryMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Builder\SizeFactoryInterface')
            ->getMock();

        $this->sizeMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\Primitive\Api\Data\SizeInterface')
            ->getMock();

        $this->infoMarkMock = $this->getMockBuilder('Picamator\SteganographyKit2\Kernel\SecretText\Api\InfoMarkInterface')
            ->getMock();

        $this->infoMarkFactory = new InfoMarkFactory($this->objectManagerMock, $this->sizeFactoryMock);
    }

    public function testCreate()
    {
        $width = 1;
        $height = 10;

        // size factory mock
        $this->sizeFactoryMock->expects($this->once())
            ->method('create')
            ->with($this->equalTo($width), $this->equalTo($height))
            ->willReturn($this->sizeMock);

        // object manager mock
        $this->objectManagerMock->expects($this->once())
            ->method('create')
            ->willReturn($this->infoMarkMock);

        $this->infoMarkFactory->create($width, $height);
    }
}
